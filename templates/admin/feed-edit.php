<div class="laqm-admin">

    <?php
    $data['templating']->render('admin/menu-top', $data);
    ?>
    <div class="laqm-content floating-area">

        <div class="laqm-item-navigation">
            <div class="laqm-item-back"><a class="laqm-btn laqm-btn-blue no-left-margin" href="?page=la_onionbuzz_feeds">&larr; Back</a></div>
            <div class="laqm-item-name"><span><?=$data['edit_feed']['page_title']?></span></div>
            <div class="laqm-item-nextprev pull-right">
                <?php if($data['prev_item']['id'] > 0){ ?>
                <a class="laqm-btn laqm-btn-blue with-icon" href="?page=la_onionbuzz_feeds&tab=feed_edit&feed_id=<?=$data['prev_item']['id']?>"><span class="icon-arrow-left"></span></a>
                <?php } ?>
                <?php if($data['next_item']['id'] > 0){ ?>
                <a class="laqm-btn laqm-btn-blue with-icon" href="?page=la_onionbuzz_feeds&tab=feed_edit&feed_id=<?=$data['next_item']['id']?>"><span class="icon-arrow-right"></span></a>
                <?php } ?>
            </div>
        </div>

        <div style="clear: both;"></div>

        <div class="laqm-tabs-tools-container">

            <div class="laqm-tabs">
                <div class="laqm-tab-item active">
                    <a class="laqm-tab-item-link" href="?page=la_onionbuzz_feeds&tab=feed_edit&feed_id=<?=$data['edit_feed']['id']?>">Edit feed</a>
                </div>
            </div>
            <div class="laqm-tools floating-this">
                <div class="laqm-tools-item pull-right">
                    <?php if($data['edit_feed']['id'] > 0){?>
                        <a class="laqm-btn laqm-btn-blue with-icon" href="<?=$data['edit_feed']['preview_link']?>" target="_blank"><span class="icon-ico-preview"></span></a>
                    <?php } ?>
                    <a class="laqm-btn laqm-btn-green" href="#feed/<?=$data['edit_feed']['id']?>/save">Save</a>
                    <a class="laqm-btn with-icon" href="?page=la_onionbuzz_feeds"><span class="icon-ico-close"></span></a>
                </div>
            </div>

            <div style="clear: both;"></div>

        </div>

        <div class="laqm-tab-content">

            <div class="laqm-setting-tab settings-general" data-content="settings-general">

                <form id="form_edit_feed" class="form-horizontal form-ays">
                    <div class="form-group" style="display: none;">
                        <label class="col-sm-3 control-label-left">Published</label>
                        <div class="col-sm-3">
                            <div class="switch">
                                <input id="feed_published" name="feed_published" class="cmn-toggle cmn-toggle-round-flat" type="checkbox" <?=(@$data['edit_feed']['flag_published'] == 1)?'checked':'checked'?> value="<?=(isset($data['edit_feed']['flag_published'])?$data['edit_feed']['flag_published']:1)?>">
                                <label for="feed_published" data-on="Yes" data-off="No"></label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label-left">Feed title *</label>
                        <div class="col-sm-9">
                            <input name="feed_title" type="text" class="form-control" value="<?=esc_html((isset($data['edit_feed']['title']))?$data['edit_feed']['title']:'')?>" placeholder="Feed title">
                        </div>

                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label-left">Description</label>
                        <div class="col-sm-9">
                            <textarea name="feed_description" type="text" class="form-control" style="height: 150px;"><?=(isset($data['edit_feed']['description'])?$data['edit_feed']['description']:'')?></textarea>
                        </div>
                    </div>
                </form>

            </div>

            <div class="laqm-options-tab options-appearance" data-content="options-appearance">

            </div>

            <div class="laqm-options-tab options-social" data-content="options-social">

            </div>

            <div class="laqm-options-tab options-optin" data-content="options-optin">

            </div>

        </div>

        <div class="laqm-tabs-tools-container secondary">

            <div class="laqm-tabs">
                <div class="laqm-tab-item active">
                    <a class="laqm-tab-item-link" href="javascript:void(0);">Seo settings</a>
                </div>
            </div>
            <div style="clear: both;"></div>

        </div>

        <div class="laqm-tab-content secondary">

            <div class="laqm-setting-tab settings-general" data-content="settings-general">

                <form id="form_edit_feed_seo" class="form-horizontal form-ays">
                    <div class="form-group">
                        <label class="col-sm-3 control-label-left">Feed slug<p class="help-block">For search engine optimization</p></label>
                        <div class="col-sm-9">
                            <input name="feed_slug" type="text" class="form-control" value="<?=(isset($data['edit_feed']['slug'])?$data['edit_feed']['slug']:'')?>">
                        </div>

                    </div>
                </form>

            </div>

            <div class="laqm-options-tab options-appearance" data-content="options-appearance">

            </div>

            <div class="laqm-options-tab options-social" data-content="options-social">

            </div>

            <div class="laqm-options-tab options-optin" data-content="options-optin">

            </div>

        </div>


    </div>
</div>
<?php
$data['templating']->render('admin/templates/feed', $data);
?>