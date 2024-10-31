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
                    <a class="laqm-btn laqm-btn-green" href="#settings/appearance/save">Save</a>
                </div>
            </div>
            <div style="clear: both;"></div>

        </div>

        <div class="laqm-tab-content">

            <div class="laqm-options-tab settings-general" data-content="options-appearance">

            </div>

            <div class="laqm-setting-tab options-appearance" data-content="settings-general">

                <form class="form-horizontal form-ays">
                    <input name="form_action" type="hidden" value="submit_settings_appearance">
                    <div class="form-group">
                        <label class="col-sm-3 control-label-left">UI base color<p class="help-block">Applies to buttons and links</p></label>
                        <div class="col-sm-3">
                            <div class="colorpick input-group colorpicker-component">
                                <span class="input-group-addon laqm-color"><i></i></span>
                                <input name="ui_elements_color" type="text" class="form-control no-left-border" value="<?=($data['items']['ui_elements_color'])?>"  />
                            </div>
                        </div>

                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label-left">Label color<p class="help-block">Applies to text labels and icons on buttons</p></label>
                        <div class="col-sm-3">
                            <div class="colorpick input-group colorpicker-component">
                                <span class="input-group-addon laqm-color"><i></i></span>
                                <input name="label_color" type="text" class="form-control no-left-border" value="<?=($data['items']['label_color'])?>" />
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label-left">Progress bar color</label>
                        <div class="col-sm-3">
                            <div class="colorpick input-group colorpicker-component">
                                <span class="input-group-addon laqm-color"><i></i></span>
                                <input name="progress_bar_color" type="text" class="form-control no-left-border" value="<?=($data['items']['progress_bar_color'])?>" />
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label-left">Custom CSS</label>
                        <div class="col-sm-9">
                            <textarea name="custom_css" class="form-control" style="height: 150px"><?=($data['items']['custom_css'])?></textarea>
                        </div>
                    </div>


                </form>


            </div>

            <div class="laqm-options-tab options-social" data-content="options-social">

            </div>

            <div class="laqm-options-tab options-optin" data-content="options-optin">

            </div>

        </div>


    </div>
</div>