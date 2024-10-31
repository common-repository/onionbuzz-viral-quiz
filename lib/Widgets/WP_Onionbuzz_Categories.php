<?php

namespace OBVQ_WpPluginAutoload\Widgets;

use OBVQ_WpPluginAutoload\Core\OBVQ_Config;
/**
 * Widget API: WP_Onionbuzz_Categories class
 *
 * @package Onionbuzz
 * @subpackage Widgets
 * @since 1.0.0
 */

class WP_Onionbuzz_Categories extends \WP_Widget {

    private $configs;

    /**
     * Sets up a new Categories widget instance.
     */
    public function __construct() {

        $oConfig = new OBVQ_Config();
        $this->configs = $oConfig->get();

        $widget_ops = array(
            'classname' => 'widget_categories',
            'description' => __( 'A list or dropdown of categories.' ),
            'customize_selective_refresh' => true,
        );
        parent::__construct( 'widget_onionbuzz_categories', __( 'Onionbuzz Categories' ), $widget_ops );
    }

    /**
     * Outputs the content for the current Categories widget instance.
     *
     * @since 1.0.0
     * @access public
     *
     * @param array $args     Display arguments including 'before_title', 'after_title',
     *                        'before_widget', and 'after_widget'.
     * @param array $instance Settings for the current Categories widget instance.
     */
    public function widget( $args, $instance ) {
        static $first_dropdown = true;

        /** This filter is documented in wp-includes/widgets/class-wp-widget-pages.php */
        $title = apply_filters( 'widget_title', empty( $instance['title'] ) ? __( 'Categories' ) : $instance['title'], $instance, $this->id_base );

        $taxonomy = empty( $instance['taxonomy'] ) ? $this->configs['onionbuzz_posttypes']['OB_TAXONOMY_NAME'] : $instance['taxonomy'];
        $number = ! empty( $instance['number'] ) ? $instance['number'] : '';

        $c = ! empty( $instance['count'] ) ? '1' : '0';
        $h = ! empty( $instance['hierarchical'] ) ? '1' : '0';
        $d = ! empty( $instance['dropdown'] ) ? '1' : '0';

        echo $args['before_widget'];
        if ( $title ) {
            echo $args['before_title'] . $title . $args['after_title'];
        }

        $cat_args = array(
            'orderby'      => 'name',
            'show_count'   => $c,
            'hierarchical' => $h,
            'taxonomy'   => $taxonomy,
            'number' => $number
        );

        if ( $d ) {
            $dropdown_id = ( $first_dropdown ) ? 'cat' : "{$this->id_base}-dropdown-{$this->number}";
            $first_dropdown = false;

            echo '<label class="screen-reader-text" for="' . esc_attr( $dropdown_id ) . '">' . $title . '</label>';

            $cat_args['show_option_none'] = __( 'Select Category' );
            $cat_args['id'] = $dropdown_id;

            /**
             * Filters the arguments for the Categories widget drop-down.
             *
             * @since 1.0.0
             *
             * @see wp_dropdown_categories()
             *
             * @param array $cat_args An array of Categories widget drop-down arguments.
             */
            wp_dropdown_categories( apply_filters( 'widget_categories_dropdown_args', $cat_args ) );
            ?>

            <script type='text/javascript'>
                /* <![CDATA[ */
                (function() {
                    var dropdown = document.getElementById( "<?php echo esc_js( $dropdown_id ); ?>" );
                    function onCatChange() {
                        if ( dropdown.options[ dropdown.selectedIndex ].value > 0 ) {
                            location.href = "<?php echo home_url(); ?>/?cat=" + dropdown.options[ dropdown.selectedIndex ].value;
                        }
                    }
                    dropdown.onchange = onCatChange;
                })();
                /* ]]> */
            </script>

            <?php
        } else {
            ?>
            <ul>
                <?php
                $cat_args['title_li'] = '';

                /**
                 * Filters the arguments for the Categories widget.
                 *
                 * @since 1.0.0
                 *
                 * @param array $cat_args An array of Categories widget options.
                 */
                wp_list_categories( apply_filters( 'widget_categories_args', $cat_args ) );
                ?>
            </ul>
            <?php
        }

        echo $args['after_widget'];
    }

