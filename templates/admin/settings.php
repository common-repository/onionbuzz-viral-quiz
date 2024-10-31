<div class="laqm-admin">

    <?php
    $data['templating']->render('admin/menu-top', $data);
    ?>

    <div class="laqm-content floating-area">
        <form id="form_settings_general" class="form-horizontal form-ays">

            <div class="laqm-tabs-tools-container ">

                <div class="laqm-tabs">
                    <div class="laqm-tab-item active">
                        <a class="laqm-tab-item-link" href="javascript:void(0);">Appearance</a>
                    </div>
                </div>
                <div class="laqm-tools floating-this">
                    <div class="laqm-tools-item pull-right">
                        <a class="laqm-btn laqm-btn-green" href="#settings/all/save">Save</a>
                    </div>
                </div>
                <div style="clear: both;"></div>

            </div>

            <div class="laqm-tab-content secondary">

                <div class="laqm-setting-tab settings-general" data-content="settings-general">
                    <input name="form_action" type="hidden" value="submit_settings_appearance">
                    <div class="form-group">
                        <label class="col-sm-3 control-label-left">UI base color<p class="help-block">Applies to buttons and links</p></label>
                        <div class="col-sm-3">
                            <div class="colorpick input-group colorpicker-component">
                                <span class="input-group-addon laqm-color"><i></i></span>
                                <input name="ui_elements_color" type="text" class="form-control no-left-border" value="<?=($data['items']['appearance']['ui_elements_color'])?>"  />
                            </div>
                        </div>

                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label-left">Label color<p class="help-block">Applies to text labels and icons on buttons</p></label>
                        <div class="col-sm-3">
                            <div class="colorpick input-group colorpicker-component">
                                <span class="input-group-addon laqm-color"><i></i></span>
                                <input name="label_color" type="text" class="form-control no-left-border" value="<?=($data['items']['appearance']['label_color'])?>" />
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label-left">Progress bar color</label>
                        <div class="col-sm-3">
                            <div class="colorpick input-group colorpicker-component">
                                <span class="input-group-addon laqm-color"><i></i></span>
                                <input name="progress_bar_color" type="text" class="form-control no-left-border" value="<?=($data['items']['appearance']['progress_bar_color'])?>" />
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label-left">STORY SLUG</label>
                        <div class="col-sm-6">
                            <input name="obla_post_type_slug" type="text" class="form-control" value="<?=($data['items']['appearance']['obla_post_type_slug'])?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label-left">BREADCRUMB TEXT</label>
                        <div class="col-sm-6">
                            <input name="obla_post_type_text" type="text" class="form-control" value="<?=($data['items']['appearance']['obla_post_type_text'])?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label-left">Custom CSS</label>
                        <div class="col-sm-9">
                            <textarea name="custom_css" class="form-control" style="height: 150px"><?=esc_html(stripslashes($data['items']['appearance']['custom_css']))?></textarea>
                        </div>
                    </div>


                </div>
            </div>



            <div class="laqm-tabs-tools-container secondary">

                <div class="laqm-tabs">
                    <div class="laqm-tab-item active">
                        <a class="laqm-tab-item-link" href="javascript:void(0);">Opt-in</a>
                    </div>
                </div>

                <div style="clear: both;"></div>

            </div>

            <div class="laqm-tab-content secondary">

                <div class="laqm-setting-tab settings-general" data-content="settings-general">
                    <input name="form_action" type="hidden" value="submit_settings_optin">
                    <div class="form-group">
                        <label class="col-sm-3 control-label-left">Mailchimp API key</label>
                        <div class="col-sm-6">
                            <input name="mailchimp_api_key" type="text" class="form-control" value="<?=$data['items']['optin']['mailchimp_api_key']?>">
                        </div>
                    </div>
                    <?php

                    // todo нужно делать проверку есть ли токен
                    if (!empty($data['items']['optin']['mailchimp_api_key'])) {
                        $lists = $data['mailchimp_lists'];

                        echo '<div class="form-group">
                        <label class="col-sm-3 control-label-left">Mailchimp Lists</label>
                        <div class="col-sm-6"><select name="mailchimp_list_id" class="form-control laqm-select-default"><option value="">Select list</option>';
                        if($lists['error'] != 1){
                            for ($i = 0, $len = sizeof($lists); $i < $len; $i++) {
                                echo '<option value="' . $lists[$i][0] . '" ' . ($data['items']['optin']['mailchimp_list_id'] == $lists[$i][0] ? 'selected=selected' : '') . '>' . $lists[$i][1] . '</option>';
                            }
                        }
                        echo '</select></div></div>';

                    }
                    ?>
                    <div class="form-group">
                        <label class="col-sm-3 control-label-left">Display Opt-in form</label>
                        <div class="col-sm-3">
                            <div class="switch">
                                <input id="display_optin_form" name="display_optin_form" class="cmn-toggle cmn-toggle-round-flat" type="checkbox" <?=($data['items']['optin']['display_optin_form'] == 1)?'checked':''?> value="<?=$data['items']['optin']['display_optin_form']?>">
                                <label for="display_optin_form" data-on="Yes" data-off="No"></label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group" style="display: none;">
                        <label class="col-sm-3 control-label-left">Lock results under this form</label>
                        <div class="col-sm-3">
                            <div class="switch">
                                <input id="lock_results_form" name="lock_results_form" class="cmn-toggle cmn-toggle-round-flat" type="checkbox" value="0">
                                <label for="lock_results_form" data-on="Yes" data-off="No"></label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label-left">Form Heading</label>
                        <div class="col-sm-6">
                            <input name="form_heading" type="text" class="form-control" value="<?=$data['items']['optin']['form_heading']?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label-left">Optional Form Subtitle</label>
                        <div class="col-sm-6">
                            <input name="form_subtitle" type="text" class="form-control" value="<?=$data['items']['optin']['form_subtitle']?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label-left">Submit button text</label>
                        <div class="col-sm-6">
                            <input name="submit_button_text" type="text" class="form-control" value="<?=$data['items']['optin']['submit_button_text']?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label-left">Opt-in warning</label>
                        <div class="col-sm-6">
                            <input name="optin_warning" type="text" class="form-control" value="<?=$data['items']['optin']['optin_warning']?>">
                        </div>
                    </div>
                </div>
            </div>

            <div class="laqm-tabs-tools-container secondary">

                <div class="laqm-tabs">
                    <div class="laqm-tab-item active">
                        <a class="laqm-tab-item-link" href="javascript:void(0);">QUIZ RESULTS</a>
                    </div>
                </div>

                <div style="clear: both;"></div>

            </div>

            <div class="laqm-tab-content secondary">

                <div class="laqm-setting-tab settings-general" data-content="settings-general">
                    <input name="form_action" type="hidden" value="submit_settings_social">
                    <div class="form-group">
                        <label class="col-sm-3 control-label-left">LOCK QUIZ RESULTS<span class="icon-lock" style="margin-left: 10px;"></span><p class="help-block">Both social and opt-in lockers are available in Pro version</p></label>
                        <div class="col-sm-3">
                            <select id="settings_resultlock" name="settings_resultlock" class="form-control laqm-select-default">
                                <option value="0" <?=(isset($data['items']['optin']['settings_resultlock']) && $data['items']['optin']['settings_resultlock'] == '0')?'selected':''?>>Do not lock</option>
                            </select>
                        </div>
                    </div>
                    <div id="lock_ignore_quizids" class="form-group" style="display: none;">
                        <label class="col-sm-3 control-label-left">NEVER LOCK STORIES<p class="help-block">List of story IDs, separated by commas</p></label>
                        <div class="col-sm-6">
                            <input name="lock_ignore_quizids" type="text" class="form-control" value="<?=$data['items']['optin']['lock_ignore_quizids']?>" placeholder="Ex.: <?=$data['placeholder_ids']?>">
                        </div>
                    </div>
                    <div id="lock_share" style="display: none;">
                        <div class="form-group">
                            <label class="col-sm-3 control-label-left">Heading</label>
                            <div class="col-sm-6">
                                <input name="sharing_heading" type="text" class="form-control" value="<?=$data['items']['optin']['sharing_heading']?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label-left">Sharing buttons</label>
                            <div class="col-sm-3">
                                <div class="checkbox icheck-info">
                                    <input id="lock_button_facebook" name="lock_button_facebook" type="checkbox" <?=($data['items']['optin']['lock_button_facebook'] == 1)?'checked':''?>  />
                                    <label for="lock_button_facebook">Facebook</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-3 col-sm-3">
                                <div class="checkbox icheck-info">
                                    <input id="lock_button_twitter" name="lock_button_twitter" type="checkbox" <?=($data['items']['optin']['lock_button_twitter'] == 1)?'checked':''?>   />
                                    <label for="lock_button_twitter">Twitter</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-3 col-sm-3">
                                <div class="checkbox icheck-info">
                                    <input id="lock_button_google" name="lock_button_google" type="checkbox" <?=($data['items']['optin']['lock_button_google'] == 1)?'checked':''?>   />
                                    <label for="lock_button_google">Google+</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="laqm-tabs-tools-container secondary">

                <div class="laqm-tabs">
                    <div class="laqm-tab-item active">
                        <a class="laqm-tab-item-link" href="javascript:void(0);">Social</a>
                    </div>
                </div>

                <div style="clear: both;"></div>

            </div>

            <div class="laqm-tab-content secondary">

                <div class="laqm-setting-tab settings-general" data-content="settings-general">
                    <input name="form_action" type="hidden" value="submit_settings_social">
                    <div class="form-group">
                        <label class="col-sm-3 control-label-left">Facebook App ID</label>
                        <div class="col-sm-6">
                            <input name="facebook_app_id" type="text" class="form-control" value="<?=$data['items']['social']['facebook_app_id']?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label-left">`SHARE RESULTS` BUTTONS</label>
                        <div class="col-sm-3">
                            <div class="switch">
                                <input id="share_results_buttons" name="share_results_buttons" class="cmn-toggle cmn-toggle-round-flat" type="checkbox" <?=($data['items']['social']['share_results_buttons'] == 1)?'checked':''?> value="<?=$data['items']['social']['share_results_buttons']?>">
                                <label for="share_results_buttons" data-on="Yes" data-off="No"></label>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </form>
    </div>
</div>