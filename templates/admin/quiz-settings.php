<div class="laqm-admin">

    <?php
    $data['templating']->render('admin/menu-top', $data);
    ?>

    <div class="laqm-content">

        <div class="laqm-item-navigation">
            <div class="laqm-item-back"><a class="laqm-btn laqm-btn-blue no-left-margin" href="?page=la_onionbuzz_dashboard">&larr; Back</a></div>
            <div class="laqm-item-name"><span><?=$data['edit_quiz']['title']?></span></div>
        </div>

        <div class="laqm-tabs-tools-container">

            <div class="laqm-tabs">
                <?php
                $data['templating']->render('admin/quiz-tabs', $data);
                ?>
            </div>
            <div class="laqm-tools">
                <div class="laqm-tools-item pull-right">
                    <?php if($data['edit_quiz']['id'] > 0){?>
                        <a class="laqm-btn laqm-btn-blue with-icon" href="<?=$data['edit_quiz']['preview_link']?>" target="_blank"><span class="icon-ico-preview"></span></a>
                        <a class="laqm-btn laqm-btn-blue" href="#quiz/<?=$data['edit_quiz']['id']?>/embed">Embed</a>
                    <?php } ?>
                    <a class="laqm-btn laqm-btn-green" href="#settings/<?=$data['edit_quiz']['id']?>/save">Save</a>
                    <a class="laqm-btn with-icon" href="?page=la_onionbuzz_dashboard"><span class="icon-ico-close"></span></a>
                </div>
            </div>

            <div style="clear: both;"></div>

        </div>

        <div class="laqm-tab-content">

            <div class="laqm-edit-tab edit-general" data-content="edit-general">

                <form class="form-horizontal form-ays">

                    <div class="form-group">
                        <label class="col-sm-3 control-label-left">Answer status<p class="help-block">When answer was given display the outcome to player</p></label>
                        <div class="col-sm-3">
                            <div class="switch">
                                <input id="answer_status" name="answer_status" class="cmn-toggle cmn-toggle-round-flat" type="checkbox" <?=($data['quiz_settings']['answer_status'] == 1)?'checked':''?> value="<?=$data['quiz_settings']['answer_status']?>">
                                <label for="answer_status" data-on="Yes" data-off="No"></label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label-left">`Replay` button<p class="help-block"></p></label>
                        <div class="col-sm-3">
                            <div class="switch">
                                <input id="replay_button" name="replay_button" class="cmn-toggle cmn-toggle-round-flat" type="checkbox" <?=($data['quiz_settings']['replay_button'] == 1)?'checked':''?> value="<?=$data['quiz_settings']['replay_button']?>">
                                <label for="replay_button" data-on="Yes" data-off="No"></label>
                            </div>
                        </div>
                    </div>

                </form>

            </div>

        </div>

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
                    <div class="form-group">
                        <label class="col-sm-3 control-label-left">Questions order</label>
                        <div class="col-sm-9">
                            <select id="questions_order" name="questions_order" class="form-control laqm-select-default">
                                <option value="userdefined" <?=($data['quiz_settings']['questions_order'] == 'fulllist')?'selected':''?>>User defined</option>
                                <option value="random" <?=($data['quiz_settings']['questions_order'] == 'slider')?'selected':''?>>Random</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label-left">Answers order</label>
                        <div class="col-sm-9">
                            <select id="answers_order" name="answers_order" class="form-control laqm-select-default">
                                <option value="userdefined" <?=($data['quiz_settings']['answers_order'] == 'fulllist')?'selected':''?>>User defined</option>
                                <option value="random" <?=($data['quiz_settings']['answers_order'] == 'slider')?'selected':''?>>Random</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label-left">Auto-scroll<p class="help-block">Scroll down till the next question or next page</p></label>
                        <div class="col-sm-3">
                            <div class="switch">
                                <input id="auto_scroll" name="auto_scroll" class="cmn-toggle cmn-toggle-round-flat" type="checkbox" <?=($data['quiz_settings']['auto_scroll'] == 1)?'checked':''?> value="<?=$data['quiz_settings']['auto_scroll']?>">
                                <label for="auto_scroll" data-on="Yes" data-off="No"></label>
                            </div>
                        </div>
                    </div>

                </form>

            </div>

        </div>

    </div>
</div>