<div class="laqm-admin">

    <?php
    $data['templating']->render('admin/menu-top', $data);
    ?>

    <div class="laqm-content">

        <div class="laqm-item-navigation">
            <div class="laqm-item-back"><a class="laqm-btn laqm-btn-blue no-left-margin" href="?page=la_onionbuzz_dashboard">&larr; Back</a></div>
            <div class="laqm-item-name"><span><?=$data['edit_quiz']['title']?></span></div>
        </div>

        <div style="clear: both;"></div>

        <div class="laqm-alerts">
        </div>

        <div class="laqm-tabs-tools-container">

            <div class="laqm-tabs">
                <?php
                $data['templating']->render('admin/quiz-tabs', $data);
                ?>
            </div>
            <div class="laqm-tools">
                <div class="laqm-tools-item pull-right">
                    <a class="laqm-btn laqm-btn-blue with-icon" href="<?=$data['edit_quiz']['preview_link']?>" target="_blank"><span class="icon-ico-preview"></span></a>
                    <a class="laqm-btn laqm-btn-blue" href="#quiz/<?=$data['edit_quiz']['id']?>/shortcode">Shortcode</a>
                </div>
            </div>

            <div style="clear: both;"></div>

        </div>

        <?php if($data['edit_quiz']['type'] == 3 || $data['edit_quiz']['type'] == 4){ ?>
            <div class="container-add-form" data-question-id="0" style="display: none;">
                <div class="laqm-tab-content">
                <form class="form-horizontal form-ays">
                    <div class="form-group">
                        <label class="col-sm-3 control-label-left">Published</label>
                        <div class="col-sm-3">
                            <div class="switch">
                                <input id="question_published" name="question_published" class="cmn-toggle cmn-toggle-round-flat" type="checkbox" checked value="1">
                                <label for="question_published" data-on="Yes" data-off="No"></label>
                            </div>
                        </div>
                        <div class="col-sm-3 pull-right">
                            <a class="laqm-btn laqm-btn-green pull-right submit-add-form" data-question-id="0" href="javascript:void(0);">SAVE AND ADD</a>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label-left">Title</label>
                        <div class="col-sm-9">
                            <input name="question_title" type="text" class="form-control" value="">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label-left">Description</label>
                        <div class="col-sm-9">
                            <?php
                            $settings = array(
                                'textarea_rows' => 10,
                                'textarea_name' => 'question_description',
                                'media_buttons' => false,
                                'teeny'=> true,
                                'tinymce' => array(
                                    'theme_advanced_buttons1' => 'formatselect,|,bold,italic,underline,|,' .
                                        'bullist,blockquote,|,justifyleft,justifycenter' .
                                        ',justifyright,justifyfull,|,link,unlink,|' .
                                        ',spellchecker,wp_fullscreen,wp_adv'
                                )
                            );
                            wp_editor( '', 'question_description', $settings );
                            ?>
                        </div>
                    </div>
                    <?php if($data['edit_quiz']['type'] == 1 || $data['edit_quiz']['type'] == 2 || $data['edit_quiz']['type'] == 3){ ?>
                        <div class="form-group">
                            <label class="col-sm-3 control-label-left">Image<p class="help-block">Min width depends on your theme's page width</p></label>
                            <div class="col-sm-9">
                                <a class="laqm-item-image-add media_selector" href="javascript:void(0);" data-input-url="featured_image" data-input-attachment="attachment_id"></a>
                                <input name="featured_image" value="" type="hidden">
                                <input name="attachment_id" value="" type="hidden">
                                <a class="remove-featured-image-ajaxform" data-input-url="featured_image" data-input-attachment="attachment_id" href="javascript:void(0);">Remove</a>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label-left">Image caption</label>
                            <div class="col-sm-9">
                                <input name="question_image_caption" type="text" class="form-control" value="">
                            </div>
                        </div>
                    <?php } ?>
                    <?php if($data['edit_quiz']['type'] == 4){ ?>
                        <div class="form-group">
                            <label class="col-sm-3 control-label-left">Image Front Side<p class="help-block">Min width depends on your theme's page width</p></label>
                            <div class="col-sm-9">
                                <a class="laqm-item-image-add media_selector" href="javascript:void(0);" data-input-url="featured_image" data-input-attachment="attachment_id"></a>
                                <input name="featured_image" value="" type="hidden">
                                <input name="attachment_id" value="" type="hidden">
                                <a class="remove-featured-image-ajaxform" data-input-url="featured_image" data-input-attachment="attachment_id" href="javascript:void(0);">Remove</a>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label-left">Front Side Image caption</label>
                            <div class="col-sm-9">
                                <input name="question_image_caption" type="text" class="form-control" value="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label-left">Image Back Side<p class="help-block">Add image with the same height as front side image</p></label>
                            <div class="col-sm-9">
                                <a class="laqm-item-image-add media_selector" data-input-url="secondary_image" data-input-attachment="secondary_attachment_id" href="javascript:void(0);"></a>
                                <input name="secondary_image" value="" type="hidden">
                                <input name="secondary_attachment_id" value="" type="hidden">
                                <a class="remove-featured-image-ajaxform" data-input-url="secondary_image" data-input-attachment="secondary_attachment_id" href="javascript:void(0);">Remove</a>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label-left">Back Side Image caption</label>
                            <div class="col-sm-9">
                                <input name="secondary_image_caption" type="text" class="form-control" value="">
                            </div>
                        </div>
                    <?php } ?>

                </form>
                </div>
                <br/>
            </div>
        <?php } ?>

        <div class="laqm-tab-content">

            <div id="laqm-questions-list" class="laqm-items-list"></div>

        </div>

    </div>
</div>
<?php
$data['templating']->render('admin/templates/quiz', $data);
?>