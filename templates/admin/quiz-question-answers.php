<div class="laqm-admin">

    <?php
    $data['templating']->render('admin/menu-top', $data);
    ?>

    <div class="laqm-content">

        <div class="laqm-item-navigation">
            <div class="laqm-item-back"><a class="laqm-btn laqm-btn-blue no-left-margin" href="?page=la_onionbuzz_dashboard&tab=quiz_questions&quiz_id=<?=$data['answers_list']['quiz_id']?>">&larr; Back</a></div>
            <div class="laqm-item-name"><span><?=$data['question_info']['title']?></span></div>
            <div class="laqm-item-nextprev pull-right">
                <?php if($data['prev_item']['id'] > 0){ ?>
                    <a class="laqm-btn laqm-btn-blue with-icon" href="?page=la_onionbuzz_dashboard&tab=quiz_question_answers&quiz_id=<?=$data['quiz_info']['id']?>&question_id=<?=$data['prev_item']['id']?>"><span class="icon-arrow-left"></span></a>
                <?php } ?>
                <?php if($data['next_item']['id'] > 0){ ?>
                    <a class="laqm-btn laqm-btn-blue with-icon" href="?page=la_onionbuzz_dashboard&tab=quiz_question_answers&quiz_id=<?=$data['quiz_info']['id']?>&question_id=<?=$data['next_item']['id']?>"><span class="icon-arrow-right"></span></a>
                <?php } ?>
            </div>
        </div>

        <div style="clear: both;"></div>

        <div class="laqm-breadcrumbs-container">
            <a href="?page=la_onionbuzz_dashboard">Stories</a>
            <span>&rarr;</span>
            <a href="?page=la_onionbuzz_dashboard&tab=quiz_edit&quiz_id=<?=$data['quiz_info']['id']?>"><?=$data['quiz_info']['title']?></a>
            <span>&rarr;</span>
            <a href="?page=la_onionbuzz_dashboard&tab=quiz_question_edit&quiz_id=<?=$data['quiz_info']['id']?>&question_id=<?=$data['question_info']['id']?>"><?=(isset($data['question_info']['title']) && $data['question_info']['title'] != '')?$data['question_info']['title']:'NO TITLE'?></a>
            <span>&rarr;</span>
            Answers
        </div>

        <div class="laqm-alerts">
        </div>

        <div class="laqm-tabs-tools-container">

            <div class="laqm-tabs">
                <div class="laqm-tab-item ">
                    <a class="laqm-tab-item-link" href="?page=la_onionbuzz_dashboard&tab=quiz_question_edit&quiz_id=<?=$data['answers_list']['quiz_id']?>&question_id=<?=$data['answers_list']['question_id']?>">Edit question</a>
                </div>
                <div class="laqm-tab-item active">
                    <a class="laqm-tab-item-link" href="#">Answers (<?=$data['answers_list']['answers_count']?>)</a>
                    <div class="pull-right">
                        <a class="laqm-btn laqm-btn-txt-large laqm-btn-blue" href="?page=la_onionbuzz_dashboard&tab=quiz_question_answer_edit&quiz_id=<?=$data['answers_list']['quiz_id']?>&question_id=<?=$data['answers_list']['question_id']?>"><span class="icon-ico-add"></span></a>
                    </div>
                </div>
            </div>
            <div class="laqm-tools">
            </div>

            <div style="clear: both;"></div>

        </div>

        <div class="laqm-tab-content">

            <div id="laqm-answers-list" class="laqm-items-list"></div>

        </div>

    </div>
</div>
<?php
$data['templating']->render('admin/templates/quiz', $data);
?>