<div class="laqm-admin">

    <?php
    $data['templating']->render('admin/menu-top', $data);
    ?>

    <div class="laqm-content floating-area">

        <div class="laqm-item-navigation">
            <div class="laqm-item-back"><a class="laqm-btn laqm-btn-blue no-left-margin" href="?page=la_onionbuzz_dashboard&tab=quiz_questions&quiz_id=<?=$data['edit_question']['quiz_id']?>">&larr; Back</a></div>
            <div class="laqm-item-name"><span><?=$data['edit_question']['page_title']?></span></div>
            <div class="laqm-item-nextprev pull-right">
                <?php if($data['prev_item']['id'] > 0){ ?>
                    <a class="laqm-btn laqm-btn-blue with-icon" href="?page=la_onionbuzz_dashboard&tab=quiz_question_edit&quiz_id=<?=$data['edit_question']['quiz_id']?>&question_id=<?=$data['prev_item']['id']?>"><span class="icon-arrow-left"></span></a>
                <?php } ?>
                <?php if($data['next_item']['id'] > 0){ ?>
                    <a class="laqm-btn laqm-btn-blue with-icon" href="?page=la_onionbuzz_dashboard&tab=quiz_question_edit&quiz_id=<?=$data['edit_question']['quiz_id']?>&question_id=<?=$data['next_item']['id']?>"><span class="icon-arrow-right"></span></a>
                <?php } ?>
            </div>
        </div>

        <div style="clear: both;"></div>

        <div class="laqm-breadcrumbs-container">
            <a href="?page=la_onionbuzz_dashboard">Stories</a>
            <span>&rarr;</span>
            <a href="?page=la_onionbuzz_dashboard&tab=quiz_edit&quiz_id=<?=$data['quiz_info']['id']?>"><?=$data['quiz_info']['title']?></a>
            <span>&rarr;</span>
            <?=$data['edit_question']['page_title']?>
        </div>

        <div class="laqm-tabs-tools-container">

            <div class="laqm-tabs">
                <div class="laqm-tab-item switch-subtab active" data-tabs-group="quiz_question_answers_match" data-subtab="quiz_question_edit">
                    <?php if($data['quiz_info']['type'] == 3 || $data['quiz_info']['type'] == 4){ ?>
                        <a class="laqm-tab-item-link" href="#">Edit item</a>
                    <?php } else {?>
                    <a class="laqm-tab-item-link" href="#">Edit question</a>
                    <?php } ?>
                </div>
                <?php if($data['quiz_info']['type'] == 1 || $data['quiz_info']['type'] == 2 || $data['quiz_info']['type'] == 5){ ?>
                    <?php if($data['edit_question']['id'] > 0){?>
                        <div class="laqm-tab-item "  data-subtab="quiz_question_answers">
                            <a class="laqm-tab-item-link" href="?page=la_onionbuzz_dashboard&tab=quiz_question_answers&question_id=<?=$data['edit_question']['id']?>&quiz_id=<?=$data['edit_question']['quiz_id']?>">Answers (<?=$data['edit_question']['answers_count']?>)</a>
                            <div class="pull-right">
                                <a class="laqm-btn laqm-btn-txt-large laqm-btn-blue" href="?page=la_onionbuzz_dashboard&tab=quiz_question_answer_edit&question_id=<?=$data['edit_question']['id']?>&quiz_id=<?=$data['edit_question']['quiz_id']?>"><span class="icon-ico-add"></span></a>
                            </div>
                        </div>
                    <?php } else {?>
                        <div class="laqm-tab-item disabled" data-subtab="quiz_question_answers">
                            <a class="laqm-tab-item-link " href="javascript:void(0);" title="Save question first">Answers (0)</a>
                        </div>
                    <?php } ?>
                    <div class="laqm-tab-item switch-subtab" data-tabs-group="quiz_question_answers_match" data-subtab="quiz_question_answers_match" style="display: none;">
                        <a class="laqm-tab-item-link" href="javascript:void(0);">Answers</a>
                    </div>
                <?php } ?>
            </div>
            <div class="laqm-tools floating-this">
                <div class="laqm-tools-item pull-right">
                    <a class="laqm-btn laqm-btn-green" href="#question/<?=$data['edit_question']['id']?>/save">Save</a>
                </div>
            </div>

            <div style="clear: both;"></div>

        </div>

        <div class="laqm-tab-content" data-tabs-group="quiz_question_answers_match" data-subtab-content="quiz_question_edit">

            <div class="laqm-edit-tab edit-general container-add-form" data-content="edit-general">

                <form class="form-horizontal form-ays">
                    <div class="form-group">
                        <label class="col-sm-3 control-label-left">Published</label>
                        <div class="col-sm-3">
                            <div class="switch">
                                <input id="question_published" name="question_published" class="cmn-toggle cmn-toggle-round-flat" type="checkbox" <?=($data['edit_question']['flag_publish'] == 1 || !$data['edit_question']['id'])?'checked':''?> value="<?=$data['edit_question']['flag_publish']?>">
                                <label for="question_published" data-on="Yes" data-off="No"></label>
                            </div>
                        </div>
                    </div>
                    <?php if($data['quiz_info']['type'] == 1 || $data['quiz_info']['type'] == 2 || $data['quiz_info']['type'] == 5){ ?>
                    <div class="form-group">
                        <label class="col-sm-3 control-label-left">Answers type</label>
                        <div class="col-sm-3">
                            <select id="answers_type" name="answers_type" class="form-control laqm-select-default">
                                <option value="list" <?=($data['edit_question']['answers_type'] == 'list')?'selected':''?>>List (no images)</option>
                                <option value="mediagrid" <?=($data['edit_question']['answers_type'] == 'mediagrid')?'selected':''?>>Grid</option>
                                <?php if($data['quiz_info']['type'] == 1){ ?>
                                    <option value="match" <?=($data['edit_question']['answers_type'] == 'match')?'selected':''?>>Match</option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <?php } ?>
                    <div id="mediagrid_selector" class="form-group" style="display: none;">
                        <label class="col-sm-3 control-label-left"></label>
                        <div class="col-sm-3">
                            <select id="mediagrid_type" name="mediagrid_type" class="form-control laqm-select-default">
                                <option value="flex1" <?=($data['edit_question']['mediagrid_type'] == 'flex1')?'selected':''?>>1 in row</option>
                                <option value="flex2" <?=($data['edit_question']['mediagrid_type'] == 'flex2')?'selected':''?>>2 in row</option>
                                <option value="flex3" <?=($data['edit_question']['mediagrid_type'] == 'flex3')?'selected':''?>>3 in row</option>
                                <option value="flex4" <?=($data['edit_question']['mediagrid_type'] == 'flex4')?'selected':''?>>4 in row</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label-left">Title</label>
                        <div class="col-sm-9">
                            <input name="question_title" type="text" class="form-control" value="<?=esc_html($data['edit_question']['title'])?>">
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
                            wp_editor( (isset($data['edit_question']['description'])?$data['edit_question']['description']:''), 'question_description', $settings );
                            ?>
                        </div>
                    </div>
                    <?php if($data['quiz_info']['type'] == 1 || $data['quiz_info']['type'] == 2 || $data['quiz_info']['type'] == 3 || $data['quiz_info']['type'] == 5){ ?>
                    <div class="form-group">
                        <label class="col-sm-3 control-label-left">Image<p class="help-block">Min width depends on your theme's page width</p></label>
                        <div class="col-sm-9">
                            <a id="media_test" class="laqm-item-image-add" href="#" <?=(isset($data['edit_question']['featured_image']) && $data['edit_question']['featured_image'] != '')?'style="background-image: url('.$data['edit_question']['featured_image'].');"':''?>>
                            </a>
                            <input name="featured_image" value="<?=$data['edit_question']['featured_image']?>" type="hidden">
                            <input name="attachment_id" value="" type="hidden">
                            <a class="remove-featured-image" href="javascript:void(0);">Remove</a>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label-left">Image caption</label>
                        <div class="col-sm-9">
                            <input name="question_image_caption" type="text" class="form-control" value="<?=esc_html($data['edit_question']['image_caption'])?>">
                        </div>
                    </div>
                    <?php } ?>
                    <?php if($data['quiz_info']['type'] == 4){ ?>
                        <div class="form-group">
                            <label class="col-sm-3 control-label-left">Image Front Side<p class="help-block">Min width depends on your theme's page width</p></label>
                            <div class="col-sm-9">
                                <a id="media_test" class="laqm-item-image-add" href="#" <?=(isset($data['edit_question']['featured_image']) && $data['edit_question']['featured_image'] != '')?'style="background-image: url('.$data['edit_question']['featured_image'].');"':''?>>
                                </a>
                                <input name="featured_image" value="<?=$data['edit_question']['featured_image']?>" type="hidden">
                                <input name="attachment_id" value="" type="hidden">
                                <a class="remove-featured-image" href="javascript:void(0);">Remove</a>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label-left">Front Side Image caption</label>
                            <div class="col-sm-9">
                                <input name="question_image_caption" type="text" class="form-control" value="<?=esc_html($data['edit_question']['image_caption'])?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label-left">Image Back Side<p class="help-block">Add image with the same height as front side image</p></label>
                            <div class="col-sm-9">
                                <a class="laqm-item-image-add media_selector" data-input-url="secondary_image" data-input-attachment="secondary_attachment_id" href="javascript:void(0);" <?=(isset($data['edit_question']['secondary_image']) && $data['edit_question']['secondary_image'] != '')?'style="background-image: url('.$data['edit_question']['secondary_image'].');"':''?>></a>
                                <input name="secondary_image" value="<?=$data['edit_question']['secondary_image']?>" type="hidden">
                                <input name="secondary_attachment_id" value="" type="hidden">
                                <a class="remove-featured-image-ajaxform" data-input-url="secondary_image" data-input-attachment="secondary_attachment_id" href="javascript:void(0);">Remove</a>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label-left">Back Side Image caption</label>
                            <div class="col-sm-9">
                                <input name="secondary_image_caption" type="text" class="form-control" value="<?=esc_html($data['edit_question']['secondary_image_caption'])?>">
                            </div>
                        </div>
                    <?php } ?>

                </form>

            </div>

        </div>

        <div class="laqm-tab-content" data-tabs-group="quiz_question_answers_match" data-subtab-content="quiz_question_answers_match" style="display: none;">

            <div class="laqm-setting-tab settings-general" data-content="settings-general">
                <form class="form-horizontal form-ays">

                    <?php if($data['quiz_info']['type'] == 1){ ?>
                        <div class="form-group">
                            <label class="col-sm-3 control-label-left">Correct Answer<p class="help-block">Separate multiple answers with commas</p></label>
                            <div class="col-sm-9">
                                <input name="question_match_answers" type="text" class="form-control" value="<?=esc_html($data['edit_question']['answers_string'])?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label-left">Case sensitive<p class="help-block"></p></label>
                            <div class="col-sm-3">
                                <div class="switch">
                                    <input id="flag_casesensitive" name="flag_casesensitive" class="cmn-toggle cmn-toggle-round-flat" type="checkbox" <?=($data['edit_question']['flag_casesensitive'] == 1)?'checked':''?> value="<?=$data['edit_question']['flag_casesensitive']?>">
                                    <label for="flag_casesensitive" data-on="Yes" data-off="No"></label>
                                </div>
                            </div>
                        </div>
                    <?php } else {?>
                        <input name="answer_status" value="0" type="hidden">
                    <?php } ?>

                </form>
            </div>
        </div>

        <?php if($data['quiz_info']['type'] == 1 || $data['quiz_info']['type'] == 2){ ?>
        <div class="laqm-tabs-tools-container secondary" data-tabs-group="quiz_question_explanatioin">

            <div class="laqm-tabs">
                <div class="laqm-tab-item active">
                    <a class="laqm-tab-item-link" href="javascript:void(0);">Explanation</a>
                </div>
            </div>

            <div style="clear: both;"></div>

        </div>

        <div class="laqm-tab-content secondary" data-tabs-group="quiz_question_explanatioin">

            <div class="laqm-setting-tab settings-general" data-content="settings-general">
                <form class="form-horizontal form-ays">

                    <div class="form-group">
                        <label class="col-sm-3 control-label-left">Show explanation after any answer<p class="help-block"></p></label>
                        <div class="col-sm-9">
                            <div class="switch">
                                <input id="cmn-toggle-1" name="question_flag_explanation" class="cmn-toggle cmn-toggle-round-flat" type="checkbox" <?=($data['edit_question']['flag_explanation'] == 1)?'checked':''?> value="<?=$data['edit_question']['flag_explanation']?>">
                                <label for="cmn-toggle-1" data-on="Yes" data-off="No"></label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label-left">Explanation title
                            <?php if($data['quiz_info']['type'] == 1){ ?>
                                <p class="help-block">‘Wrong!’ or ‘Correct!’ will be added before the title.</p>
                            <?php } ?>
                        </label>
                        <div class="col-sm-9">
                            <input name="question_explanation_title" type="text" class="form-control" value="<?=esc_html($data['edit_question']['explanation_title'])?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label-left">Explanation description</label>
                        <div class="col-sm-9">
                            <?php
                            $settings = array(
                                'textarea_rows' => 10,
                                'textarea_name' => 'question_explanation',
                                'media_buttons' => false,
                                'teeny'=> true,
                                'tinymce' => array(
                                    'theme_advanced_buttons1' => 'formatselect,|,bold,italic,underline,|,' .
                                        'bullist,blockquote,|,justifyleft,justifycenter' .
                                        ',justifyright,justifyfull,|,link,unlink,|' .
                                        ',spellchecker,wp_fullscreen,wp_adv'
                                )
                            );
                            wp_editor( (isset($data['edit_question']['explanation'])?$data['edit_question']['explanation']:''), 'question_explanation', $settings );
                            ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label-left">Explanation image<p class="help-block">Min width depends on your theme's page width</p></label>
                        <div class="col-sm-9">
                            <a id="media_explorer_explanation" class="laqm-item-image-add" href="#" <?=(isset($data['edit_question']['explanation_image']) && $data['edit_question']['explanation_image'] != '')?'style="background-image: url('.$data['edit_question']['explanation_image'].');"':''?>>
                            </a>
                            <input name="explanation_image" value="<?=$data['edit_question']['explanation_image']?>" type="hidden">
                            <input name="explanation_attachment_id" value="" type="hidden">
                            <a class="remove-explanation-image" href="javascript:void(0);">Remove</a>
                        </div>
                    </div>


                </form>
            </div>
        </div>
        <?php } ?>

    </div>
</div>