<div class="laqm-admin">

    <?php
    $data['templating']->render('admin/menu-top', $data);
    ?>

    <div class="laqm-content floating-area">

        <div class="laqm-item-navigation">
            <div class="laqm-item-back"><a class="laqm-btn laqm-btn-blue no-left-margin" href="?page=la_onionbuzz_dashboard">&larr; Back</a></div>
            <div class="laqm-item-name"><span><?=$data['edit_quiz']['page_title']?></span></div>
        </div>

        <div class="laqm-tabs-tools-container">

            <div class="laqm-tabs">
                <?php
                $data['templating']->render('admin/quiz-tabs', $data);
                ?>
            </div>
            <div class="laqm-tools floating-this">
                <div class="laqm-tools-item pull-right">
                    <?php if($data['edit_quiz']['id'] > 0){?>
                    <a class="laqm-btn laqm-btn-blue with-icon" href="<?=$data['edit_quiz']['preview_link']?>" target="_blank"><span class="icon-ico-preview"></span></a>
                    <a class="laqm-btn laqm-btn-blue" href="#quiz/<?=$data['edit_quiz']['id']?>/shortcode">Shortcode</a>
                    <?php } ?>
                    <a class="laqm-btn laqm-btn-green" href="#quiz/<?=$data['edit_quiz']['id']?>/save">Save</a>
                    <a class="laqm-btn with-icon" href="?page=la_onionbuzz_dashboard"><span class="icon-ico-close"></span></a>
                </div>
            </div>

            <div style="clear: both;"></div>

        </div>

        <div class="laqm-tab-content">

            <div class="laqm-edit-tab edit-general" data-content="edit-general">

                <form id="form_edit_quiz" class="form-horizontal form-ays">
                    <div class="form-group">
                        <label class="col-sm-3 control-label-left">Published</label>
                        <div class="col-sm-3">
                            <div class="switch">
                                <input id="quiz_published" name="quiz_published" class="cmn-toggle cmn-toggle-round-flat" type="checkbox" <?=(@$data['edit_quiz']['flag_published'] == 1)?'checked':''?> value="<?=(isset($data['edit_quiz']['flag_published'])?$data['edit_quiz']['flag_published']:'')?>">
                                <label for="quiz_published" data-on="Yes" data-off="No"></label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group" >
                        <label class="col-sm-3 control-label-left">Kind</label>
                        <div class="col-sm-9">
                            <select id="quiz_type" name="quiz_type" class="form-control laqm-select-default" style="display: none;">
                                <option value="1" <?=(isset($data['edit_quiz']['type']) && $data['edit_quiz']['type'] == 1)?'selected':''?>>Trivia Quiz (true\false)</option>
                                <option value="2" <?=(isset($data['edit_quiz']['type']) && $data['edit_quiz']['type'] == 2)?'selected':''?>>Personality Quiz</option>
                                <option value="3" <?=(isset($data['edit_quiz']['type']) && $data['edit_quiz']['type'] == 3)?'selected':''?>>List\Ranked List</option>
                                <option value="4" <?=(isset($data['edit_quiz']['type']) && $data['edit_quiz']['type'] == 4)?'selected':''?>>Flip Cards</option>
                                <option value="5" <?=(isset($data['edit_quiz']['type']) && $data['edit_quiz']['type'] == 5)?'selected':''?>>Checklist</option>
                            </select>
                            <?php
                            if(isset($data['edit_quiz']['type'])){
                                if($data['edit_quiz']['type'] == 1){
                                    echo "Trivia Quiz ";
                                    echo '<a href="http://onionbuzz.com/doc/trivia/" target="_blank">Guide</a>';
                                }
                                if($data['edit_quiz']['type'] == 2){
                                    echo "Personality Quiz ";
                                    echo '<a href="http://onionbuzz.com/doc/personality/" target="_blank">Guide</a>';
                                }
                                if($data['edit_quiz']['type'] == 3){
                                    echo "List\Ranked List ";
                                }
                                if($data['edit_quiz']['type'] == 4){
                                    echo "Flip Cards ";
                                }
                                if($data['edit_quiz']['type'] == 5){
                                    echo "Checklist ";
                                    echo '<a href="http://onionbuzz.com/doc/checklist/" target="_blank">Guide</a>';
                                }
                            }
                            ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label-left">Story layout</label>
                        <div class="col-sm-9">
                            <select id="quiz_layout" name="quiz_layout" class="form-control laqm-select-default">
                                <option value="fulllist" <?=(isset($data['edit_quiz']['layout']) && $data['edit_quiz']['layout'] == 'fulllist')?'selected':''?>>Full list</option>
                                <option value="slider" <?=(isset($data['edit_quiz']['layout']) && $data['edit_quiz']['layout'] == 'slider')?'selected':''?>>Slider</option>
                            </select>
                        </div>
                    </div>
                    <?php if($data['edit_quiz']['type'] == 3) { ?>
                    <div class="form-group">
                        <label class="col-sm-3 control-label-left">Ranked list</label>
                        <div class="col-sm-3">
                            <div class="switch">
                                <input id="flag_list_ranked" name="flag_list_ranked" class="cmn-toggle cmn-toggle-round-flat" type="checkbox" <?=(@$data['edit_quiz']['flag_list_ranked'] == 1)?'checked':''?> value="<?=(isset($data['edit_quiz']['flag_list_ranked'])?$data['edit_quiz']['flag_list_ranked']:'')?>">
                                <label for="flag_list_ranked" data-on="Yes" data-off="No"></label>
                            </div>
                        </div>
                    </div>
                    <?php } ?>
                    <div class="form-group">
                        <label class="col-sm-3 control-label-left">Title *</label>
                        <div class="col-sm-9">
                            <input name="quiz_title" type="text" class="form-control" required value="<?=esc_html($data['edit_quiz']['title'])?>" placeholder="Title of the story">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label-left">Description</label>
                        <div class="col-sm-9">
                            <?php
                            $settings = array(
                                'textarea_rows' => 10,
                                'textarea_name' => 'quiz_description',
                                'media_buttons' => false,
                                'teeny'=> true,
                                'tinymce' => array(
                                    'theme_advanced_buttons1' => 'formatselect,|,bold,italic,underline,|,' .
                                        'bullist,blockquote,|,justifyleft,justifycenter' .
                                        ',justifyright,justifyfull,|,link,unlink,|' .
                                        ',spellchecker,wp_fullscreen,wp_adv'
                                )
                            );
                            wp_editor( (isset($data['edit_quiz']['description'])?$data['edit_quiz']['description']:''), 'quiz_description', $settings );
                            ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label-left">Featured image<p class="help-block">Min width depends on your theme's page width</p></label>
                        <div class="col-sm-3">
                            <a id="media_test" class="laqm-item-image-add" href="#" <?=(isset($data['edit_quiz']['featured_image']) && $data['edit_quiz']['featured_image'] != '')?'style="background-image: url('.$data['edit_quiz']['featured_image'].');"':''?>>

                            </a>
                            <input name="featured_image" value="<?=(isset($data['edit_quiz']['featured_image']))?$data['edit_quiz']['featured_image']:''?>" type="hidden">
                            <input name="attachment_id" value="" type="hidden">
                            <a class="remove-featured-image" href="javascript:void(0);">Remove</a>
                        </div>
                        <div class="col-sm-3"></div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label-left">Image caption</label>
                        <div class="col-sm-9">
                            <input name="quiz_image_caption" type="text" class="form-control" value="<?=esc_html((isset($data['edit_quiz']['image_caption']))?$data['edit_quiz']['image_caption']:'')?>" >
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label-left">Connected feeds</label>
                        <div class="row">
                            <div class="col-sm-8">
                            <?php
                            foreach ($data['feeds']['items'] as $k=>$v){
                                if($data['feeds']['items'][$k]['flag_main'] == 0){
                            ?>
                            <div class="col-sm-3">
                                <div class="checkbox icheck-info">
                                    <input class="quiz_feeds" name="quiz_feeds[]" type="checkbox" id="feed<?=$data['feeds']['items'][$k]['id']?>" data-term="<?=$data['feeds']['items'][$k]['term_id']?>" value="<?=$data['feeds']['items'][$k]['id']?>" <?=(@in_array($data['feeds']['items'][$k]['id'],$data['edit_quiz']['feeds']))?'checked':''?> />
                                    <label for="feed<?=$data['feeds']['items'][$k]['id']?>"><?=$data['feeds']['items'][$k]['title']?></label>
                                </div>
                            </div>
                            <?php
                                }
                            }
                            ?>
                            </div>
                        </div>
                    </div>

                </form>

            </div>

        </div>

        <?php if($data['edit_quiz']['type'] == 1 || $data['edit_quiz']['type'] == 2 || $data['edit_quiz']['type'] == 5){ ?>
        <div class="laqm-tabs-tools-container secondary">

            <div class="laqm-tabs">
                <div class="laqm-tab-item active">
                    <a class="laqm-tab-item-link" href="javascript:void(0);">Settings</a>
                </div>
            </div>

            <div style="clear: both;"></div>

        </div>

        <div class="laqm-tab-content secondary">

            <div class="laqm-setting-tab settings-general" data-content="settings-general">
                <form class="form-horizontal form-ays">

                    <?php if($data['edit_quiz']['type'] == 1){ ?>
                    <div class="form-group">
                        <label class="col-sm-3 control-label-left">Answer status<p class="help-block">When answer was given display the outcome to player</p></label>
                        <div class="col-sm-3">
                            <div class="switch">
                                <input id="answer_status" name="answer_status" class="cmn-toggle cmn-toggle-round-flat" type="checkbox" <?=($data['quiz_settings']['answer_status'] == 1)?'checked':''?> value="<?=$data['quiz_settings']['answer_status']?>">
                                <label for="answer_status" data-on="Yes" data-off="No"></label>
                            </div>
                        </div>
                    </div>
                    <?php } else {?>
                        <input name="answer_status" value="0" type="hidden">
                    <?php } ?>
                    <?php if($data['edit_quiz']['type'] == 1 || $data['edit_quiz']['type'] == 2 || $data['edit_quiz']['type'] == 5){ ?>
                    <div class="form-group">
                        <label class="col-sm-3 control-label-left">`Replay` button<p class="help-block"></p></label>
                        <div class="col-sm-3">
                            <div class="switch">
                                <input id="replay_button" name="replay_button" class="cmn-toggle cmn-toggle-round-flat" type="checkbox" <?=($data['quiz_settings']['replay_button'] == 1)?'checked':''?><?=(!isset($data['quiz_settings']['replay_button']))?'checked':''?> value="<?=$data['quiz_settings']['replay_button']?>">
                                <label for="replay_button" data-on="Yes" data-off="No"></label>
                            </div>
                        </div>
                    </div>
                    <?php } ?>

                </form>
            </div>
        </div>
        <?php } ?>
        <?php if($data['edit_quiz']['type'] == 3 || $data['edit_quiz']['type'] == 4){ ?>
            <input class="hidden" name="replay_button" value="1" type="checkbox" checked>
        <?php } ?>

        <div class="laqm-tabs-tools-container secondary">

            <div class="laqm-tabs">
                <div class="laqm-tab-item active">
                    <a class="laqm-tab-item-link" href="javascript:void(0);">Ordering & navigation</a>
                </div>
            </div>
            <div style="clear: both;"></div>

        </div>

        <div class="laqm-tab-content secondary">

            <div class="laqm-setting-tab settings-general" data-content="settings-general">

                <form class="form-horizontal form-ays">
                    <?php if($data['edit_quiz']['type'] == 1 || $data['edit_quiz']['type'] == 2 || $data['edit_quiz']['type'] == 5){ ?>
                    <div class="form-group">
                        <label class="col-sm-3 control-label-left">Questions order</label>
                        <div class="col-sm-9">
                            <select id="questions_order" name="questions_order" class="form-control laqm-select-default">
                                <option value="userdefined" <?=($data['quiz_settings']['questions_order'] == 'userdefined')?'selected':''?>>User defined</option>
                                <option value="random" <?=($data['quiz_settings']['questions_order'] == 'random')?'selected':''?>>Random</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label-left">Answers order</label>
                        <div class="col-sm-9">
                            <select id="answers_order" name="answers_order" class="form-control laqm-select-default">
                                <option value="userdefined" <?=($data['quiz_settings']['answers_order'] == 'userdefined')?'selected':''?>>User defined</option>
                                <option value="random" <?=($data['quiz_settings']['answers_order'] == 'random')?'selected':''?>>Random</option>
                            </select>
                        </div>
                    </div>
                    <?php } ?>
                    <?php if($data['edit_quiz']['type'] == 3 || $data['edit_quiz']['type'] == 4){ ?>
                        <div class="form-group">
                            <label class="col-sm-3 control-label-left">List items order</label>
                            <div class="col-sm-9">
                                <select id="questions_order" name="questions_order" class="form-control laqm-select-default">
                                    <option value="userdefined" <?=($data['quiz_settings']['questions_order'] == 'userdefined')?'selected':''?>>User defined</option>
                                    <option value="random" <?=($data['quiz_settings']['questions_order'] == 'random')?'selected':''?>>Random</option>
                                    <?php if($data['edit_quiz']['type'] == 3){ ?>
                                        <option value="upvotes" <?=($data['quiz_settings']['questions_order'] == 'upvotes')?'selected':''?>>By votes</option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <input name="answers_order" value="userdefined" type="hidden">
                    <?php } ?>
                    <?php if($data['edit_quiz']['type'] == 1 || $data['edit_quiz']['type'] == 2){ ?>
                    <div class="form-group">
                        <label class="col-sm-3 control-label-left">Auto-scroll<p class="help-block">Scroll down till the next question or next page</p></label>
                        <div class="col-sm-3">
                            <div class="switch">
                                <input id="auto_scroll" name="auto_scroll" class="cmn-toggle cmn-toggle-round-flat" type="checkbox" <?=($data['quiz_settings']['auto_scroll'] == 1)?'checked':''?> value="<?=$data['quiz_settings']['auto_scroll']?>">
                                <label for="auto_scroll" data-on="Yes" data-off="No"></label>
                            </div>
                        </div>
                    </div>
                    <?php } else { ?>
                        <input name="auto_scroll" value="0" type="hidden">
                    <?php } ?>
                </form>

            </div>

        </div>

    </div>
</div>
<?php
$data['templating']->render('admin/templates/quiz', $data);
?>