<?php
namespace OBVQ_WpPluginAutoload\Core;

class OBVQ_Posttype{

    public function __construct()
    {

    }

    public function posttypes_init() {

        $oConfig = new OBVQ_Config();
        $configs = $oConfig->get();

        $labels = array(
            'name'               => _x( $configs['onionbuzz_posttypes']['OB_POST_TYPE_BREADCRUMB'], 'post type general name', 'your-plugin-textdomain' ),
            'singular_name'      => _x( 'OnionBuzz Story', 'post type singular name', 'your-plugin-textdomain' ),
            'menu_name'          => _x( 'OnionBuzz Story', 'admin menu', 'your-plugin-textdomain' ),
            'name_admin_bar'     => _x( 'OnionBuzz Story', 'add new on admin bar', 'your-plugin-textdomain' ),
            'add_new'            => _x( 'Add New', 'story', 'your-plugin-textdomain' ),
            'add_new_item'       => __( 'Add New OnionBuzz Story', 'your-plugin-textdomain' ),
            'new_item'           => __( 'New OnionBuzz Story', 'your-plugin-textdomain' ),
            'edit_item'          => __( 'Edit OnionBuzz Story', 'your-plugin-textdomain' ),
            'view_item'          => __( 'View OnionBuzz Story', 'your-plugin-textdomain' ),
            'all_items'          => __( 'All OnionBuzz Stories', 'your-plugin-textdomain' ),
            'search_items'       => __( 'Search OnionBuzz Stories', 'your-plugin-textdomain' ),
            'parent_item_colon'  => __( 'Parent OnionBuzz Stories:', 'your-plugin-textdomain' ),
            'not_found'          => __( 'No OnionBuzz Stories found.', 'your-plugin-textdomain' ),
            'not_found_in_trash' => __( 'No OnionBuzz Stories found in Trash.', 'your-plugin-textdomain' )
        );

        #echo $configs['onionbuzz_posttypes']['OB_POST_TYPE_SLUG'];

        $args = array(
            'labels'             => $labels,
            'description'        => __( 'Description.', 'your-plugin-textdomain' ),
            'public'             => true,
            'publicly_queryable' => true,
            'show_ui'            => false,
            'show_in_menu'       => true,
            'query_var'          => true,
            'rewrite'            => array( 'slug' => $configs['onionbuzz_posttypes']['OB_POST_TYPE_SLUG'] ),
            'capability_type'    => 'post',
            'has_archive'        => true,
            'hierarchical'       => false,
            'menu_position'      => 5,
            'supports'           => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments' )
        );
        // https://codex.wordpress.org/Function_Reference/register_post_type
        register_post_type( $configs['onionbuzz_posttypes']['OB_POST_TYPE_SLUG'], $args );
    }

    public function taxonomies_init() {

        $oConfig = new OBVQ_Config();
        $configs = $oConfig->get();

        // Add new taxonomy, make it hierarchical (like categories)

        $labels = array(
            'name'              => _x( 'OnionBuzz Feeds', 'taxonomy general name', 'textdomain' ),
            'singular_name'     => _x( 'OnionBuzz Feed', 'taxonomy singular name', 'textdomain' ),
            'search_items'      => __( 'Search OnionBuzz Feeds', 'textdomain' ),
            'all_items'         => __( 'All OnionBuzz Feeds', 'textdomain' ),
            'parent_item'       => __( 'Parent OnionBuzz Feed', 'textdomain' ),
            'parent_item_colon' => __( 'Parent OnionBuzz Feed:', 'textdomain' ),
            'edit_item'         => __( 'Edit OnionBuzz Feed', 'textdomain' ),
            'update_item'       => __( 'Update OnionBuzz Feed', 'textdomain' ),
            'add_new_item'      => __( 'Add New OnionBuzz Feed', 'textdomain' ),
            'new_item_name'     => __( 'New OnionBuzz Feed Name', 'textdomain' ),
            'menu_name'         => __( 'OnionBuzz Feeds', 'textdomain' ),
        );

        $args = array(
            'hierarchical'      => true,
            'labels'            => $labels,
            'show_ui'           => false,
            'show_admin_column' => true,
            'query_var'         => true,
            'rewrite'           => array( 'slug' => $configs['onionbuzz_posttypes']['OB_TAXONOMY_SLUG'] ),
        );
        // https://codex.wordpress.org/Function_Reference/register_taxonomy
        register_taxonomy( $configs['onionbuzz_posttypes']['OB_TAXONOMY_NAME'], array( $configs['onionbuzz_posttypes']['OB_POST_TYPE_NAME'] ), $args );

        // Add new taxonomy, NOT hierarchical (like tags)
        /*$labels = array(
            'name'                       => _x( 'Tags', 'taxonomy general name', 'textdomain' ),
            'singular_name'              => _x( 'Tag', 'taxonomy singular name', 'textdomain' ),
            'search_items'               => __( 'Search tags', 'textdomain' ),
            'popular_items'              => __( 'Popular Writers', 'textdomain' ),
            'all_items'                  => __( 'All Writers', 'textdomain' ),
            'parent_item'                => null,
            'parent_item_colon'          => null,
            'edit_item'                  => __( 'Edit Writer', 'textdomain' ),
            'update_item'                => __( 'Update Writer', 'textdomain' ),
            'add_new_item'               => __( 'Add New Writer', 'textdomain' ),
            'new_item_name'              => __( 'New Writer Name', 'textdomain' ),
            'separate_items_with_commas' => __( 'Separate writers with commas', 'textdomain' ),
            'add_or_remove_items'        => __( 'Add or remove writers', 'textdomain' ),
            'choose_from_most_used'      => __( 'Choose from the most used writers', 'textdomain' ),
            'not_found'                  => __( 'No writers found.', 'textdomain' ),
            'menu_name'                  => __( 'Writers', 'textdomain' ),
        );

        $args = array(
            'hierarchical'          => false,
            'labels'                => $labels,
            'show_ui'               => true,
            'show_admin_column'     => true,
            'update_count_callback' => '_update_post_term_count',
            'query_var'             => true,
            'rewrite'               => array( 'slug' => 'writer' ),
        );

        register_taxonomy( 'writer', 'quiz', $args );*/
        flush_rewrite_rules();
    }

}