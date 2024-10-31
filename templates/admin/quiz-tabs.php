<div class="laqm-tab-item <?=($data['current_tab'] == 'quiz_edit')?'active':''?>">
    <a class="laqm-tab-item-link" href="?page=la_onionbuzz_dashboard&tab=quiz_edit&quiz_id=<?=$data['edit_quiz']['id']?>">Edit story</a>
</div>

<?php if($data['edit_quiz']['type'] == 1 || $data['edit_quiz']['type'] == 2 || $data['edit_quiz']['type'] == 5){ ?>
    <?php if($data['edit_quiz']['id'] == 0){ ?>
        <div class="laqm-tab-item <?=($data['edit_quiz']['id'] == 0)?'disabled':''?> <?=($data['current_tab'] == 'quiz_results')?'active':''?>">
            <a class="laqm-tab-item-link" href="javascript:void(0);" title="You must save quiz">Results (0)</a>
        </div>
        <div class="laqm-tab-item <?=($data['edit_quiz']['id'] == 0)?'disabled':''?> <?=($data['current_tab'] == 'quiz_questions')?'active':''?>">
            <a class="laqm-tab-item-link" href="javascript:void(0);" title="You must save quiz">Questions (0)</a>
        </div>
    <?php } else { ?>
        <div class="laqm-tab-item <?=($data['edit_quiz']['id'] == 0)?'disabled':''?> <?=($data['current_tab'] == 'quiz_results')?'active':''?>">
            <a class="laqm-tab-item-link" href="?page=la_onionbuzz_dashboard&tab=quiz_results&quiz_id=<?=$data['edit_quiz']['id']?>">Results (<?=$data['edit_quiz']['results_count']?>)</a>
            <div class="pull-right">
                <a class="laqm-btn laqm-btn-txt-large laqm-btn-blue" href="?page=la_onionbuzz_dashboard&tab=quiz_result_edit&quiz_id=<?=$data['edit_quiz']['id']?>"><span class="icon-ico-add"></span></a>
            </div>
        </div>
        <div class="laqm-tab-item <?=($data['edit_quiz']['id'] == 0)?'disabled':''?> <?=($data['current_tab'] == 'quiz_questions')?'active':''?>">
            <a class="laqm-tab-item-link" href="?page=la_onionbuzz_dashboard&tab=quiz_questions&quiz_id=<?=$data['edit_quiz']['id']?>">Questions (<?=$data['edit_quiz']['questions_count']?>)</a>
            <div class="pull-right">
                <a class="laqm-btn laqm-btn-txt-large laqm-btn-blue " href="?page=la_onionbuzz_dashboard&tab=quiz_question_edit&quiz_id=<?=$data['edit_quiz']['id']?>"><span class="icon-ico-add"></span></a>
            </div>
        </div>
    <?php } ?>
<?php } ?>
<?php if($data['edit_quiz']['type'] == 3){ ?>
    <?php if($data['edit_quiz']['id'] == 0){ ?>
        <div class="laqm-tab-item <?=($data['edit_quiz']['id'] == 0)?'disabled':''?> <?=($data['current_tab'] == 'quiz_questions')?'active':''?>">
            <a class="laqm-tab-item-link" href="javascript:void(0);" title="You must save quiz">List Items (0)</a>
        </div>
    <?php } else { ?>
        <div class="laqm-tab-item <?=($data['edit_quiz']['id'] == 0)?'disabled':''?> <?=($data['current_tab'] == 'quiz_questions')?'active':''?>">
            <a class="laqm-tab-item-link" href="?page=la_onionbuzz_dashboard&tab=quiz_questions&quiz_id=<?=$data['edit_quiz']['id']?>">List Items (<?=$data['edit_quiz']['questions_count']?>)</a>
            <?php if($_REQUEST['tab'] == 'quiz_questions'){?>
                <div class="pull-right">
                    <a class="laqm-btn laqm-btn-txt-large laqm-btn-blue button-show-add-form" href="javascript:void(0);"><span class="icon-ico-add"></span></a>
                </div>
            <?php } ?>
        </div>
    <?php } ?>
<?php } ?>

<?php if($data['edit_quiz']['type'] == 4){ ?>
    <?php if($data['edit_quiz']['id'] == 0){ ?>
        <div class="laqm-tab-item <?=($data['edit_quiz']['id'] == 0)?'disabled':''?> <?=($data['current_tab'] == 'quiz_questions')?'active':''?>">
            <a class="laqm-tab-item-link" href="javascript:void(0);" title="You must save quiz">Flip Cards (0)</a>
        </div>
    <?php } else { ?>
        <div class="laqm-tab-item <?=($data['edit_quiz']['id'] == 0)?'disabled':''?> <?=($data['current_tab'] == 'quiz_questions')?'active':''?>">
            <a class="laqm-tab-item-link" href="?page=la_onionbuzz_dashboard&tab=quiz_questions&quiz_id=<?=$data['edit_quiz']['id']?>">Flip Cards (<?=$data['edit_quiz']['questions_count']?>)</a>
            <?php if($_REQUEST['tab'] == 'quiz_questions'){?>
            <div class="pull-right">
                <a class="laqm-btn laqm-btn-txt-large laqm-btn-blue button-show-add-form" href="javascript:void(0);"><span class="icon-ico-add"></span></a>
            </div>
            <?php } ?>
        </div>
    <?php } ?>
<?php } ?>