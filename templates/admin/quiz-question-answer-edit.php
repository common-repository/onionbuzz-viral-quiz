<div class="laqm-admin">

    <?php
    $data['templating']->render('admin/menu-top', $data);
    ?>

    <div class="laqm-content floating-area">

        <div class="laqm-item-navigation">
            <div class="laqm-item-back"><a class="laqm-btn laqm-btn-blue no-left-margin" href="?page=la_onionbuzz_dashboard&tab=quiz_questions&quiz_id=<?=$data['edit_answer']['quiz_id']?>">&larr; Back</a></div>
            <div class="laqm-item-name"><span><?=$data['edit_answer']['page_title']?></span></div>
            <div class="laqm-item-nextprev pull-right">
                <?php if($data['prev_item']['id'] > 0){ ?>
                    <a class="laqm-btn laqm-btn-blue with-icon" href="?page=la_onionbuzz_dashboard&tab=quiz_question_answer_edit&quiz_id=<?=$data['quiz_info']['id']?>&question_id=<?=$data['question_info']['id']?>&answer_id=<?=$data['prev_item']['id']?>"><span class="icon-arrow-left"></span></a>
                <?php } ?>
                <?php if($data['next_item']['id'] > 0){ ?>
                    <a class="laqm-btn laqm-btn-blue with-icon" href="?page=la_onionbuzz_dashboard&tab=quiz_question_answer_edit&quiz_id=<?=$data['quiz_info']['id']?>&question_id=<?=$data['question_info']['id']?>&answer_id=<?=$data['next_item']['id']?>"><span class="icon-arrow-right"></span></a>
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
            Answer: <?=$data['edit_answer']['page_title']?>
        </div>

        <div class="laqm-tabs-tools-container">

            <div class="laqm-tabs">
                <div class="laqm-tab-item">
                    <a class="laqm-tab-item-link" href="?page=la_onionbuzz_dashboard&tab=quiz_question_edit&quiz_id=<?=$data['edit_answer']['quiz_id']?>&question_id=<?=$data['edit_answer']['question_id']?>">Edit question</a>
                </div>
                <div class="laqm-tab-item">
                    <a class="laqm-tab-item-link" href="?page=la_onionbuzz_dashboard&tab=quiz_question_answers&question_id=<?=$data['edit_answer']['question_id']?>&quiz_id=<?=$data['edit_answer']['quiz_id']?>">Answers (<?=$data['edit_answer']['answers_count']?>)</a>
                    <div class="pull-right">
                        <a class="laqm-btn laqm-btn-txt-large laqm-btn-blue" href="?page=la_onionbuzz_dashboard&tab=quiz_question_answer_edit&quiz_id=<?=$data['edit_answer']['quiz_id']?>&question_id=<?=$data['edit_answer']['question_id']?>"><span class="icon-ico-add"></span></a>
                    </div>
                </div>
                <div class="laqm-tab-item active">
                    <a class="laqm-tab-item-link" href="#">Edit answer</a>
                </div>
            </div>
            <div class="laqm-tools floating-this">
                <div class="laqm-tools-item pull-right">
                    <a class="laqm-btn laqm-btn-green" href="#answer/<?=$data['edit_answer']['id']?>/save">Save</a>
                </div>
            </div>

            <div style="clear: both;"></div>

        </div>

        <div class="laqm-tab-content">

            <div class="laqm-edit-tab edit-general" data-content="edit-general">

                <form class="form-horizontal form-ays">
                    <div class="form-group">
                        <label class="col-sm-3 control-label-left">Published</label>
                        <div class="col-sm-3">
                            <div class="switch">
                                <input id="answer_published" name="answer_published" class="cmn-toggle cmn-toggle-round-flat" type="checkbox" <?=($data['edit_answer']['flag_published'] == 1 || !$data['edit_answer']['id'])?'checked':''?> value="<?=$data['edit_answer']['flag_published']?>">
                                <label for="answer_published" data-on="Yes" data-off="No"></label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label-left">Short answer</label>
                        <div class="col-sm-9">
                            <input name="answer_title" type="text" class="form-control"  value="<?=esc_html($data['edit_answer']['title'])?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label-left">Image<p class="help-block">Min width depends on your theme's page width</p></label>
                        <div class="col-sm-9">
                            <a id="media_test" class="laqm-item-image-add" href="#" <?=(isset($data['edit_answer']['featured_image']) && $data['edit_answer']['featured_image'] != '')?'style="background-image: url('.$data['edit_answer']['featured_image'].');"':''?>>
                            </a>
                            <input name="featured_image" value="<?=$data['edit_answer']['featured_image']?>" type="hidden">
                            <input name="attachment_id" value="" type="hidden">
                            <a class="remove-featured-image" href="javascript:void(0);">Remove</a>
                        </div>
                    </div>
                    <?php if($data['quiz_info']['type'] == 1){?>
                    <div class="form-group">
                        <label class="col-sm-3 control-label-left">Correct answer</label>
                        <div class="col-sm-3">
                            <div class="switch">
                                <input id="cmn-toggle-1" name="flag_correct" class="cmn-toggle cmn-toggle-round-flat" type="checkbox" <?=($data['edit_answer']['flag_correct'] == 1)?'checked':''?> value="<?=$data['edit_answer']['flag_correct']?>">
                                <label for="cmn-toggle-1" data-on="Yes" data-off="No"></label>
                            </div>
                        </div>
                    </div>
                    <?php } ?>
                    <?php if($data['quiz_info']['type'] == 2){?>
                        <hr>
                        <div class="form-group">
                            <label class="col-sm-12">
                                How many points this answer gives to each result?
                                <p class="help-block">Leave 0 if answer doesn’t affect result. <a href="http://onionbuzz.com/doc/personality/" target="_blank">Guide</a></p>
                            </label>
                        </div>
                        <div class="form-group">
                            <div class="la-answer-personalities col-sm-12">
                                <?php foreach($data['quiz_results'] as $k=>$v){?>

                                    <div class="la-answer-personality" data-result-id="<?=$data['quiz_results'][$k]['id']?>">
                                        <div class="la-answer-personality-info">

                                                <div class="la-answer-personality-image" style="background-image: url(<?php if($data['quiz_results'][$k]['featured_image']){?><?=$data['quiz_results'][$k]['featured_image']?><?php }?>);">
                                                </div>

                                            <div class="la-answer-personality-title"><?=$data['quiz_results'][$k]['title']?></div>
                                        </div>
                                        <div class="la-answer-personality-points">
                                            <div class="flat-slider" data-slider-id="<?=$data['quiz_results'][$k]['id']?>" data-slider-value="<?=$data['quiz_results'][$k]['points']?>"></div>
                                        </div>
                                    </div>


                                <?php } ?>
                            </div>
                        </div>

                    <?php } ?>

                </form>

            </div>

        </div>

    </div>
</div>