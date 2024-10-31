(function($) {
    'use strict';

    var Quiz = function(options){

        var self = this;
        this.init = function(){
            self._bindEvents();
        }

        this.settings = $.extend( {
            'quiz_id': 0,
            'type': 1,
            'layout': 'fulllist',
            'lock_results' : 0,
            'optin_form': 0,
            'autoscroll' : 0,
            'answer_status' : 0,
            'slider' : 0,
            'autoscroll_time': 1000,
            'scroll_offset': -50,
            'lock_button_facebook': 0,
            'lock_button_twitter': 0,
            'lock_button_google': 0,
        }, options);

        this.total_questions        = 0;
        this.correctAnswers         = []; // type 1
        this.total_currect_answers  = 0;
        //this.personalitiesData    = []; //type 2
        this.selectedAnswers        = [];
        this.is_answer_selected     = 1;
        this.total_answers          = $('.quiz-answer').length;

        if(self.settings.slider == 1){
            //slider var
            this.is_intro       = 1;
            this.current_slide  = 0;
            this.total_slides   = this.total_questions;
            this.is_result      = 0;
            $('.laqm-slides').hide();
            $('.laqm-slide').hide();
            $('.laqm-slider-intro').show();
            $('.laqm-slider-nav-prev').hide();
            $('.la-quiz-checklist-show-result').hide();
        }

        $('div[data-quiz-question]').each(function(i){
            var $this = $(this);
            self.correctAnswers.push( {'question': $this.data('quiz-question') , answer: $this.find('.quiz-answer[data-quiz-answer-c="1"]').data("quiz-answer")} );
        });


        //console.log("correct answers:"+this.correctAnswers.length);

        this._totalQuestions = function(){
            var counter = 0;
            $('div[data-quiz-question]').each(function(i){
                counter++;
            });
            return counter;
        }

        this.total_questions = this._totalQuestions();
        this.total_slides = this.total_questions;

        this._pickAnswer = function($answer, $answers){
            if(self.settings.type == 5){
                if($answer.data('quiz-answer-l') == 0){
                    $answer.addClass('active');
                    //$answer.removeClass('notselected');
                    $answer.addClass('selected');
                    $answer.data('quiz-answer-l', 1);

                }
                else{
                    $answer.removeClass('active');
                    //$answer.addClass('notselected');
                    $answer.removeClass('selected');
                    $answer.data('quiz-answer-l', 0);
                }
            }
            else{
                if($answer.data('quiz-answer-l') == 0){
                    $answers.find('.quiz-answer').removeClass('active');
                    $answers.find('.quiz-answer').addClass('notselected');
                    $answers.find('.answer-checkbox').attr('checked', false);
                    $answers.find('.quiz-answer').removeClass('animated bounceIn');
                    $answer.addClass('animated bounceIn');
                    var $explanation = $answers.find('.question-explanation');
                    if($explanation.data('flag-explanation') == 1){
                        $explanation.show();
                    }
                    $answer.addClass('active');
                    $answer.removeClass('notselected');
                    $answer.addClass('selected');
                    $answer.find('.answer-checkbox').attr('checked', true);

                    $answers.find('.la-quiz-question-answer-item').each(function() {
                        var $thisAnswers = $(this);
                        var is_image_in_answer = $thisAnswers.find('.la-quiz-question-answer-image').length;
                        if(is_image_in_answer == 0){
                            $thisAnswers.find('.icon-ico-correct').remove();
                            $thisAnswers.find('.icon-ico-incorrect').remove();
                        }
                    });



                    if($('.shortcode-quiz').data("quiz-answer-status") == 1){
                        if($answer.data("quiz-answer-c") == 1){
                            $answer.addClass('correct');
                            $answers.find(".question-explanation").addClass('correct');
                            $answers.find(".question-explanation .explanation-icon .icon-ico-correct").show();
                            $answers.find(".question-explanation .explanation-info .explanation-title").prepend(onionbuzz_lng.Correct+" ");
                        }
                        else{
                            $answer.addClass('incorrect');
                            $answers.find(".question-explanation").addClass('incorrect');
                            $answers.find(".question-explanation .explanation-icon .icon-ico-incorrect").show();

                            if($answers.find(".question-explanation").data("answers-type") != "match"){
                                $answers.find(".question-explanation .explanation-info .explanation-title").prepend(onionbuzz_lng.Wrong+" ");
                            }

                            $answers.find("div[data-quiz-answer-c='1']").addClass('active correct');
                            $answers.find("div[data-quiz-answer-c='1'] .icon-ico-correct").hide();
                        }
                        $answers.find('.quiz-answer').data('quiz-answer-l', 1);
                    }
                }
            }


        }
        this._setProgressBarTrivia = function (){
            var setto = self.total_currect_answers * 100 / self.total_questions;
            $('.progress-bar').css("width", setto+"%");
        }
        this._setProgressBarChecklist = function (){
            var setto = self._calcResultChecklist() * 100 / self.total_answers;
            $('.progress-bar').css("width", setto+"%");
        }
        this._setProgressBarSlider = function (value){
            var setto = self.current_slide * 100 / self.total_slides;
            //console.log(setto);
            $('.progress-bar').css("width", setto+"%");
        }
        this._setProgressBar = function (value){
            $('.progress-bar').css("width", value+"%");
        }
        this._calcResult = function(){
            var numberOfCorrectAnswers = 0;

            $('div[data-quiz-question]').each(function(i){
                var $this = $(this),
                    chosenAnswer = $this.find('.quiz-answer.active.selected').data('quiz-answer'),
                    correctAnswer;

                for ( var j = 0; j < self.correctAnswers.length; j++ ) {
                    var a = self.correctAnswers[j];
                    if ( a.question == $this.data('quiz-question') ) {
                        correctAnswer = a.answer;
                    }
                }

                if ( chosenAnswer == correctAnswer ) {
                    numberOfCorrectAnswers++;

                    // highlight this as correct answer
                    $this.find('.quiz-answer.active.selected').addClass('correct');
                }
                else {
                    $this.find('.quiz-answer[data-quiz-answer="'+correctAnswer+'"]').addClass('correct');
                    $this.find('.quiz-answer.active.selected').addClass('incorrect');
                    $this.find('.quiz-answer.notselected.correct').addClass('active');
                }
            });
            self.total_currect_answers = numberOfCorrectAnswers;

            return numberOfCorrectAnswers;

        }
        this._calcResultChecklist = function (){
            var numberOfSelectedAnswers = 0;
            $('.quiz-answer.active.selected').each(function(i) {
                numberOfSelectedAnswers++;
            });

            return numberOfSelectedAnswers;
        }
        this._calcResultPersonality = function(){
            //return {code: 'bad', text: 'Poor spelling skills'};
        }
        this._isComplete = function(){
            if(this.settings.type == 5){
                return false;
            }
            var answersComplete = 0;
            $('div[data-quiz-question]').each(function(){
                if ( $(this).find('.quiz-answer.active').length ) {
                    answersComplete++;
                }
            });
            if ( answersComplete >= self.total_questions ) {
                $('.quiz-answer.active').each(function(){
                    self.selectedAnswers.push($(this).data("quiz-answer"));
                });
                $('.laqm-slider-nav-block').hide();
                return true;
            }
            else {
                return false;
            }
        }
        this._showResult = function(result){
            $('.quiz-result').addClass(result.code).html(result.text);
        }
        this._scrollToEl = function(el){
            $('html, body').animate({
                scrollTop: $(el).offset().top + self.settings.scroll_offset
            }, self.settings.autoscroll_time);
            return false;
        }
        this._scrollToNextQuestion = function($answers){
            if(self.settings.slider == 0) {
                var ele = $answers.next($answers);
                if (ele.length) {
                    $('html, body').animate({
                        scrollTop: $(ele).offset().top + self.settings.scroll_offset
                    }, self.settings.autoscroll_time);
                }
            } else {
                self._gotoNextSlide();
            }
            return false;
        }
        this._gotoStartSlide = function(){
            //console.log('_gotoPrevSlide');
            $('.laqm-slide').hide();
            self.current_slide = 2;
            $("[data-slide='"+(self.current_slide)+"']").show();
            self._gotoPrevSlide();
        }
        this._gotoPrevSlide = function(){
            /*if(self.current_slide == 0) {
                self.is_intro = 1;
                self.current_slide = 0;
                $('.laqm-slider-intro').show();
                $('.laqm-slides').hide();
                self._scrollToEl(".laqm-slider-intro");
            }*/
            //console.log('_gotoPrevSlide');
            //console.log(self.current_slide+'/'+self.total_slides);

            if($("[data-slide='"+(self.current_slide)+"']").find('.quiz-answer.active').length > 0){
                self.is_answer_selected = 1;
            }

            if(self.current_slide > 1)
            {
                self.current_slide--;
                if(self.settings.type == 1 || self.settings.type == 2) {
                    $('.current-slide-text').html(onionbuzz_lng.Question+' ' + self.current_slide);
                }
                if(self.settings.type == 3 || self.settings.type == 4) {
                    if(self.current_slide != self.total_slides){
                        $('.laqm-slider-next').show();
                    }
                    $('.laqm-slider-first').hide();
                    $('.current-slide-text').html(onionbuzz_lng.Slide+' ' + self.current_slide);
                }
                if(self.settings.type == 5) {
                    if(self.current_slide != self.total_slides){
                        $('.laqm-slider-next').show();
                        $('.la-quiz-checklist-show-result').hide();
                    }
                    $('.laqm-slider-first').hide();
                    $('.current-slide-text').html(onionbuzz_lng.Question+' ' + self.current_slide);
                }
                $("[data-slide='"+(self.current_slide+1)+"']").hide();
                $("[data-slide='"+(self.current_slide)+"']").show();
                $("[data-slide='"+(self.current_slide)+"']").removeClass('animated fadeIn');
                $("[data-slide='"+(self.current_slide)+"']").addClass('animated fadeIn');
                //$("[data-slide='"+(self.current_slide)+"']").find('.la-quiz-question-image').removeClass('animated zoomInRight');
                //$("[data-slide='"+(self.current_slide)+"']").find('.la-quiz-question-image').addClass('animated zoomInLeft');
                self._scrollToEl(".laqm-slides");
                self._setProgressBarSlider();
                if(self.current_slide == 1){
                    $('.laqm-slider-nav-prev').hide();
                    $('.la-quiz-checklist-show-result').hide();
                }

            }
        }
        this._gotoNextSlide = function(){
            //console.log('_gotoNextSlide');
            //console.log(self.current_slide+'/'+self.total_slides);

            if($("[data-slide='"+(self.current_slide)+"']").find('.quiz-answer.active').length > 0){
                self.is_answer_selected = 1;
            }
            if(self.is_answer_selected == 0){
                $(this).addClass("animated wobble");
                $(this).one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function(){$(this).removeClass("animated wobble");});
            }

            if(self.is_intro == 1 && self.current_slide == 0) {
                self.is_intro = 0;
                $('.laqm-slider-intro').hide();
                $('.laqm-slides').show();
            }

            if(self.settings.type == 3 || self.settings.type == 4 || self.settings.type == 5) {
                self.is_answer_selected = 1;
            }

            if(self.current_slide < self.total_slides && self.is_answer_selected == 1)
            {
                self.is_answer_selected = 0;
                self.current_slide++;
                if(self.settings.type == 1 || self.settings.type == 2) {
                    $('.current-slide-text').html(onionbuzz_lng.Question+' ' + self.current_slide);
                }
                if(self.settings.type == 3 || self.settings.type == 4) {

                    $('.current-slide-text').html(onionbuzz_lng.Slide+' ' + self.current_slide);
                    if(self.current_slide == self.total_slides){
                        $('.laqm-slider-first').show();
                        $('.laqm-slider-next').hide();
                        $('.la-quiz-checklist-show-result').show();
                    }
                }
                if(self.settings.type == 5) {
                    $('.current-slide-text').html(onionbuzz_lng.Question+' ' + self.current_slide);
                    if(self.current_slide == self.total_slides){
                        $('.laqm-slider-first').hide();
                        $('.laqm-slider-next').hide();
                        $('.la-quiz-checklist-show-result').show();
                    }
                }
                $("[data-slide='"+(self.current_slide-1)+"']").hide();
                $("[data-slide='"+(self.current_slide)+"']").show();
                $("[data-slide='"+(self.current_slide)+"']").removeClass('animated fadeIn');
                $("[data-slide='"+(self.current_slide)+"']").addClass('animated fadeIn');
                //$("[data-slide='"+(self.current_slide)+"']").find('.la-quiz-question-image').removeClass('animated zoomInLeft');
                //$("[data-slide='"+(self.current_slide)+"']").find('.la-quiz-question-image').addClass('animated zoomInRight');
                self._scrollToEl(".laqm-slides");
                self._setProgressBarSlider();
                if(self.current_slide > 1){
                    $('.laqm-slider-nav-prev').show();
                }
            }
        }
        this._gotoResultSlide = function(){
            //console.log('_gotoResultSlide');
        }
        this._scrollToResult = function(){
            if(self.settings.slider == 0) {
                $('html, body').animate({
                    scrollTop: $('.la-quiz-result').offset().top + self.settings.scroll_offset
                });
            } else {
                //$('.laqm-slide').hide();
                self._gotoResultSlide();
                $('html, body').animate({
                    scrollTop: $('.la-quiz-result').offset().top + self.settings.scroll_offset
                });
            }
        }
        this._bindEvents = function(){
            $('.upvote-question').on("click", function(){
                var clicked_upvote_question = $(this).data("question-id");
                var is_voted = $(this).data("voted");
                var current_votes = parseInt($(".upvote-question[data-question-id='"+clicked_upvote_question+"']").find(".upvote-number").html());
                var type = 'set_count';
                var data = {
                    'action': 'ob_question_votes',
                    'id': clicked_upvote_question
                };
                //console.log(current_votes);

                if(is_voted == 1){
                    $(this).data("voted", 0);
                    current_votes = current_votes - 1;
                    $(".upvote-question[data-question-id='"+clicked_upvote_question+"']").find(".upvote-number").html(current_votes);
                    $(".upvote-question[data-question-id='"+clicked_upvote_question+"']").removeClass("upvoted");
                }
                else{
                    $(this).data("voted", 1);
                    current_votes = current_votes + 1;
                    $(".upvote-question[data-question-id='"+clicked_upvote_question+"']").find(".upvote-number").html(current_votes);
                    $(".upvote-question[data-question-id='"+clicked_upvote_question+"']").addClass("upvoted");
                }

                jQuery.post(onionbuzz_params.ajax_url + '?type=' + type, data, function (response) {
                    response = jQuery.parseJSON(response);

                    if (response.success == 1) {
                        //$(".upvote-question[data-question-id='"+clicked_upvote_question+"']").find(".upvote-number").html(response.votes);
                    }
                });
            });
            $('.checklist-result-button').on('click', function(){
                self._sendd();
                $('.quiz-answer').off('click');
                $('.laqm-slider-nav-block').hide();
                $('.la-quiz-checklist-show-result').hide();
            });
            $('.quiz-answer').on('click', function(){
                self.is_answer_selected = 1;
                var $this = $(this),
                    $answers = $this.closest('div[data-quiz-question]');
                self._pickAnswer($this, $answers);
                if(self.settings.autoscroll == 1){
                    setTimeout( function(){
                        self._scrollToNextQuestion($answers);
                    }, self.settings.autoscroll_time );

                }
                if ( self._isComplete() ) {

                    $('.quiz-answer').off('click');
                    setTimeout( function(){
                        self._sendd();
                    }, self.settings.autoscroll_time );

                }
            });
            $('.laqm-slider-play').on('click', function(){
                $(this).hide();
                $('.laqm-slider-next').show();
                self._gotoNextSlide();
            });
            $('.laqm-slider-next').on('click', function(){
                self._gotoNextSlide();
            });
            $('.laqm-slider-first').on('click', function(){
                self._gotoStartSlide();
            });
            $('.laqm-slider-prev').on('click', function(){
                self._gotoPrevSlide();
            });
            $('.la-submit-email-form').on('click', function(){
                //check form
                self._saveEmail();
            });
            $('#la_ask_before_result_form').submit(function(event){
                event.preventDefault(); // stop the actual submit
                self._saveEmail();
            });
            $('.la-play-again').on('click', function(){
                document.location.reload(true);
                $(window).on('beforeunload', function(){
                    $(window).scrollTop(0);
                });
            });
            $('.quiz-answer-input input').focusin(function(){
                $(this).parent('.quiz-answer-input').addClass('active');
            });
            $('.quiz-answer-input input').focusout(function(){
                if($(this).parent('.quiz-answer-input').find('.la-quiz-match-typed').val() == '') {
                    $(this).parent('.quiz-answer-input').removeClass('active');
                }
            });
            $('.la-quiz-match-check').on('click', function(){
                var $this_match = $(this).parent('.quiz-answer-input');
                var $parent_match = $this_match.parent('.la-quiz-match-input');
                var $parent_answers = $parent_match.parent('.la-quiz-answers-list');
                var casesensitive = $this_match.find('.la-quiz-match-answers-string').data("casesensitive");

                var checkMatchValue = $this_match.find('.la-quiz-match-typed').val();
                var checkMatchString = $this_match.find('.la-quiz-match-answers-string').val();
                if(casesensitive == 0){
                    var checkMatchValue = $this_match.find('.la-quiz-match-typed').val().toLowerCase();
                    var checkMatchString = $this_match.find('.la-quiz-match-answers-string').val().toLowerCase();
                }
                var splitString = checkMatchString.split(',');

                var matchFound;
                for (var i = 0; i < splitString.length; i++) {
                    var stringPart = splitString[i];
                    if (stringPart != checkMatchValue) continue;

                    matchFound = true;
                    break;
                }
                if(matchFound == true){
                    $this_match.removeClass('incorrect');
                    $this_match.addClass('correct');
                    $parent_answers.find('.la-quiz-match-giveup').animateCss('fadeOutUp');
                    $(this).addClass('correct');
                    $parent_answers.find('.la-quiz-match-giveup').one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function(){$parent_answers.find('.la-quiz-match-giveup').hide()});
                    $parent_answers.find('div[data-quiz-answer-c="1"]').first().trigger('click');
                    $('.answerslist'+$(this).data("question-id")).find('.la-quiz-match-typed').prop("disabled", true);
                    $(this).animateCss("rubberBand");
                    $(this).html('<span class="icon-ico-correct"><span class="path1"></span><span class="path2"></span></span>'+onionbuzz_lng.Correct);
                }
                else{
                    $(this).animateCss('shake');
                    $this_match.addClass('incorrect');
                    $parent_answers.find('.la-quiz-match-giveup').show();
                    $parent_answers.find('.la-quiz-match-giveup').animateCss('fadeInDown');
                }

            });
            $('.la-quiz-match-giveup').on("click", function(){
                $(this).removeClass('animated fadeInDown');
                $(this).addClass('animated fadeOutUp');
                $(this).one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function(){$(this).hide()});
                $('.answerslist'+$(this).data("question-id")).find('div[data-quiz-answer-c="0"]').first().trigger('click');
                $('.answerslist'+$(this).data("question-id")).find('.la-quiz-match-typed').val($('.answerslist'+$(this).data("question-id")).find('div[data-quiz-answer-c="1"]').first().find('.la-quiz-question-answer-title').text());
                $('.answerslist'+$(this).data("question-id")).find('.la-quiz-match-typed').prop("disabled", true);
                $('.answerslist'+$(this).data("question-id")).find('.la-quiz-match-check').animateCss('fadeOut');
                $('.answerslist'+$(this).data("question-id")).find('.la-quiz-match-check').one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function(){$(this).hide()});

            });
            $(".la-quiz-match-typed").on( "keydown", function(event) {
                if(event.which == 13) {
                    $(this).siblings(".la-quiz-match-check").trigger("click");
                }
            });
            $(".card").on("click", function(){
                if($(this).data("fliped") == "0"){
                    $(this).find(".front").addClass("flipit");
                    $(this).find(".back").addClass("flipit");
                    $(this).data("fliped", "1");
                }
                else{
                    $(this).find(".front").removeClass("flipit");
                    $(this).find(".back").removeClass("flipit");
                    $(this).data("fliped", "0");
                }

            });
            $('.lock-social-share').on('click', function () {
                self._lock_share_clicked($(this).data("network"));
            });
        }
        this._loadingInEl = function(el, state){
            if(state == 1){
                $(el).html("<div class='uil-rolling-css' style='transform:scale(0.2);'><div><div></div><div></div></div></div>");
            }
            else{
                $(el).html("");
            }

        }
        this._sendd = function(){

            self._scrollToEl(".laqm-loader");
            self._loadingInEl('.laqm-loader',1);

            if(self.settings.type == 1){
                var data = {
                    'action': 'ob_get_results',
                    'id': self.settings.quiz_id,
                    'quiz_type': self.settings.type,
                    'points': self._calcResult()
                };
            }
            else if(self.settings.type == 2){
                $('.la-quiz-result-score').hide();
                $('.la-quiz-result-title').addClass("width100per");
                var data = {
                    'action': 'ob_get_results',
                    'id': self.settings.quiz_id,
                    'quiz_type': self.settings.type,
                    'selectedAnswers': self.selectedAnswers
                };
            }
            else if(self.settings.type == 5){
                $('.laqm-slide-title').show();
                $('.laqm-slide-title').text(onionbuzz_lng.quiz_noresult_you_checked+' '+self._calcResultChecklist()+' '+onionbuzz_lng.quiz_noresult_out_of+' '+self.total_answers+' '+onionbuzz_lng.quiz_noresult_on_this_list);
                $('.la-quiz-result-score').hide();
                $('.la-quiz-result-title').addClass("width100per");
                var data = {
                    'action': 'ob_get_results',
                    'id': self.settings.quiz_id,
                    'quiz_type': self.settings.type,
                    'points': self._calcResultChecklist()
                };
            }

            var type = 'get_result';
            jQuery.post(onionbuzz_params.ajax_url + '?type=' + type, data, function (response) {
                response = jQuery.parseJSON(response);

                //console.log(response);

                if (response.success == 1) {
                    //self._showResult( self._calcResult() );

                    self._loadingInEl('.laqm-loader',0);

                    if(self.settings.slider == 1){
                        //$('.laqm-slides').show();
                        //$('.laqm-slide').show();
                    }
                    // sharelock subscribelock

                    if(self.settings.lock_results == 0){
                        $('.la-quiz-result').show();
                        self._scrollToResult();
                    }

                    if(self.settings.lock_results == 'subscribelock' && self.settings.optin_form == 1){
                        $('.la-quiz-email-form').show();
                        $('html, body').animate({
                            scrollTop: $('.la-quiz-email-form').offset().top + self.settings.scroll_offset
                        });
                    }
                    if(self.settings.lock_results == 'subscribelock' && self.settings.optin_form == 0){
                        $('.la-quiz-email-form').show();
                        $('html, body').animate({
                            scrollTop: $('.la-quiz-email-form').offset().top + self.settings.scroll_offset
                        });
                    }
                    if(self.settings.lock_results == 0 && self.settings.optin_form == 1){
                        $('.la-quiz-result').show();
                        self._scrollToResult();
                        $('.la-quiz-email-form').show();
                    }
                    if(self.settings.lock_results == 'sharelock'){
                        $('.la-quiz-sharelock').show();
                        $('html, body').animate({
                            scrollTop: $('.la-quiz-sharelock').offset().top + self.settings.scroll_offset
                        });
                    }
                    if(self.settings.lock_results == 'sharelock' && self.settings.optin_form == 1){
                        $('.la-quiz-sharelock').show();
                        $('html, body').animate({
                            scrollTop: $('.la-quiz-sharelock').offset().top + self.settings.scroll_offset
                        });
                        $('.la-quiz-email-form').show();
                    }

                    if(self.settings.lock_button_facebook == 0){
                        $('.lock-social-share.facebook').hide();
                    }
                    if(self.settings.lock_button_twitter == 0){
                        $('.lock-social-share.twitter').hide();
                    }
                    if(self.settings.lock_button_googe == 0){
                        $('.lock-social-share.google').hide();
                    }

                    /*if(self.settings.lock_results == 1 && self.settings.optin_form == 1){
                        $('.la-quiz-email-form').show();
                        $('html, body').animate({
                            scrollTop: $('.la-quiz-email-form').offset().top + self.settings.scroll_offset
                        });
                    }
                    else if(self.settings.lock_results == 0 && self.settings.optin_form == 1){
                        $('.la-quiz-result').show();
                        self._scrollToResult();
                        $('.la-quiz-email-form').show();
                    }
                    else{
                        $('.la-quiz-result').show();
                        self._scrollToResult();
                    }*/

                    if(self.settings.type == 1){
                        self._setProgressBarTrivia();
                    }
                    if(self.settings.type == 2){
                        self._setProgressBar(100);
                    }
                    if(self.settings.type == 5){
                        $('.laqm-slide-title').show();

                        //self._setProgressBar(100);
                        self._setProgressBarChecklist();
                    }

                    var result_title = response.title;
                    var result_description = response.description;
                    var result_description_for_share = $('<div>'+result_description+'</div>').text();
                    var result_image = response.featured_image;
                    var result_is_image = response.is_image;
                    var result_image_for_share = "";

                    $('.la-quiz-result').addClass(response.quiz_id);
                    if(result_title == '' || result_title == null) {
                        $('.la-quiz-result-title h1').text(onionbuzz_lng.quiz_noresult_i_got+' '+ data.points + ' '+onionbuzz_lng.quiz_noresult_of+' ' + self.total_questions + ' '+onionbuzz_lng.quiz_noresult_right);
                        if(self.settings.type == 5){
                            $('.laqm-slide-title').hide();
                            $('.la-quiz-result-title h1').text(onionbuzz_lng.quiz_noresult_i_checked+' '+ data.points + ' '+onionbuzz_lng.quiz_noresult_out_of+' ' + self.total_answers + ' '+onionbuzz_lng.quiz_noresult_on_this_list);
                        }
                        result_image_for_share = $('meta[property="og:image"]').attr("content");
                    }
                    else{
                        $('.la-quiz-result-title h1').text(result_title);
                        if(self.settings.type == 5){
                            $('.la-quiz-result-title').addClass("width100per");
                        }
                    }
                    if(data.points && (result_title != '' && result_title != null)) {
                        $('.la-quiz-result-title').removeClass("width100per");
                        $('.la-quiz-result-score h3').html(onionbuzz_lng.quiz_score+' ' + data.points + '<span>/' + self.total_questions + '</span>');
                        if(self.settings.type == 5){
                            $('.la-quiz-result-title').addClass("width100per");
                        }
                    }
                    else{

                    }
                    $('.la-quiz-result-description p').html(result_description);

                    if(result_is_image == 1){
                        $('.la-quiz-result-image').html(result_image);
                        $('.la-quiz-result-caption').html(response.image_caption);
                        result_image_for_share = window.location.protocol+'//'+document.location.hostname+$('.la-quiz-result-image img').attr("src");
                    }else{

                    }

                    if(result_title != '' && result_title != null) {
                        $('.la-social-share').ShareLink({
                            title: result_title, // title for share message
                            text: result_description_for_share, // text for share message
                            image: result_image_for_share, // optional image for share message (not for all networks)
                            url: window.location.href, // link on shared page
                            class_prefix: 's_', // optional class prefix for share elements (buttons or links or everything), default: 's_'
                            width: 640, // optional popup initial width
                            height: 480 // optional popup initial height
                        });
                    } else {
                        result_title = onionbuzz_lng.quiz_noresult_i_got+' '+ data.points + ' '+onionbuzz_lng.quiz_noresult_of+' ' + self.total_questions + ' '+onionbuzz_lng.quiz_noresult_right;
                        if(self.settings.type == 5){
                            result_title = onionbuzz_lng.quiz_noresult_i_checked+' '+ data.points + ' '+onionbuzz_lng.quiz_noresult_out_of+' ' + self.total_answers + ' '+onionbuzz_lng.quiz_noresult_on_this_list;
                        }
                        $('.la-social-share').ShareLink({
                            title: result_title, // title for share message
                            image: result_image_for_share, // optional image for share message (not for all networks)
                            url: window.location.href, // link on shared page
                            class_prefix: 's_', // optional class prefix for share elements (buttons or links or everything), default: 's_'
                            width: 640, // optional popup initial width
                            height: 480 // optional popup initial height
                        });
                    }
                    /*$('.lock-social-share').ShareLink({
                        url: window.location.href, // link on shared page
                        class_prefix: 's2_', // optional class prefix for share elements (buttons or links or everything), default: 's_'
                        width: 640, // optional popup initial width
                        height: 480 // optional popup initial height
                    });*/

                }
                else {

                }
            });
        }
        this._lock_share_clicked = function (network){
            var data = {
                'action': 'ob_lock_share_clicked',
                'id': self.settings.quiz_id,
                'quiz_type': self.settings.type
            };

            if(network != "no") {
                var shareLinkTemplates = {
                    twitter: 'https://twitter.com/intent/tweet?url={url}',
                    facebook: 'https://www.facebook.com/sharer.php?s=100&u={url}',
                    plus: 'https://plus.google.com/share?url={url}'
                }
                var urlShare = shareLinkTemplates[network];
                urlShare = urlShare.replace(/{url}/g, encodeURIComponent(window.location.href));

                var screen_width = screen.width;
                var screen_height = screen.height;
                var popup_width = 640 ? 640 : (screen_width - (screen_width * 0.2));
                var popup_height = 480 ? 480 : (screen_height - (screen_height * 0.2));
                var left = (screen_width / 2) - (popup_width / 2);
                var top = (screen_height / 2) - (popup_height / 2);
                var parameters = 'toolbar=0,status=0,width=' + popup_width + ',height=' + popup_height + ',top=' + top + ',left=' + left;
                var winUnlockByShare = window.open(urlShare, 'shareToUnlockWindow', parameters);

                var pollTimer = window.setInterval(function () {
                    if (winUnlockByShare.closed !== false) { // !== is required for compatibility with Opera
                        window.clearInterval(pollTimer);
                        //someFunctionToCallWhenPopUpCloses();
                        $('.la-quiz-result').show();
                        self._scrollToResult();
                        $('.la-quiz-sharelock').hide();
                    }
                }, 200);
            }
            var type = 'lock_share_clicked';
            jQuery.post(onionbuzz_params.ajax_url + '?type=' + type, data, function (response) {
                response = jQuery.parseJSON(response);

                if (response.success == 1) {

                }
            });
        }
        this._saveEmail = function(){
            var data = {
                'action': 'ob_save_email',
                //'name': $('input[name="la-ask-name"]').val(),
                'email': $('input[name="la-ask-email"]').val()
            };
            //console.log(data);

            if(self.validateEmail(data.email)){
                var type = 'save_email';
                jQuery.post(onionbuzz_params.ajax_url + '?type=' + type, data, function (response) {
                    response = jQuery.parseJSON(response);

                    //console.log(response);

                    if (response.success == 1) {
                        $('.la-quiz-result').show();
                        //$('.la-quiz-email-form').hide();
                        $('.la-quiz-email-form').find('.la-quiz-form-warn').html(onionbuzz_lng.email_form_thank_you);
                        self._scrollToResult();
                        self._lock_share_clicked("no");
                    }
                    else {
                        return false;
                    }
                });
            }
            else{
                alert(onionbuzz_lng.email_form_valid_email);
                return false;
            }

        }
        this.validateEmail = function($email) {
            var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,6})?$/;
            return ( $email.length > 0 && emailReg.test($email));
        }
    }


    var quizOptions = {
        'quiz_id': $('.shortcode-quiz').data("quiz-id"),
        'type': $('.shortcode-quiz').data("quiz-type"),
        'layout': $('.shortcode-quiz').data("quiz-layout"),
        'lock_results' : $('.shortcode-quiz').data("quiz-lock-results"),
        'optin_form': $('.shortcode-quiz').data("quiz-optin-form"),
        'autoscroll' : $('.shortcode-quiz').data("quiz-autoscroll"),
        'answer_status' : $('.shortcode-quiz').data("quiz-answer-status"),
        'slider' : $('.shortcode-quiz').data("quiz-slider"),
        'lock_button_facebook': $('.shortcode-quiz').data("lock-button-facebook"),
        'lock_button_twitter': $('.shortcode-quiz').data("lock-button-twitter"),
        'lock_button_google': $('.shortcode-quiz').data("lock-button-google"),
    };
    //console.log(quizOptions);
    var quiz = new Quiz(quizOptions);
    quiz.init();

    $.fn.extend({
        animateCss: function (animationName) {
            var animationEnd = 'webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend';
            this.addClass('animated ' + animationName).one(animationEnd, function() {
                $(this).removeClass('animated ' + animationName);
            });
        }
    });

})(jQuery);
