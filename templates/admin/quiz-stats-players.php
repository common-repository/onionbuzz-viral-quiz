<div class="laqm-admin">

    <?php
    $data['templating']->render('admin/menu-top', $data);
    ?>

    <div class="laqm-content floating-area">

        <div class="laqm-item-navigation">
            <div class="laqm-item-back"><a class="laqm-btn laqm-btn-blue no-left-margin" href="?page=la_onionbuzz_dashboard">&larr; Back</a></div>
            <div class="laqm-item-name"><span>Analytics: <?=$data['quiz_info']['title']?></span></div>
            <div class="laqm-item-nextprev pull-right">
                <?php if($data['prev_item']['id'] > 0){ ?>
                    <a class="laqm-btn laqm-btn-blue with-icon" href="?page=la_onionbuzz_dashboard&tab=quiz_result_edit&quiz_id=<?=$data['quiz_info']['id']?>&result_id=<?=$data['prev_item']['id']?>"><span class="icon-arrow-left"></span></a>
                <?php } ?>
                <?php if($data['next_item']['id'] > 0){ ?>
                    <a class="laqm-btn laqm-btn-blue with-icon" href="?page=la_onionbuzz_dashboard&tab=quiz_result_edit&quiz_id=<?=$data['quiz_info']['id']?>&result_id=<?=$data['next_item']['id']?>"><span class="icon-arrow-right"></span></a>
                <?php } ?>
            </div>
        </div>

        <div style="clear: both;"></div>

        <div class="laqm-breadcrumbs-container">
            <a href="?page=la_onionbuzz_dashboard">Stories</a>
            <span>&rarr;</span>
            <a href="?page=la_onionbuzz_dashboard&tab=quiz_edit&quiz_id=<?=$data['quiz_info']['id']?>"><?=$data['quiz_info']['title']?></a>
            <span>&rarr;</span>
            Analytics
        </div>

        <div class="laqm-tabs-tools-container">

            <div class="laqm-tabs">
                <div class="laqm-tab-item">
                    <a class="laqm-tab-item-link" href="?page=la_onionbuzz_dashboard&tab=quiz_stats&quiz_id=<?=$data['quiz_info']['id']?>">Quiz</a>
                </div>
                <div class="laqm-tab-item active">
                    <a class="laqm-tab-item-link" href="?page=la_onionbuzz_dashboard&tab=quiz_stats_players&quiz_id=<?=$data['quiz_info']['id']?>">Players</a>
                </div>
                <div class="laqm-tab-item ">
                    <a class="laqm-tab-item-link" href="?page=la_onionbuzz_dashboard&tab=quiz_stats_results&quiz_id=<?=$data['quiz_info']['id']?>">Results</a>

                </div>
            </div>
            <div class="laqm-tools floating-this">
                <div class="laqm-tools-item pull-right">
                    <a class="laqm-btn" href="#stats/erase">Erase all data</a>
                </div>
            </div>

            <div style="clear: both;"></div>

        </div>

        <div class="laqm-tab-content">
            <div class="laqm-item quiz-stat-players">
                <div class="laqm-item-info">
                    <div class="laqm-item-title-tools stats">
                        <div class="laqm-item-tools">
                        </div>
                        <div class="laqm-item-title col-sm-3" data-id="1" data-quiz_id="8">
                            Name
                        </div>
                        <div class="laqm-item-title col-sm-4 ">
                            Email
                        </div>
                        <div class="laqm-item-title col-sm-2  ">
                            Score
                        </div>
                        <div class="laqm-item-title col-sm-3  ">
                            Date
                        </div>
                    </div>
                    <div style="clear: both;"></div>
                </div>
            </div>
            <div id="laqm-players-list" class="laqm-items-list"></div>

        </div>

        <div class="laqm-pagination"></div>

    </div>
</div>
<?php
$data['templating']->render('admin/templates/quiz', $data);
?>