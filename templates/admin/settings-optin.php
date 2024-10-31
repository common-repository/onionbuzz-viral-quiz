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
                    <a class="laqm-btn laqm-btn-green" href="#settings/optin/save">Save</a>
                </div>
            </div>
            <div style="clear: both;"></div>

        </div>

        <div class="laqm-tab-content">

            <div class="laqm-setting-tab settings-optin" data-content="settings-optin">

                <form id="form_settings_optin" class="form-horizontal form-ays">
                    <input name="form_action" type="hidden" value="submit_settings_optin">
                    <div class="form-group">
                        <label class="col-sm-3 control-label-left">Mailchimp API key</label>
                        <div class="col-sm-6">
                            <input name="mailchimp_api_key" type="text" class="form-control" value="<?=$data['items']['mailchimp_api_key']?>">
                        </div>
                    </div>
                    <?php

                    // todo нужно делать проверку есть ли токен
                    if (!empty($data['items']['mailchimp_api_key'])) {
                    $lists = $data['admin']::ob_get_MC_lists($data['items']['mailchimp_api_key']);

                    echo '<div class="form-group">
                        <label class="col-sm-3 control-label-left">Mailchimp Lists</label>
                        <div class="col-sm-6"><select name="mailchimp_list_id"><option value="">Select list</option>';
                        if($lists['error'] != 1){
                            for ($i = 0, $len = sizeof($lists); $i < $len; $i++) {
                                echo '<option value="' . $lists[$i][0] . '" ' . ($data['items']['mailchimp_list_id'] == $lists[$i][0] ? 'selected=selected' : '') . '>' . $lists[$i][1] . '</option>';
                            }
                        }
                    echo '</select></div></div>';

                    }
                    ?>
                    <div class="form-group">
                        <label class="col-sm-3 control-label-left">Display Opt-in form</label>
                        <div class="col-sm-3">
                            <div class="switch">
                                <input id="cmn-toggle-1" name="display_optin_form" class="cmn-toggle cmn-toggle-round-flat" type="checkbox" <?=($data['items']['display_optin_form'] == 1)?'checked':''?> value="<?=$data['items']['display_optin_form']?>">
                                <label for="cmn-toggle-1" data-on="Yes" data-off="No"></label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label-left">Lock results under this form</label>
                        <div class="col-sm-3">
                            <div class="switch">
                                <input id="cmn-toggle-2" name="lock_results_form" class="cmn-toggle cmn-toggle-round-flat" type="checkbox" <?=($data['items']['lock_results_form'] == 1)?'checked':''?> value="<?=$data['items']['lock_results_form']?>">
                                <label for="cmn-toggle-2" data-on="Yes" data-off="No"></label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label-left">Form Heading</label>
                        <div class="col-sm-6">
                            <input name="form_heading" type="text" class="form-control" value="<?=$data['items']['form_heading']?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label-left">Optional Form Subtitle</label>
                        <div class="col-sm-6">
                            <input name="form_subtitle" type="text" class="form-control" value="<?=$data['items']['form_subtitle']?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label-left">Submit button text</label>
                        <div class="col-sm-6">
                            <input name="submit_button_text" type="text" class="form-control" value="<?=$data['items']['submit_button_text']?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label-left">Opt-in warning</label>
                        <div class="col-sm-6">
                            <input name="optin_warning" type="text" class="form-control" value="<?=$data['items']['optin_warning']?>">
                        </div>
                    </div>


                </form>


            </div>


        </div>


    </div>
</div>