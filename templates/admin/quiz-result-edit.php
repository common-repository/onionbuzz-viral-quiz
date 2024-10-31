<div class="laqm-admin">

    <?php
    $data['templating']->render('admin/menu-top', $data);
    ?>

    <div class="laqm-content floating-area">

        <div class="laqm-item-navigation">
            <div class="laqm-item-back"><a class="laqm-btn laqm-btn-blue no-left-margin" href="?page=la_onionbuzz_dashboard&tab=quiz_results&quiz_id=<?=$data['edit_result']['quiz_id']?>">&larr; Back</a></div>
            <div class="laqm-item-name"><span><?=$data['edit_result']['page_title']?></span></div>
            <div class="laqm-item-nextprev pull-right">
                <?php if($data['prev_item']['id'] > 0){ ?>
                    <a class="laqm-btn laqm-btn-blue with-icon" href="?page=la_onionbuzz_dashboard&tab=quiz_result_edit&quiz_id=<?=$data['edit_result']['quiz_id']?>&result_id=<?=$data['prev_item']['id']?>"><span class="icon-arrow-left"></span></a>
                <?php } ?>
                <?php if($data['next_item']['id'] > 0){ ?>
                    <a class="laqm-btn laqm-btn-blue with-icon" href="?page=la_onionbuzz_dashboard&tab=quiz_result_edit&quiz_id=<?=$data['edit_result']['quiz_id']?>&result_id=<?=$data['next_item']['id']?>"><span class="icon-arrow-right"></span></a>
                <?php } ?>
            </div>
        </div>

        <div style="clear: both;"></div>

        <div class="laqm-breadcrumbs-container">
            <a href="?page=la_onionbuzz_dashboard">Stories</a>
            <span>&rarr;</span>
            <a href="?page=la_onionbuzz_dashboard&tab=quiz_edit&quiz_id=<?=$data['quiz_info']['id']?>"><?=$data['quiz_info']['title']?></a>
            <span>&rarr;</span>
            Result: <?=$data['edit_result']['page_title']?>
        </div>

        <div class="laqm-tabs-tools-container">

            <div class="laqm-tabs">
                <div class="laqm-tab-item">
                    <a class="laqm-tab-item-link" href="?page=la_onionbuzz_dashboard&tab=quiz_results&quiz_id=<?=$data['edit_result']['quiz_id']?>">Results (<?=$data['edit_result']['results_count']?>)</a>
                    <div class="pull-right">
                        <a class="laqm-btn laqm-btn-txt-large laqm-btn-blue" href="?page=la_onionbuzz_dashboard&tab=quiz_result_edit&quiz_id=<?=$data['edit_result']['quiz_id']?>"><span class="icon-ico-add"></span></a>
                    </div>
                </div>
                <div class="laqm-tab-item active">
                    <a class="laqm-tab-item-link" href="#">Edit result</a>

                </div>
            </div>
            <div class="laqm-tools floating-this">
                <div class="laqm-tools-item pull-right">
                    <a class="laqm-btn laqm-btn-green" href="#result/<?=$data['edit_result']['id']?>/save">Save</a>
                </div>
            </div>

            <div style="clear: both;"></div>

        </div>

        <div class="laqm-tab-content">

            <div class="laqm-edit-tab edit-general" data-content="edit-general">

                <form class="form-horizontal form-ays">
                    <div class="form-group">
                        <label class="col-sm-3 control-label-left">Published</label>
                        <div class="col-sm-3">
                            <div class="switch">
                                <input id="result_published" name="result_published" class="cmn-toggle cmn-toggle-round-flat" type="checkbox" <?=($data['edit_result']['flag_published'] == 1 || !$data['edit_result']['id'])?'checked':''?> value="<?=$data['edit_result']['flag_published']?>">
                                <label for="result_published" data-on="Yes" data-off="No"></label>
                            </div>
                        </div>
                    </div>
                    <?php if($data['quiz_info']['type'] == 1){?>
                    <div class="form-group">
                        <label class="col-sm-3 control-label-left">MAX. SCORE IN %<p class="help-block">Set top range of correct answers for this result in %. <a href="http://onionbuzz.com/doc/trivia/" target="_blank">Guide</a></p></label>
                        <div class="col-sm-1">
                            <input name="result_conditions" type="text" class="form-control" value="<?=$data['edit_result']['conditions']?>">
                        </div>
                    </div>
                    <?php } ?>
                    <?php if($data['quiz_info']['type'] == 5){?>
                        <div class="form-group">
                            <label class="col-sm-3 control-label-left">SELECTED ANSWERS IN % (LESS THAN)<p class="help-block">Specify maximum amount of user selected answers to match this result. <a href="http://onionbuzz.com/doc/checklist/" target="_blank">Guide</a></p></label>
                            <div class="col-sm-1">
                                <input name="result_conditions" type="text" class="form-control" value="<?=$data['edit_result']['conditions']?>">
                            </div>
                        </div>
                    <?php } ?>
                    <div class="form-group">
                        <label class="col-sm-3 control-label-left">Title *</label>
                        <div class="col-sm-9">
                            <input name="result_title" type="text" class="form-control" value="<?=esc_html($data['edit_result']['title'])?>" required="required">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label-left">Description</label>
                        <div class="col-sm-9">
                            <?php
                            $settings = array(
                                'textarea_rows' => 10,
                                'textarea_name' => 'result_description',
                                'media_buttons' => false,
                                'teeny'=> true,
                                'tinymce' => array(
                                    'theme_advanced_buttons1' => 'formatselect,|,bold,italic,underline,|,' .
                                        'bullist,blockquote,|,justifyleft,justifycenter' .
                                        ',justifyright,justifyfull,|,link,unlink,|' .
                                        ',spellchecker,wp_fullscreen,wp_adv'
                                )
                            );
                            wp_editor( (isset($data['edit_result']['description'])?$data['edit_result']['description']:''), 'result_description', $settings );
                            ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label-left">Image<p class="help-block">Min width depends on your theme's page width</p></label>
                        <div class="col-sm-9">
                            <a id="media_test" class="laqm-item-image-add" href="#" <?=(isset($data['edit_result']['featured_image']) && $data['edit_result']['featured_image'] != '')?'style="background-image: url('.$data['edit_result']['featured_image'].');"':''?>>
                            </a>
                            <input name="featured_image" value="<?=$data['edit_result']['featured_image']?>" type="hidden">
                            <input name="attachment_id" value="" type="hidden">
                            <a class="remove-featured-image" href="javascript:void(0);">Remove</a>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label-left">Image caption</label>
                        <div class="col-sm-9">
                            <input name="result_image_caption" type="text" class="form-control" value="<?=esc_html($data['edit_result']['image_caption'])?>">
                        </div>
                    </div>

                </form>

            </div>

        </div>

    </div>
</div>