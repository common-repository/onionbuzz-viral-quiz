<div id="quiz<?=$data['quiz_info']['id']?>" class="la-shortcode-container shortcode-quiz quiz-slider" data-quiz-id="<?=$data['quiz_info']['id']?>" data-quiz-type="<?=$data['quiz_info']['type']?>" data-quiz-layout="<?=$data['quiz_info']['layout']?>" data-quiz-optin-form="<?=$data['settings']['optin']['display_optin_form']?>" data-quiz-lock-results="<?=$data['settings']['optin']['settings_resultlock']?>" data-lock-button-facebook="<?=$data['settings']['optin']['lock_button_facebook']?>" data-lock-button-twitter="<?=$data['settings']['optin']['lock_button_twitter']?>" data-lock-button-google="<?=$data['settings']['optin']['lock_button_google']?>" data-quiz-autoscroll="<?=$data['settings']['quiz']['auto_scroll']?>" data-quiz-answer-status="<?=$data['settings']['quiz']['answer_status']?>" data-quiz-slider="1">
    <?php if($data['options']['embed'] == 0){?>
    <?php if($data['options']['description']){?>
        <div class="la-quiz-description">
            <p><?=do_shortcode($data['quiz_info']['description'])?></p>
        </div>
    <?php } ?>
    <?php } ?>

    <div class="<?php if($data['options']['embed'] == 1){?>laqm-slider-block<?php } ?> laqm-slider-intro laqm-slide" data-slide="0">
        <?php if($data['options']['title']){?>
        <div class="la-quiz-title"><h1 class=""><?=$data['quiz_info']['title']?></h1></div>
        <hr>
        <?php } ?>

        <?php if($data['options']['image']){?>
        <div class="la-quiz-image"><?php echo get_the_post_thumbnail( $data['quiz_info']['post_id'], 'large' ); ?></div>
        <div class="la-quiz-image-caption"><?=$data['quiz_info']['image_caption']?></div>
        <?php } ?>
        <?php if($data['options']['embed'] == 1){?>
            <?php if($data['options']['description']){?>
                <div class="la-quiz-description">
                    <p><?=$data['quiz_info']['description']?></p>
                </div>
            <?php } ?>
        <?php } ?>

    </div>

    <div class="<?php if($data['options']['embed'] == 1){?>laqm-slider-block<?php } ?> laqm-slides">
        <?php if($data['options']['description'] && $data['options']['embed'] == 0){?>
            <hr>
        <?php } ?>
        <?php if($data['options']['embed'] == 1){?>
        <div class="la-quiz-title"><h4 class="entry-title"><?=$data['quiz_info']['title']?></h4></div>
        <?php } ?>
        <?php if($data['options']['embed'] == 1){?>
        <div class="la-quiz-result-progress">
            <div class="progress-bar" style="background-color: <?=$data['settings']['appearance']['progress_bar_color']?>;">
                <!--<div>1 of 10</div>-->
            </div>
        </div>
        <?php } ?>

        <div class="laqm-slides-container">
            <?php
            $adv_counter = 0;
            foreach ($data['quiz_questions']['items'] as $k=>$v) {
                $adv_counter++;
            ?>
            <div class="laqm-slide inside data-quiz-question style-type-<?=$data['quiz_info']['type']?>" data-quiz-question="<?=$data['quiz_questions']['items'][$k]['id']?>" data-slide="<?=$k+1?>">
                <?php if($data['quiz_info']['type'] == 1 || $data['quiz_info']['type'] == 2 || $data['quiz_info']['type'] == 5) {?>
                <div class="laqm-slide-title"><?php printf( esc_html__( 'Question %1$s of %2$s.', OBVQ_PLUGIN_TEXTDOMAIN ), $k+1, count($data['quiz_questions']['items']) );?></div>

                <?php } ?>
                <?php if($data['quiz_info']['type'] == 3 || $data['quiz_info']['type'] == 4) {?>
                    <div class="laqm-slide-title"><?php printf( esc_html__( 'Slide %1$s of %2$s.', OBVQ_PLUGIN_TEXTDOMAIN ), $k+1, count($data['quiz_questions']['items']) );?></div>
                <?php } ?>
                <div class="la-quiz-question-title"><h3><?=$data['quiz_questions']['items'][$k]['title']?></h3></div>
                <?php if($data['quiz_info']['flag_list_ranked'] == 1) {?>
                    <div class="laqm-upvote-button withtext upvote-question" data-voted="<?=$data['quiz_questions']['items'][$k]['voted']?>" data-question-id="<?=$data['quiz_questions']['items'][$k]['id']?>" href="javascript:void(0);"> <span class="upvote-number"><?=$data['quiz_questions']['items'][$k]['votes']?></span><div class="iconhere"><span class="icon-ico-upvote"></span></div></div>
                <?php } ?>
                <div style="clear: both;"></div>
                <?php if($data['options']['embed'] == 0){?>
                    <div class="la-quiz-result-progress">
                        <div class="progress-bar" style="background-color: <?=$data['settings']['appearance']['progress_bar_color']?>;">
                            <!--<div>1 of 10</div>-->
                        </div>
                    </div>
                <?php } ?>

                <?php if($data['quiz_info']['type'] == 1 || $data['quiz_info']['type'] == 2 || $data['quiz_info']['type'] == 3 || $data['quiz_info']['type'] == 5) {?>
                    <?php if($data['quiz_questions']['items'][$k]['featured_image']) {?>
                        <div class="la-quiz-question-image">
                            <img src="<?=$data['quiz_questions']['items'][$k]['featured_image']?>">
                        </div>
                        <div class="la-quiz-image-caption"><?=$data['quiz_questions']['items'][$k]['image_caption']?></div>
                    <?php } ?>
                <?php } ?>
                <?php if($data['quiz_info']['type'] == 4) {?>
                    <?php if($data['quiz_questions']['items'][$k]['featured_image']) {?>
                        <div class="la-quiz-question-image flipcard">
                            <div class="card" data-card-id="<?=$data['quiz_questions']['items'][$k]['id']?>" data-fliped="0">
                                <div class="front"><div class="symbol"><span class="icon-flip-symbol"></span></div><span><img src="<?=$data['quiz_questions']['items'][$k]['featured_image']?>"></span></div>
                                <div class="back"><div class="symbol"><span class="icon-flip-symbol"></span></div><span><img src="<?=$data['quiz_questions']['items'][$k]['secondary_image']?>"></span></div>
                            </div>
                        </div>
                        <div class="la-quiz-question-image-caption">
                            <?=$data['quiz_questions']['items'][$k]['image_caption']?>
                        </div>
                    <?php } ?>
                <?php } ?>
                <div class="la-quiz-question-description">
                    <p><?=$data['quiz_questions']['items'][$k]['description']?></p>
                </div>

                <?php if($data['quiz_questions']['items'][$k]['answers_type'] == 'mediagrid'){?>
                    <div class="la-quiz-question-answers flex-stretch <?=$data['quiz_questions']['items'][$k]['mediagrid_type']?> ">
                        <div class="la-quiz-answers-grid">
                            <?php foreach ($data['quiz_questions']['items'][$k]['answers']['items'] as $k1=>$v1) { ?>
                                <div class="la-quiz-question-answer-item quiz-answer " data-quiz-answer="<?=$data['quiz_questions']['items'][$k]['answers']['items'][$k1]['id']?>" data-quiz-answer-l="0" data-quiz-answer-c="<?=($data['quiz_questions']['items'][$k]['answers']['items'][$k1]['flag_correct'] == 1)?'1':'0'?>">
                                    <div class="icon-ico-correct"><span class="path1"></span><span class="path2"></span></div>
                                    <div class="icon-ico-incorrect"><span class="path1"></span><span class="path2"></span></div>
                                    <?php if($data['quiz_questions']['items'][$k]['answers']['items'][$k1]['featured_image']) {?>
                                        <div class="la-quiz-question-answer-image"><img src="<?=$data['quiz_questions']['items'][$k]['answers']['items'][$k1]['featured_image']?>"></div>
                                    <?php } ?>
                                    <div class="la-quiz-question-answer-actions">
                                        <div class="la-quiz-question-answer-trigger"><input class="answer-checkbox" name="selected_answers[]" type="checkbox" value="<?=$data['quiz_questions']['items'][$k]['answers']['items'][$k1]['id']?>" style="display: none;"></div>
                                        <div class="la-quiz-question-answer-title"><?=$data['quiz_questions']['items'][$k]['answers']['items'][$k1]['title']?></div>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                <?php } ?>
                <?php if($data['quiz_questions']['items'][$k]['answers_type'] == 'list'){?>
                    <div class="la-quiz-question-answers ">
                        <div class="la-quiz-answers-list">
                            <?php foreach ($data['quiz_questions']['items'][$k]['answers']['items'] as $k1=>$v1) { ?>
                                <div class="la-quiz-question-answer-item quiz-answer " data-quiz-answer="<?=$data['quiz_questions']['items'][$k]['answers']['items'][$k1]['id']?>" data-quiz-answer-l="0" data-quiz-answer-c="<?=($data['quiz_questions']['items'][$k]['answers']['items'][$k1]['flag_correct'] == 1)?'1':'0'?>">
                                    <div class="la-quiz-question-answer-actions">
                                        <div class="la-quiz-question-answer-title"><?=$k1+1?>. <?=$data['quiz_questions']['items'][$k]['answers']['items'][$k1]['title']?></div>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                <?php } ?>
                <?php if($data['quiz_questions']['items'][$k]['answers_type'] == 'match'){?>
                    <div class="la-quiz-question-answers ">
                        <div class="la-quiz-answers-list answerslist<?=$data['quiz_questions']['items'][$k]['id']?>">
                            <div class="la-quiz-match-input">
                                <div class="quiz-answer-input" >
                                    <input class="la-quiz-match-answers-string" style="display: none;" data-casesensitive="<?=$data['quiz_questions']['items'][$k]['flag_casesensitive']?>" value="<?php foreach ($data['quiz_questions']['items'][$k]['answers']['items'] as $k1=>$v1) { ?><?=esc_html($data['quiz_questions']['items'][$k]['answers']['items'][$k1]['title'])?><?php if($k1+1 < count($data['quiz_questions']['items'][$k]['answers']['items'])){ echo ",";} }?>">
                                    <input class="la-quiz-match-typed" placeholder="Type your answer here...">
                                    <div class="input-button-inside la-quiz-match-check" data-question-id="<?=$data['quiz_questions']['items'][$k]['id']?>"><?=__( 'GUESS', OBVQ_PLUGIN_TEXTDOMAIN )?></div>
                                </div>
                                <div class="la-quiz-match-giveup" data-question-id="<?=$data['quiz_questions']['items'][$k]['id']?>"><?=__( 'I give up', OBVQ_PLUGIN_TEXTDOMAIN )?></div>
                            </div>

                            <?php foreach ($data['quiz_questions']['items'][$k]['answers']['items'] as $k1=>$v1) { ?>
                                <div style="display: none;" class="la-quiz-question-answer-item quiz-answer " data-quiz-answer="<?=$data['quiz_questions']['items'][$k]['answers']['items'][$k1]['id']?>" data-quiz-answer-l="0" data-quiz-answer-c="<?=($data['quiz_questions']['items'][$k]['answers']['items'][$k1]['flag_correct'] == 1)?'1':'0'?>">
                                    <div class="la-quiz-question-answer-actions">
                                        <div class="la-quiz-question-answer-title"><?=$data['quiz_questions']['items'][$k]['answers']['items'][$k1]['title']?></div>
                                    </div>
                                </div>
                            <?php } ?>
                            <div style="display: none;" class="la-quiz-question-answer-item quiz-answer " data-quiz-answer="0" data-quiz-answer-l="0" data-quiz-answer-c="0">
                                <div class="la-quiz-question-answer-actions">
                                    <div class="la-quiz-question-answer-title">wrong placeholder</div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
                <?php if($data['quiz_questions']['items'][$k]['flag_explanation'] == 1){ ?>
                    <div class="la-quiz-question-explanation question-explanation" data-answers-type="<?=$data['quiz_questions']['items'][$k]['answers_type']?>" data-flag-explanation="<?=$data['quiz_questions']['items'][$k]['flag_explanation']?>">
                        <div class="explanation-icon">
                            <span class="icon-ico-correct" style="display: none;"><span class="path1"></span><span class="path2"></span></span>
                            <span class="icon-ico-incorrect" style="display: none;"><span class="path1"></span><span class="path2"></span></span>
                        </div>
                        <div class="explanation-info">
                            <h3 class="explanation-title"><?php if ($data['quiz_questions']['items'][$k]['explanation_title'] != ''){ ?><?=$data['quiz_questions']['items'][$k]['explanation_title']?><?php } ?></h3>
                            <?php if ($data['quiz_questions']['items'][$k]['explanation_image'] != ''){ ?>
                                <div class="explanation-image">
                                    <img src="<?=$data['quiz_questions']['items'][$k]['explanation_image']?>">
                                </div>
                            <?php } ?>
                            <p><?=$data['quiz_questions']['items'][$k]['explanation']?></p>
                        </div>
                        <div style="clear: both;"></div>
                    </div>
                <?php } ?>
            </div>
            <?php } ?>

        </div>
    </div>

    <div class="laqm-slider-nav-block">

            <div class="onionbuzz-table-outer">
                <div class="onionbuzz-table-middle">
                    <div class="onionbuzz-table-inner">
                        <div class="laqm-slider-nav-prev">
                            <a class="laqm-slider-nav-button laqm-slider-prev" style="border-color: <?=$data['settings']['appearance']['ui_elements_color']?>; background-color: <?=$data['settings']['appearance']['ui_elements_color']?>; color: <?=$data['settings']['appearance']['label_color']?>;" href="javascript:void(0);"><div class="iconhere"><span class="icon-arrow-left"></span></div></a>
                        </div>
                    </div>
                </div>
                <div class="onionbuzz-table-middle per60 toleft">
                    <div class="onionbuzz-table-inner">

                        <?php if($data['quiz_info']['type'] == 1 || $data['quiz_info']['type'] == 2 || $data['quiz_info']['type'] == 5) {?>
                            <div class="laqm-slider-nav-text"><h4><span class="current-slide-text"><?=__('Next question 1', OBVQ_PLUGIN_TEXTDOMAIN)?></span> <?php printf( esc_html__( 'of %d', OBVQ_PLUGIN_TEXTDOMAIN ), count($data['quiz_questions']['items']) ); ?></h4></div>
                        <?php } ?>
                        <?php if($data['quiz_info']['type'] == 3 || $data['quiz_info']['type'] == 4) {?>
                            <div class="laqm-slider-nav-text"><h4><span class="current-slide-text"><?=__('Next slide 1', OBVQ_PLUGIN_TEXTDOMAIN)?></span> <?php printf( esc_html__( 'of %d', OBVQ_PLUGIN_TEXTDOMAIN ), count($data['quiz_questions']['items']) ); ?></h4></div>
                        <?php } ?>
                    </div>
                </div>

                <div class="onionbuzz-table-middle">
                    <div class="onionbuzz-table-inner">
                        <div class="laqm-slider-nav-next">
                            <?php if($data['quiz_info']['type'] == 1 || $data['quiz_info']['type'] == 2 || $data['quiz_info']['type'] == 5) {?>
                                <a class="laqm-slider-nav-button withtext laqm-slider-play" style="border-color: <?=$data['settings']['appearance']['ui_elements_color']?>; background-color: <?=$data['settings']['appearance']['ui_elements_color']?>; color: <?=$data['settings']['appearance']['label_color']?>;" href="javascript:void(0);"><?=__('Play', OBVQ_PLUGIN_TEXTDOMAIN)?>&nbsp;<div class="iconhere" style="margin-left: 10px;"><span class="icon-ico-play"></span></div></a>
                            <?php } ?>
                            <?php if($data['quiz_info']['type'] == 3 || $data['quiz_info']['type'] == 4) {?>
                                <a class="laqm-slider-nav-button withtext laqm-slider-play" style="border-color: <?=$data['settings']['appearance']['ui_elements_color']?>; background-color: <?=$data['settings']['appearance']['ui_elements_color']?>; color: <?=$data['settings']['appearance']['label_color']?>;" href="javascript:void(0);"><?=__('Start', OBVQ_PLUGIN_TEXTDOMAIN)?>&nbsp;<div class="iconhere" style="margin-left: 10px;"><span class="icon-ico-play"></span></div></a>
                            <?php } ?>
                            <a class="laqm-slider-nav-button withtext laqm-slider-first" style="display:none; border-color: <?=$data['settings']['appearance']['ui_elements_color']?>; background-color: <?=$data['settings']['appearance']['ui_elements_color']?>; color: <?=$data['settings']['appearance']['label_color']?>;" href="javascript:void(0);"><?=__('Start Over', OBVQ_PLUGIN_TEXTDOMAIN)?>&nbsp;&nbsp;<div class="iconhere"><span class="icon-ico-replay"></span></div></a>
                            <?php if($data['quiz_info']['type'] == 5) {?>
                                <div class="la-quiz-checklist-show-result" style="margin-bottom: 10px;"><a class="laqm-slider-nav-button withtext checklist-result-button" href="javascript:void(0);" style="border-color: <?=$data['settings']['appearance']['ui_elements_color']?>; background-color: <?=$data['settings']['appearance']['ui_elements_color']?>; color: <?=$data['settings']['appearance']['label_color']?>;"><?=__('Show results!', OBVQ_PLUGIN_TEXTDOMAIN)?></a></div>
                            <?php } ?>
                            <a class="laqm-slider-nav-button withtext laqm-slider-next" style="display:none; border-color: <?=$data['settings']['appearance']['ui_elements_color']?>; background-color: <?=$data['settings']['appearance']['ui_elements_color']?>; color: <?=$data['settings']['appearance']['label_color']?>;" href="javascript:void(0);"><?=__('Next', OBVQ_PLUGIN_TEXTDOMAIN)?> <div class="iconhere"><span class="icon-arrow-right"></span></div></a>
                        </div>
                    </div>
                </div>
            </div>




        <div style="clear: both;"></div>
    </div>

</div>
<div class="laqm-loader"></div>
<div class="la-quiz-result" >
    <div class="la-quiz-result-block">
        <div class="la-quiz-result-title"><h1></h1></div>
        <div class="la-quiz-result-score"><h3></h3></div>
        <div style="clear: both;"></div>
        <?php if($data['quiz_info']['type'] == 1 || $data['quiz_info']['type'] == 2 || $data['quiz_info']['type'] == 5) {?>
            <div class="laqm-slide-title"><?php printf( esc_html__( 'All %d questions completed!', OBVQ_PLUGIN_TEXTDOMAIN ), count($data['quiz_questions']['items']) ); ?></div>
        <?php } ?>
        <?php if($data['quiz_info']['type'] == 3 || $data['quiz_info']['type'] == 4) {?>

        <?php } ?>

        <div class="la-quiz-result-progress">
            <div class="progress-bar" style="background-color: <?=$data['settings']['appearance']['progress_bar_color']?>;"></div>
        </div>
        <div class="la-quiz-result-image"></div>
        <div class="la-quiz-result-caption"></div>
        <div class="la-quiz-result-description"><p></p></div>

        <hr>

        <?php if($data['settings']['social']['share_results_buttons'] == 1){?>
            <div class="la-quiz-result-share">
                <h4 class="nomarginbottom" style=""><?=__('Share results:', OBVQ_PLUGIN_TEXTDOMAIN)?></h4>
                <div class="la-quiz-result-share-buttons">
                    <a class="la-front-button la-front-button-icon la-social-share facebook s_facebook" href="javascript:void(0);"><span class="icon-facebook"></span></a>
                    <a class="la-front-button la-front-button-icon la-social-share google s_plus" href="javascript:void(0);"><span class="icon-google-plus"></span></a>
                    <a class="la-front-button la-front-button-icon la-social-share twitter s_twitter" href="javascript:void(0);"><span class="icon-twitter"></span></a>
                    <a class="la-front-button la-front-button-icon la-social-share email s_mail" href="javascript:void(0);"><span class="icon-envelope"></span></a>
                </div>
            </div>
        <?php } ?>

    </div>

    <?php if($data['settings']['quiz']['replay_button']){?>
        <div class="la-quiz-result-block repl">
            <div class="onionbuzz-table-outer">
                <div class="onionbuzz-table-middle">
                    <div class="onionbuzz-table-inner">

                        <div class="la-quiz-result-quiz"><h4><?=$data['quiz_info']['title']?></h4></div>

                    </div>
                </div>

                <div class="onionbuzz-table-middle">
                    <div class="onionbuzz-table-inner">

                        <div class="la-quiz-result-button-replay">
                            <?php if($data['quiz_info']['type'] == 1 || $data['quiz_info']['type'] == 2 || $data['quiz_info']['type'] == 5) {?>
                                <a class="la-play-again withtext" style="border-color: <?=$data['settings']['appearance']['ui_elements_color']?>; background-color: <?=$data['settings']['appearance']['ui_elements_color']?>; color: <?=$data['settings']['appearance']['label_color']?>;" href="javascript:void(0);"><div class="iconhere"><span class="icon-ico-replay"></span></div> <?=__('Replay', OBVQ_PLUGIN_TEXTDOMAIN)?></a>
                            <?php } ?>
                            <?php if($data['quiz_info']['type'] == 3 || $data['quiz_info']['type'] == 4) {?>
                                <a class="la-play-again withtext" style="border-color: <?=$data['settings']['appearance']['ui_elements_color']?>; background-color: <?=$data['settings']['appearance']['ui_elements_color']?>; color: <?=$data['settings']['appearance']['label_color']?>;" href="javascript:void(0);"><div class="iconhere"><span class="icon-ico-replay"></span></div> <?=__('Start Over', OBVQ_PLUGIN_TEXTDOMAIN)?></a>
                            <?php } ?>
                        </div>

                    </div>
                </div>
            </div>
        </div>

    <?php } ?>
</div>
<div class="la-quiz-sharelock" style="display: none;">

    <h3 class="la-quiz-form-title nomarginbottom"><?=$data['settings']['optin']['sharing_heading']?></h3>
    <div style="margin-bottom: 2px;">

        <div class="la-quiz-result-share-buttons">
            <a class="la-front-button la-front-button-icon lock-social-share facebook s2_facebook" data-network="facebook" href="javascript:void(0);"><span class="icon-facebook"></span></a>
            <a class="la-front-button la-front-button-icon lock-social-share google s2_plus" data-network="plus" href="javascript:void(0);"><span class="icon-google-plus"></span></a>
            <a class="la-front-button la-front-button-icon lock-social-share twitter s2_twitter" data-network="twitter" href="javascript:void(0);"><span class="icon-twitter"></span></a>
        </div>

    </div>
    <div style="clear: both;"></div>

</div>
<div class="la-quiz-email-form">
    <form id="la_ask_before_result_form">
        <h1 class="la-quiz-form-title nomarginbottom"><?=$data['settings']['optin']['form_heading']?></h1>
        <div class="la-quiz-form-subtitle"><?=$data['settings']['optin']['form_subtitle']?></div>
            <div style="margin-bottom: 2px;">
                <!--<div class="la-quiz-form-right">

                </div>
                <div class="la-quiz-form-left">

                </div>-->
                <div><input name="la-ask-email" type="text" class="" value="" placeholder="<?=__('Your Email', OBVQ_PLUGIN_TEXTDOMAIN)?> *" ></div>
                <div><a class="la-submit-email-form la-front-button" href="javascript:void(0);" style="border-color: <?=$data['settings']['appearance']['ui_elements_color']?>; background-color: <?=$data['settings']['appearance']['ui_elements_color']?>; color: <?=$data['settings']['appearance']['label_color']?>;"><?=$data['settings']['optin']['submit_button_text']?></a></div>


            </div>
            <div style="clear: both;"></div>
            <div class="la-quiz-form-warn"><?=$data['settings']['optin']['optin_warning']?></div>
    </form>
</div>