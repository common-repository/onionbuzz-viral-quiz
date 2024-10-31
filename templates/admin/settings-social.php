<div class="laqm-admin">

    <?php
    $data['templating']->render('admin/menu-top', $data);
    ?>

    <div class="laqm-content">

        <div class="laqm-tabs-tools-container">

            <div class="laqm-tabs">
                <?php
                $data['templating']->render('admin/settings-tabs', $data);
                ?>
            </div>
            <div class="laqm-tools">
                <div class="laqm-tools-item pull-right">
                    <a class="laqm-btn laqm-btn-green" href="#settings/social/save">Save</a>
                </div>
            </div>
            <div style="clear: both;"></div>

        </div>

        <div class="laqm-tab-content">

            <div class="laqm-setting-tab settings-social" data-content="settings-social">

                <form id="form_settings_social" class="form-horizontal form-ays">
                    <input name="form_action" type="hidden" value="submit_settings_social">
                    <div class="form-group">
                        <label class="col-sm-3 control-label-left">Facebook App ID</label>
                        <div class="col-sm-6">
                            <input name="facebook_app_id" type="text" class="form-control" value="<?=$data['items']['facebook_app_id']?>">
                        </div>
                    </div>


                    <!--<div class="form-group">
                        <label class="col-sm-3 control-label-left">`SHARE QUIZ` BUTTONS</label>
                        <div class="col-sm-3">
                            <div class="switch">
                                <input id="cmn-toggle-1" name="share_quiz_buttons" class="cmn-toggle cmn-toggle-round-flat" type="checkbox" <?/*=($data['items']['share_quiz_buttons'] == 1)?'checked':''*/?> value="<?/*=$data['items']['share_quiz_buttons']*/?>">
                                <label for="cmn-toggle-1" data-on="Yes" data-off="No"></label>
                            </div>
                        </div>
                    </div>-->
                    <div class="form-group">
                        <label class="col-sm-3 control-label-left">`SHARE RESULTS` BUTTONS</label>
                        <div class="col-sm-3">
                            <div class="switch">
                                <input id="cmn-toggle-2" name="share_results_buttons" class="cmn-toggle cmn-toggle-round-flat" type="checkbox" <?=($data['items']['share_results_buttons'] == 1)?'checked':''?> value="<?=$data['items']['share_results_buttons']?>">
                                <label for="cmn-toggle-2" data-on="Yes" data-off="No"></label>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label-left">Sharing buttons</label>
                        <div class="col-sm-3">
                            <div class="checkbox icheck-info">
                                <input id="share_button_facebook" name="share_button_facebook" type="checkbox" <?=($data['items']['share_button_facebook'] == 1)?'checked':''?>  />
                                <label for="share_button_facebook">Facebook</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-offset-3 col-sm-3">
                            <div class="checkbox icheck-info">
                                <input id="share_button_twitter" name="share_button_twitter" type="checkbox" <?=($data['items']['share_button_twitter'] == 1)?'checked':''?>   />
                                <label for="share_button_twitter">Twitter</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-offset-3 col-sm-3">
                            <div class="checkbox icheck-info">
                                <input id="share_button_google" name="share_button_google" type="checkbox" <?=($data['items']['share_button_google'] == 1)?'checked':''?>   />
                                <label for="share_button_google">Google+</label>
                            </div>
                        </div>
                    </div>



                </form>


            </div>


        </div>


    </div>
</div>