    /**
     * Handles updating settings for the current Categories widget instance.
     *
     * @since 1.0.0
     * @access public
     *
     * @param array $new_instance New settings for this instance as input by the user via
     *                            WP_Widget::form().
     * @param array $old_instance Old settings for this instance.
     * @return array Updated settings to save.
     */
    public function update( $new_instance, $old_instance ) {
        $instance = $old_instance;
        $instance['title'] = sanitize_text_field( $new_instance['title'] );
        $instance['taxonomy'] = sanitize_text_field( $new_instance['taxonomy'] );
        $instance['number'] = !empty($new_instance['number']) ? $new_instance['number'] : '';
        $instance['count'] = !empty($new_instance['count']) ? 1 : 0;
        $instance['hierarchical'] = !empty($new_instance['hierarchical']) ? 1 : 0;
        $instance['dropdown'] = !empty($new_instance['dropdown']) ? 1 : 0;

        return $instance;
    }

    /**
     * Outputs the settings form for the Categories widget.
     *
     * @since 1.0.0
     * @access public
     *
     * @param array $instance Current settings.
     */
    public function form( $instance ) {
        //Defaults
        $instance = wp_parse_args( (array) $instance, array( 'title' => '') );
        $title = sanitize_text_field( $instance['title'] );
        $taxonomy = sanitize_text_field( $instance['taxonomy'] );
        $number    = isset( $instance['number'] ) ? absint( $instance['number'] ) : 5;
        $count = isset($instance['count']) ? (bool) $instance['count'] :false;
        $hierarchical = isset( $instance['hierarchical'] ) ? (bool) $instance['hierarchical'] : false;
        $dropdown = isset( $instance['dropdown'] ) ? (bool) $instance['dropdown'] : false;
        ?>
        <p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e( 'Title:' ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" placeholder="<?php esc_attr_e( 'Categories' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" /></p>

        <p><label for="<?php echo $this->get_field_id('taxonomy'); ?>"><?php _e( 'Taxonomy:' ); ?></label>
            <input placeholder="Default: <?=$this->configs['onionbuzz_posttypes']['OB_TAXONOMY_NAME']?>" class="widefat" id="<?php echo $this->get_field_id('taxonomy'); ?>" name="<?php echo $this->get_field_name('taxonomy'); ?>" placeholder="<?php esc_attr_e( 'Taxonomy' ); ?>" type="text" value="<?php echo esc_attr( $taxonomy ); ?>" /></p>

        <p><label for="<?php echo $this->get_field_id( 'number' ); ?>"><?php _e( 'Number of categories to show:' ); ?></label>
            <input class="tiny-text" id="<?php echo $this->get_field_id( 'number' ); ?>" name="<?php echo $this->get_field_name( 'number' ); ?>" type="number" step="1" min="1" value="<?php echo $number; ?>" size="3" /></p>


        <p><input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id('dropdown'); ?>" name="<?php echo $this->get_field_name('dropdown'); ?>"<?php checked( $dropdown ); ?> />
            <label for="<?php echo $this->get_field_id('dropdown'); ?>"><?php _e( 'Display as dropdown' ); ?></label><br />

            <input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id('count'); ?>" name="<?php echo $this->get_field_name('count'); ?>"<?php checked( $count ); ?> />
            <label for="<?php echo $this->get_field_id('count'); ?>"><?php _e( 'Show post counts' ); ?></label><br />

            <input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id('hierarchical'); ?>" name="<?php echo $this->get_field_name('hierarchical'); ?>"<?php checked( $hierarchical ); ?> />
            <label for="<?php echo $this->get_field_id('hierarchical'); ?>"><?php _e( 'Show hierarchy' ); ?></label></p>
        <?php
    }

}