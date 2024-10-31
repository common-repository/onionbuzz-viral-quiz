<div class="laqm-admin">

    <?php
    $data['templating']->render('admin/menu-top', $data);
    ?>

    <div class="laqm-content">

        <div class="laqm-breadcrumbs"></div>

        <div class="laqm-tabs-tools-container">

            <div class="laqm-tabs">
                <div class="laqm-tab-item active">
                    <a class="laqm-tab-item-link" href="?page=la_onionbuzz_dashboard">All Stories</a> (<?=$data['total_quizzes']?>)
                    <div class="pull-right">
                        <a class="laqm-btn laqm-btn-txt-large laqm-btn-blue laqm-create-story" href="javascript:void(0);"><span class="icon-ico-add"></span></a>
                    </div>

                </div>
            </div>
            <div class="laqm-tools">
                <div class="laqm-tools-item pull-right">
                    <a class="laqm-btn laqm-btn-blue" target="_blank" href="https://goo.gl/23mpm6">UPGRADE TO PRO</a>
                </div>
            </div>
            <div style="clear: both;"></div>

        </div>
        <div class="laqm-search-filters">
            <div class="laqm-filters">
                <div class="laqm-select laqm-item-actions laqm-inlineblock laqm-select-blue arrow-grey-down">
                    <select id="quizzes_feeds" name="quizzes-feeds">
                        <option value="all">All feeds</option>
                        <?php
                        foreach ($data['feeds']['items'] as $k=>$v){
                            ?>
                            <option value="<?=$data['feeds']['items'][$k]['id']?>"><?=$data['feeds']['items'][$k]['title']?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="laqm-select laqm-select-blue arrow-grey-down laqm-item-sortby laqm-inlineblock">
                    <select id="quizzes_sort" name="search-sort">
                        <option value="date_added" data-type="desc">Newest on top</option>
                        <option value="date_added" data-type="asc">Oldest on top</option>
                        <option value="title" data-type="asc">Title (a-z)</option>
                        <option value="title" data-type="desc">Title (z-a)</option>
                    </select>
                </div>


                <div style="clear: both;"></div>
            </div>
            <div class="laqm-search">
                <input id="quizzes_search" class="laqm-search-input" placeholder="Search">
            </div>
            <div style="clear: both;"></div>
        </div>

        <div class="laqm-tab-content">

            <div id="laqm-quizzes-list" class="laqm-items-list">
            </div>

        </div>

        <div class="laqm-pagination"></div>

    </div>
</div>
<?php
$data['templating']->render('admin/templates/quiz', $data);
?>