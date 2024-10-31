<div class="laqm-admin">

    <?php
    $data['templating']->render('admin/menu-top', $data);
    ?>

    <div class="laqm-content">

        <div class="laqm-item-navigation">
            <div class="laqm-item-back"><a class="laqm-btn laqm-btn-blue no-left-margin" href="?page=la_onionbuzz_feeds">&larr; Back</a></div>
            <div class="laqm-item-name"><span><?=$data['edit_feed']['title']?></span></div>
            <div class="laqm-item-nextprev pull-right">
                <?php if($data['prev_item']['id'] > 0){ ?>
                    <a class="laqm-btn laqm-btn-blue with-icon" href="?page=la_onionbuzz_feeds&tab=feed_quizzes&feed_id=<?=$data['prev_item']['id']?>"><span class="icon-arrow-left"></span></a>
                <?php } ?>
                <?php if($data['next_item']['id'] > 0){ ?>
                    <a class="laqm-btn laqm-btn-blue with-icon" href="?page=la_onionbuzz_feeds&tab=feed_quizzes&feed_id=<?=$data['next_item']['id']?>"><span class="icon-arrow-right"></span></a>
                <?php } ?>
            </div>
        </div>

        <div style="clear: both;"></div>

        <div class="laqm-tabs-tools-container">

            <div class="laqm-tabs">
                <div class="laqm-tab-item ">
                    <a class="laqm-tab-item-link" href="?page=la_onionbuzz_feeds&tab=feed_edit&feed_id=<?=$data['edit_feed']['id']?>">Edit feed</a>
                </div>
                <div class="laqm-tab-item active">
                    <a class="laqm-tab-item-link" href="?page=la_onionbuzz_feeds&tab=feed_quizzes&feed_id=<?=$data['edit_feed']['id']?>">Quizzes</a>
                </div>
            </div>
            <div class="laqm-tools">
                <div class="laqm-tools-item pull-right">
                    <a class="laqm-btn laqm-btn-blue" href="#feed/<?=$data['edit_feed']['id']?>/embed">Embed</a>
                    <a class="laqm-btn laqm-btn-green" href="#feed/<?=$data['edit_feed']['id']?>/save">Save</a>
                    <a class="laqm-btn with-icon" href="?page=la_onionbuzz_feeds"><span class="icon-ico-close"></span></a>
                </div>
            </div>

            <div style="clear: both;"></div>

        </div>
        <div class="laqm-search-filters">
            <div class="laqm-filters">
                <div class="laqm-select laqm-select-blue laqm-item-actions laqm-inlineblock ">
                    <select>
                        <option value=""><?=$data['edit_feed']['title']?></option>
                        <option value=""></option>
                        <option value="">Test feed 2</option>
                        <option value="">Test feed 3</option>
                    </select>
                </div>
                <div class="laqm-select laqm-select-blue arrow-grey-down laqm-item-sortby laqm-inlineblock">
                    <select>
                        <option value="">Most recent</option>
                        <option value="">Most recent</option>
                        <option value="">Most recent</option>
                    </select>
                </div>

                <div style="clear: both;"></div>
            </div>
            <div class="laqm-search">
                <input id="quizzes_search" class="laqm-search-input" placeholder="Enter text to search">
            </div>
            <div style="clear: both;"></div>
        </div>

        <div class="laqm-tab-content">
            <div id="laqm-feed-quizzes-list"></div>
        </div>

    </div>
</div>
<?php
$data['templating']->render('admin/templates/feed', $data);
?>