var app = app || {};

(function($) {
    'use sctrict';
    app.Router = Backbone.Router.extend({
        routes: {
            '': 'index',
            'quiz/:id/shortcode' : 'shortcodeQuiz',
            'quiz/:id/save' : 'save',
            'result/:id/save' : 'save',
            'question/:id/save' : 'save',
            'answer/:id/save' : 'save',
            'settings/:id/save' : 'save',
            'quizzes(/:query)(/:page)(/:ob/:ot)(/:feed)' : 'quizzes',
            'results/:quiz_id(/:query)(/:page)(/:ob/:ot)' : 'results',
            'questions/:quiz_id(/:query)(/:page)(/:ob/:ot)' : 'questions',
            'answers/:question_id(/:query)(/:page)(/:ob/:ot)' : 'answers',
            'players/:quiz_id(/:page)(/:ob/:ot)' : 'players',
            'stats/erase': 'stats_erase',
            'saved': 'saved',
            'notsaved': 'notsaved',
            '*default2': 'default2'
        },
        options:{
            'page': 'la_onionbuzz_dashboard',
            'tab': '',
            'quiz_id': 0,
            'question_id': 0
        },
        hashed:{
            'items': 'quizzes',
            'quiz_id': 'quiz_id',
            'query': 'all',
            'current_page': 1,
            'orderby': 'date_added',
            'ordertype' : 'desc',
            'feed' : 'all'
        },
        initialize: function() {

            //this.bind( "all", this.change )
            this.options.page = this.getParameterByName('page');
            this.options.tab = this.getParameterByName('tab');
            this.options.quiz_id = this.getParameterByName('quiz_id');
            this.options.question_id = this.getParameterByName('question_id');
            this.hashed.current_page = 1;

            if($("input[name='featured_image']").val() != ''){
                $('.remove-featured-image').show();
            }
            if($("input[name='explanation_image']").val() != ''){
                $('.remove-explanation-image').show();
            }

        },
        renavigateHashed: function(type){
            if(type == 'players'){
                appRouter.navigate('/' + this.hashed.items + '/' + this.options.quiz_id + '/' + this.hashed.current_page, {trigger: true});
            }
            else{
                appRouter.navigate('/' + this.hashed.items + '/' + this.hashed.query + '/' + this.hashed.current_page + '/' + this.hashed.orderby + '/' + this.hashed.ordertype + '/' + this.hashed.feed, {trigger: true});
            }
        },
        index: function(){

            //console.log(this.options.page);

            if(this.options.page == 'la_onionbuzz_dashboard' && !this.options.tab){
                //appRouter.navigate('/feeds', { trigger: true });
                appRouter.renavigateHashed();
            }
            if(this.options.page == 'la_onionbuzz_dashboard' && this.options.tab == 'quiz_results'){
                appRouter.navigate('/results/'+this.options.quiz_id, { trigger: true });
            }
            if(this.options.page == 'la_onionbuzz_dashboard' && this.options.tab == 'quiz_questions'){
                appRouter.navigate('/questions/'+this.options.quiz_id, { trigger: true });
            }
            if(this.options.page == 'la_onionbuzz_dashboard' && this.options.tab == 'quiz_question_answers'){
                appRouter.navigate('/answers/'+this.options.question_id, { trigger: true });
            }
            if(this.options.page == 'la_onionbuzz_dashboard' && this.options.tab == 'quiz_settings'){
                //appRouter.navigate('/quiestions/'+this.options.quiz_id, { trigger: true });
            }
            if(this.options.page == 'la_onionbuzz_dashboard' && this.options.tab == 'quiz_stats_players'){
                appRouter.navigate('/players/'+this.options.quiz_id+'/1', { trigger: true });
            }
            if(this.options.page == 'la_onionbuzz_dashboard' && this.options.tab == 'quiz_stats_results'){
                appRouter.navigate('/stats_results/'+this.options.quiz_id, { trigger: true });
            }

        },
        stats_erase: function(){
            $.confirm({
                escapeKey: true,
                backgroundDismiss: true,
                animation: 'right',
                closeAnimation: 'scale',
                title: 'Please, confirm',
                content: 'This action will erase statistics of all quizzes, and not just this one. Are you sure you want to erase all data?',
                type: 'red',
                buttons: {
                    ok: {
                        text: "Yes",
                        btnClass: 'btn-danger',
                        keys: ['enter'],
                        action: function(){
                            console.log('erase stats');
                            var data = {
                                'action': 'ob_stats_erase'
                            };
                            jQuery.post(ajaxurl, data, function (response) {
                                response = jQuery.parseJSON(response);

                                if (response.success == 1) {
                                    console.log('ok');
                                    appRouter.navigate('/', { trigger: true });
                                    window.location.reload();
                                }
                            });
                        }
                    },
                    cancel: function(){
                        //console.log('the user clicked cancel');
                        appRouter.navigate('/', { trigger: true });
                    }
                }
            });
        },
        quizzes: function(query, page, ob, ot, feed){

            var quizGroup = new app.QuizzesCollection([]);
            $('#laqm-quizzes-list').html("<div class='uil-rolling-css' style='transform:scale(0.2);'><div><div></div><div></div></div></div>");
            quizGroup.fetch({
                data: {
                    action: 'ob_quizzes',
                    section: 'quizzes',
                    do: 'loadlist',
                    query: query,
                    page: page,
                    orderby: ob,
                    ordertype: ot,
                    feed: feed
                },
                success: function(collection, object, jqXHR) {
                    //console.log(collection.page); // this is in #13 /static/admin/js/collections/allQuizzes.js
                    //console.log(collection.total_items);
                    //console.log(collection.total_pages);

                    var quizGroupView = new app.allQuizzesView({collection: quizGroup});
                    $('#laqm-quizzes-list').html(quizGroupView.render().el);

                    if (quizGroup.length == 0){
                        $('#laqm-quizzes-list').html('You have not created anything yet.');
                    }

                    pgOptions = {
                        totalPages: parseInt(collection.total_pages),
                        visiblePages: 10,
                        currentPage: parseInt(collection.page),
                        activeClass: 'active',
                        first: '<a class="prev" href="javascript:void(0);">First</a>',
                        last: '<a class="prev" href="javascript:void(0);">Last</a>',
                        prev: '<a class="prev" href="javascript:void(0);">Prev</a>',
                        next: '<a class="next" href="javascript:void(0);">Next</a>',
                        page: '<a class="active" href="javascript:void(0);">{{page}}</a>',
                        onPageChange: function (num, type) {
                            appRouter.hashed.current_page = num;
                            appRouter.renavigateHashed();
                            //console.log(type + ':' + num);
                        }
                    };
                    if(collection.total_pages > 0) {
                        $('.buy-pro-version2').on('click', function () {
                            $.alert({
                                escapeKey: 'ok',
                                backgroundDismiss: 'ok',
                                animation: 'right',
                                closeAnimation: 'scale',
                                title: 'AVAILABLE IN PRO',
                                content: 'To get access to this and many other premium features please <a target="_blank" href="https://goo.gl/23mpm6">upgrade to PRO version</a>.',
                                type: 'blue',
                                buttons: {
                                    ok: {
                                        text: "Ok",
                                        btnClass: 'btn-blue',
                                        action: function(){

                                        }
                                    }
                                }
                            });
                        });
                        $.jqPaginator('.laqm-pagination', pgOptions);
                    }


                },
                error: function(jqXHR, statusText, error) {
                    $('#laqm-quizzes-list').html(error);
                }
            });

        },
        results: function(quiz_id, query, page, ob, ot){
            //console.log('show results of quiz:'+quiz_id);
            this.hashed.quiz_id = quiz_id;
            var quizResultsGroup = new app.QuizResultsCollection([]);
            $('#laqm-results-list').html("<div class='uil-rolling-css' style='transform:scale(0.2);'><div><div></div><div></div></div></div>");
            quizResultsGroup.fetch({
                data: {
                    action: 'ob_quiz_results',
                    section: 'quizzes',
                    do: 'loadlist',
                    query: query,
                    page: page,
                    orderby: ob,
                    ordertype: ot,
                    quiz_id: quiz_id
                },
                success: function(collection, object, jqXHR) {
                    var quizResultsGroupView = new app.allQuizResultsView({collection: quizResultsGroup});
                    $('#laqm-results-list').html(quizResultsGroupView.render().el);
                    if (quizResultsGroup.length == 0){
                        $('#laqm-results-list').html('This item wont be published until you add at least 1 result. <a href="?page=la_onionbuzz_dashboard&tab=quiz_result_edit&quiz_id='+quiz_id+'">Add the first result</a>');
                    }
                    else{

                        // slides functions
                        var slidersIDs = [];
                        var slidersValues = [];
                        var totalSlides = $('.flat-slider').length;
                        var initSlider = 0;
                        $( ".flat-slider" ).slider({
                            min: 0,
                            max: 100,
                            range: true,
                            start: function( event, ui ) {
                                //if ($(ui.handle).hasClass('stay'))
                                    //return false;
                            },
                            slide: function( event, ui ) {
                                var slidingIndex = $(this).data('index');
                                var slidingId = $(this).data('id');


                                var currentSliderVals = ui.values;
                                /*if (typeof slidersValues[slidingIndex-1] !== 'undefined') {
                                    slidersValues[slidingIndex-1][1] = slidersValues[slidingIndex][0];
                                }
                                if (typeof slidersValues[slidingIndex+1] !== 'undefined') {
                                    slidersValues[slidingIndex+1][0] = slidersValues[slidingIndex][1];
                                }*/
                                slidersValues[$(this).data('index')][0] = ui.values[ 0 ];
                                slidersValues[$(this).data('index')][1] = ui.values[ 1 ];
                                sliderSetValues (this,$(this).data('index'));
                                renderSlides(slidersValues);
                            },
                            create: function (event, ui){
                                $(this).attr('data-index', initSlider);
                                //console.log($(this).data('index'));
                                initValues (this);
                                sliderSetValues (this,$(this).data('index'));
                                renderSlides(slidersValues);
                            },
                            stop: function (event, ui){

                                slidersValues[$(this).data('index')][0] = ui.values[ 0 ];
                                slidersValues[$(this).data('index')][1] = ui.values[ 1 ];

                                sliderSetValues (this,$(this).data('index'));
                                renderSlides(slidersValues);
                                console.log(slidersIDs,slidersValues);
                                $('.save-conditions').show();
                                $('.save-conditions').animateCss('flash');
                                console.log(slidersValues[$(this).data('index')]);

                            }
                        }).slider("pips", {
                            first: "pip",
                            last: "pip"
                        }).each(function(index, Element){

                        });

                        $('.save-conditions').bind('click', function(){
                            var type = 'save';
                            var data = {
                                'action': 'ob_quiz_results_conditions',
                                'quiz_id': quiz_id,
                                'results_ids': slidersIDs,
                                'results_conditions': slidersValues
                            }
                            $('#onionbuzz_loader').addClass("is-active");
                            jQuery.post(ajaxurl + '?type=' + type, data, function (response) {
                                response = jQuery.parseJSON(response);

                                if (response.success == 1) {

                                    $('#onionbuzz_loader').removeClass("is-active");
                                    $('.save-conditions').hide();
                                    appRouter.navigate("saved", {trigger: true});
                                    appRouter.navigate('/results/'+quiz_id, { trigger: true });
                                    $('.save-conditions').unbind('click');
                                }
                                else {
                                    appRouter.navigate("notsaved", {trigger: true});
                                    appRouter.navigate('/results/'+quiz_id, { trigger: false });
                                    $('#onionbuzz_loader').removeClass("is-active");
                                }
                             });
                        });

                        function renderSlides(values){
                            for(var i = 0; i < totalSlides; i++){
                                //console.log(i);
                                if($( '.flat-slider[data-index="'+i+'"]' ).length != 0) {

                                    $('.flat-slider[data-index="' + i + '"]').slider("value", values[i]);
                                    $('.laqm-item-info div[data-index="'+i+'"]').find('.condition-from').html(values[i][0]);
                                    $('.laqm-item-info div[data-index="'+i+'"]').find('.condition-to').html(values[i][1]);
                                    //$('.flat-slider[data-index="' + i + '"] .ui-slider-handle:first').addClass('stay');
                                }
                            }
                        }
                        function initValues (slider){

                            $( slider ).slider( "option", "values", [ $(slider).data('from'), $(slider).data('to') ] );
                            slidersIDs[initSlider] = $( slider ).data('id');
                            slidersValues[initSlider] = $( slider ).slider( "option", "value");
                            initSlider++;
                            if((totalSlides+1) == initSlider){
                                initSlider = 1;
                            }
                            //console.log(initSlider);
                        }
                        function sliderSetValues (slider ,index){
                            slidersValues[index] = $( slider ).slider( "option", "values");

                        }


                    }

                },
                error: function(jqXHR, statusText, error) {
                    $('#laqm-results-list').html(error);
                }
            });
        },
        questions: function(quiz_id, query, page, ob, ot){
            //console.log('show questions of quiz:'+quiz_id);
            this.hashed.quiz_id = quiz_id;
            var quizQuestionsGroup = new app.QuizQuestionsCollection([]);
            $('#laqm-questions-list').html("<div class='uil-rolling-css' style='transform:scale(0.2);'><div><div></div><div></div></div></div>");

            quizQuestionsGroup.fetch({
                data: {
                    action: 'ob_quiz_questions',
                    section: 'quizzes',
                    do: 'loadlist',
                    query: query,
                    page: page,
                    orderby: ob,
                    ordertype: ot,
                    quiz_id: quiz_id
                },
                success: function(collection, object, jqXHR) {

                    /*quizQuestionsGroup.add(
                        new app.singleQuizQuestion({
                            'id' : 1,
                            'quiz_type' : 3
                        })
                    );*/

                    var quizQuestionsGroupView = new app.allQuizQuestionsView({collection: quizQuestionsGroup});
                    $('#laqm-questions-list').html(quizQuestionsGroupView.render().el);
                    if (quizQuestionsGroup.length == 0){
                        $('#laqm-questions-list').html('This story wont be published until you add at least 1 item. ');

                    }
                    else{

                    }
                },
                error: function(jqXHR, statusText, error) {
                    $('#laqm-questions-list').html(error);
                }
            });
        },
        answers: function(question_id, query, page, ob, ot){
            //console.log('show answers of question:'+question_id);
            this.hashed.question_id = question_id;
            var quiz_id = this.options.quiz_id;
            var quizQuestionAnswersGroup = new app.QuizQuestionAnswersCollection([]);
            $('#laqm-answers-list').html("<div class='uil-rolling-css' style='transform:scale(0.2);'><div><div></div><div></div></div></div>");
            quizQuestionAnswersGroup.fetch({
                data: {
                    action: 'ob_quiz_question_answers',
                    section: 'quizzes',
                    do: 'loadlist',
                    query: query,
                    page: page,
                    orderby: ob,
                    ordertype: ot,
                    quiz_id: this.hashed.quiz_id,
                    question_id: question_id
                },
                success: function(collection, object, jqXHR) {
                    var quizQuestionAnswersGroupView = new app.allQuizQuestionAnswersView({collection: quizQuestionAnswersGroup});
                    $('#laqm-answers-list').html(quizQuestionAnswersGroupView.render().el);
                    if (quizQuestionAnswersGroup.length == 0){
                        $('#laqm-answers-list').html('This item wont be published until you add at least 1 answer. <a href="?page=la_onionbuzz_dashboard&tab=quiz_question_answer_edit&quiz_id='+quiz_id+'&question_id='+question_id+'">Add the first answer</a>');
                    }
                    else{

                    }

                },
                error: function(jqXHR, statusText, error) {
                    $('#laqm-answers-list').html(error);
                }
            });
        },
        players: function(quiz_id, page, ob, ot){
            //console.log(page);
            this.hashed.items = 'players';

            var quizStatsPlayersGroup = new app.QuizStatsPlayersCollection([]);
            $('#laqm-players-list').html("<div class='uil-rolling-css' style='transform:scale(0.2);'><div><div></div><div></div></div></div>");
            quizStatsPlayersGroup.fetch({
                data: {
                    action: 'ob_quiz_stats',
                    section: 'players',
                    do: 'loadlist',
                    quiz_id: quiz_id,
                    page: page,
                    orderby: ob,
                    ordertype: ot
                },
                success: function(collection, object, jqXHR) {
                    //console.log('...');
                    //console.log(collection.page); // this is in #13 /static/admin/js/collections/allQuizzes.js
                    //console.log(collection.total_items);
                    //console.log(collection.total_pages);

                    var quizStatsPlayersGroupView = new app.allQuizStatsPlayersView({collection: quizStatsPlayersGroup});
                    $('#laqm-players-list').html(quizStatsPlayersGroupView.render().el);

                    if (quizStatsPlayersGroup.length == 0){
                        $('#laqm-players-list').html('No data yet.');
                    }

                    pgOptions = {
                        totalPages: parseInt(collection.total_pages),
                        visiblePages: 10,
                        currentPage: parseInt(collection.page),
                        activeClass: 'active',
                        first: '<a class="prev" href="javascript:void(0);">First</a>',
                        last: '<a class="prev" href="javascript:void(0);">Last</a>',
                        prev: '<a class="prev" href="javascript:void(0);">Prev</a>',
                        next: '<a class="next" href="javascript:void(0);">Next</a>',
                        page: '<a class="active" href="javascript:void(0);">{{page}}</a>',
                        onPageChange: function (num, type) {
                            appRouter.hashed.current_page = num;
                            appRouter.renavigateHashed('players');
                            //console.log(type + ':' + num);
                        }
                    };
                    if(collection.total_pages > 0) {
                        $.jqPaginator('.laqm-pagination', pgOptions);
                    }


                },
                error: function(jqXHR, statusText, error) {
                    $('#laqm-players-list').html(error);
                }
            });

        },
        get_tinymce_content: function (id) {
            var content;
            var inputid = id;
            var editor = tinyMCE.get(inputid);
            var textArea = jQuery('textarea#' + inputid);
            console.log(textArea.is(':visible'));
            if (textArea.length>0 && textArea.is(':visible')) {
                content = textArea.val();
            } else {
                content = editor.getContent();
            }
            //.log('get_tinymce_content');
            return content;
        },
        set_tinymce_content: function (id, content) {
            var inputid = id;
            var editor = tinyMCE.get(inputid);
            var textArea = jQuery('textarea#' + inputid);
            console.log(textArea.is(':visible'));
            if (textArea.length>0 && textArea.is(':visible')) {
                textArea.val(content);
            } else {
                editor.setContent(content);
            }
            //.log('get_tinymce_content');
            return content;
        },
        save: function(id){
            //console.log(this.options.tab);

            if(this.options.tab == 'quiz_edit') {

                if(!$("input[name='quiz_title']").val().trim()){
                    new PNotify({
                        title: 'Error',
                        text: 'Please, add a title',
                        icon: 'glyphicon glyphicon-info-sign',
                        type: 'error',
                        hide: true,
                        buttons: {
                            closer: true,
                            sticker: false
                        },
                        history: {
                            history: false
                        }
                    });
                    appRouter.navigate("#", {trigger: true});
                    return false;
                }

                var id = id;
                var type = 'save';
                var data = {
                    'action': 'ob_quiz',
                    'id': id,
                    'flag_published': ($("input[name='quiz_published']").is(":checked"))?1:0,
                    'flag_list_ranked': ($("input[name='flag_list_ranked']").is(":checked"))?1:0,
                    'quiz_type': $("select[name='quiz_type'] option:selected").val(),
                    'quiz_layout': $("select[name='quiz_layout'] option:selected").val(),
                    'title': $("input[name='quiz_title']").val(),
                    //'description': $("textarea[name='quiz_description']").val(),
                    'description': this.get_tinymce_content('quiz_description'),
                    'featured_image': $("input[name='featured_image']").val(),
                    'image_caption': $("[name='quiz_image_caption']").val(),
                    'attachment_id': $("[name='attachment_id']").val(),
                    'quiz_feeds': [],
                    'terms_ids': [],
                    'answer_status': ($("input[name='answer_status']").is(":checked"))?1:0,
                    'replay_button': ($("input[name='replay_button']").is(":checked"))?1:0,
                    'questions_order': $("select[name='questions_order'] option:selected").val(),
                    'answers_order': $("select[name='answers_order'] option:selected").val(),
                    'auto_scroll': ($("input[name='auto_scroll']").is(":checked"))?1:0
                };
                $('#onionbuzz_loader').addClass("is-active");

                $(".quiz_feeds:checked").each(function() {
                    data['quiz_feeds'].push($(this).val());
                    data['terms_ids'].push($(this).data('term'));
                });

                jQuery.post(ajaxurl + '?type=' + type, data, function (response) {
                    response = jQuery.parseJSON(response);

                    if (response.success == 1) {

                        $('#onionbuzz_loader').removeClass("is-active");

                        $('.laqm-item-name span').html(data.title);

                        appRouter.navigate("saved", {trigger: true});
                        $('.form-ays').trigger('reinitialize.areYouSure');
                        if (response.id > 0) {
                            if(id == 0) {
                                window.location.href = '?page=la_onionbuzz_dashboard&tab=quiz_edit&quiz_id=' + response.id + '';
                            }
                        }
                    }
                    else {
                        appRouter.navigate("notsaved", {trigger: true});
                    }
                });
            }
            if(this.options.tab == 'quiz_result_edit'){
                //console.log('save quiz result');
                //console.log(this.options.quiz_id);

                if($("input[name='result_conditions']").length){
                    var conditions = $("input[name='result_conditions']").val();
                }
                else{
                    var conditions = '';
                }

                if(!$("input[name='result_title']").val().trim()){
                    new PNotify({
                        title: 'Error',
                        text: 'Please, add a title',
                        icon: 'glyphicon glyphicon-info-sign',
                        type: 'error',
                        hide: true,
                        buttons: {
                            closer: true,
                            sticker: false
                        },
                        history: {
                            history: false
                        }
                    });
                    appRouter.navigate("#", {trigger: true});
                    return false;
                }

                $('#onionbuzz_loader').addClass("is-active");

                var id = id;
                var type = 'save';
                var data = {
                    'action': 'ob_quiz_result',
                    'id': id,
                    'quiz_id': this.options.quiz_id,
                    'flag_published': ($("input[name='result_published']").is(":checked"))?1:0,
                    'title': $("input[name='result_title']").val(),
                    //'description': $("textarea[name='result_description']").val(),
                    'description': this.get_tinymce_content('result_description'),
                    'conditions': conditions,
                    'featured_image': $("input[name='featured_image']").val(),
                    'image_caption': $("[name='result_image_caption']").val(),
                    'attachment_id': $("[name='attachment_id']").val()
                };

                jQuery.post(ajaxurl + '?type=' + type, data, function (response) {
                    response = jQuery.parseJSON(response);

                    if (response.success == 1) {

                        $('#onionbuzz_loader').removeClass("is-active");

                        $('.laqm-item-name span').html(data.title);

                        appRouter.navigate("saved", {trigger: true});
                        $('.form-ays').trigger('reinitialize.areYouSure');
                        if (response.id > 0) {
                            if(id == 0){
                                window.location.href = '?page=la_onionbuzz_dashboard&tab=quiz_result_edit&quiz_id=' + response.quiz_id + '&result_id=' + response.id;
                            }

                        }
                    }
                    else {
                        appRouter.navigate("notsaved", {trigger: true});
                    }
                });
            }
            if(this.options.tab == 'quiz_question_edit'){
                //console.log('save quiz question');
                //console.log(this.options.quiz_id);

                if(!$("input[name='question_title']").val().trim() && !$("input[name='featured_image']").val().trim() ){
                    new PNotify({
                        title: 'Error',
                        text: 'Please, add at least Title or Image',
                        icon: 'glyphicon glyphicon-info-sign',
                        type: 'error',
                        hide: true,
                        buttons: {
                            closer: true,
                            sticker: false
                        },
                        history: {
                            history: false
                        }
                    });
                    appRouter.navigate("#", {trigger: true});
                    return false;
                }

                $('#onionbuzz_loader').addClass("is-active");

                var match_answers = '';
                var match_casesensitive = 0;
                if($("select[name='answers_type'] option:selected").val() == 'match'){
                    match_answers = $("input[name='question_match_answers']").val();
                    match_casesensitive = ($("input[name='flag_casesensitive']").is(":checked"))?1:0;
                }

                var explanation = "";
                var explanation_title = "";
                if($('#wp-question_explanation-wrap').length){
                    explanation = this.get_tinymce_content('question_explanation');
                }
                if($("input[name='question_explanation_title']").length){
                    explanation_title = $("input[name='question_explanation_title']").val();
                }

                var id = id;
                var type = 'save';
                var data = {
                    'action': 'ob_quiz_question',
                    'id': id,
                    'quiz_id': this.options.quiz_id,
                    'flag_published': ($("input[name='question_published']").is(":checked"))?1:0,
                    'title': $("input[name='question_title']").val(),
                    'answers_type': $("select[name='answers_type'] option:selected").val(),
                    'mediagrid_type': $("select[name='mediagrid_type'] option:selected").val(),
                    //'description': $("textarea[name='question_description']").val(),
                    'description': this.get_tinymce_content('question_description'),
                    'featured_image': $("input[name='featured_image']").val(),
                    'image_caption': $("[name='question_image_caption']").val(),
                    'secondary_image': $("input[name='secondary_image']").val(),
                    'secondary_image_caption': $("[name='secondary_image_caption']").val(),
                    'attachment_id': $("[name='attachment_id']").val(),
                    'explanation_title': explanation_title,
                    //'explanation': $("textarea[name='question_explanation']").val(),
                    'explanation': explanation,
                    'explanation_image': $("input[name='explanation_image']").val(),
                    'flag_explanation': ($("input[name='question_flag_explanation']").is(":checked"))?1:0,
                    'question_match_answers': match_answers,
                    'flag_casesensitive': match_casesensitive,
                    'flag_pagebreak': ($("input[name='question_flag_pagebreak']").is(":checked"))?1:0
                };

                jQuery.post(ajaxurl + '?type=' + type, data, function (response) {
                    response = jQuery.parseJSON(response);

                    //console.log(response);

                    if (response.success == 1) {

                        $('#onionbuzz_loader').removeClass("is-active");

                        $('.laqm-item-name span').html(data.title);

                        appRouter.navigate("saved", {trigger: true});
                        $('.form-ays').trigger('reinitialize.areYouSure');
                        if (response.id > 0) {
                            if(id == 0) {
                                window.location.href = '?page=la_onionbuzz_dashboard&tab=quiz_question_edit&quiz_id=' + response.quiz_id + '&question_id=' + response.id;
                            }
                        }
                    }
                    else {
                        appRouter.navigate("notsaved", {trigger: true});
                        $('#onionbuzz_loader').removeClass("is-active");
                    }
                });
            }
            if(this.options.tab == 'quiz_question_answer_edit'){
                //console.log('save question answer');

                //console.log(this.options.quiz_id);

                if(!$("input[name='answer_title']").val().trim() && !$("input[name='featured_image']").val().trim() ){
                    new PNotify({
                        title: 'Error',
                        text: 'Please, add at least Short Answer (if answers type list) or Image (if answers type Media grid)',
                        icon: 'glyphicon glyphicon-info-sign',
                        type: 'error',
                        hide: true,
                        buttons: {
                            closer: true,
                            sticker: false
                        },
                        history: {
                            history: false
                        }
                    });
                    appRouter.navigate("#", {trigger: true});
                    return false;
                }

                $('#onionbuzz_loader').addClass("is-active");

                var id = id;
                var type = 'save';
                var data = {
                    'action': 'ob_quiz_question_answer',
                    'id': id,
                    'quiz_id': this.options.quiz_id,
                    'question_id': this.options.question_id,
                    'flag_published': ($("input[name='answer_published']").is(":checked"))?1:0,
                    'title': $("input[name='answer_title']").val(),
                    //'description': $("textarea[name='answer_description']").val(),
                    //'description': this.get_tinymce_content('answer_description'),
                    'description': '',
                    'featured_image': $("input[name='featured_image']").val(),
                    'image_caption': $("[name='image_caption']").val(),
                    'attachment_id': $("[name='attachment_id']").val(),
                    'flag_correct': ($("input[name='flag_correct']").is(":checked"))?1:0,
                    'result_ids': [],
                    'result_points': []
                };

                $(".flat-slider").each(function() {
                    var el = "div[data-slider-id='"+$(this).data('slider-id')+"']";
                    var result_id = $(this).data('slider-id');
                    var value = $(this).slider( "option", "value" );
                    data['result_ids'].push(result_id);
                    data['result_points'].push(value);
                });

                //console.log(data['result_points']);
                jQuery.post(ajaxurl + '?type=' + type, data, function (response) {
                    response = jQuery.parseJSON(response);

                    $('#onionbuzz_loader').removeClass("is-active");

                    if (response.success == 1) {

                        $('.laqm-item-name span').html(data.title);

                        appRouter.navigate("saved", {trigger: true});
                        $('.form-ays').trigger('reinitialize.areYouSure');
                        if (response.id > 0) {
                            if(id == 0){
                                window.location.href = '?page=la_onionbuzz_dashboard&tab=quiz_question_answer_edit&quiz_id=' + response.quiz_id + '&question_id=' + response.question_id + '&answer_id=' + response.id;
                            }

                        }
                    }
                    else {
                        appRouter.navigate("notsaved", {trigger: true});
                    }
                });
            }
            if(this.options.tab == 'quiz_settings'){
                //console.log('save quiz settings');
                //console.log(this.options.quiz_id);
                var id = id;
                var type = 'save';
                var data = {
                    'action': 'ob_quiz_settings',
                    'id': id,
                    'answer_status': ($("input[name='answer_status']").is(":checked"))?1:0,
                    'replay_button': ($("input[name='replay_button']").is(":checked"))?1:0,
                    'questions_order': $("select[name='questions_order'] option:selected").val(),
                    'answers_order': $("select[name='answers_order'] option:selected").val(),
                    'auto_scroll': ($("input[name='auto_scroll']").is(":checked"))?1:0
                };

                //console.log(data);

                jQuery.post(ajaxurl + '?type=' + type, data, function (response) {
                    response = jQuery.parseJSON(response);

                    //console.log(response);

                    if (response.success == 1) {
                        appRouter.navigate("saved", {trigger: true});
                        $('.form-ays').trigger('reinitialize.areYouSure');
                        if (response.id > 0) {
                            window.location.href = '?page=la_onionbuzz_dashboard&tab=quiz_settings&quiz_id=' + response.id;
                        }
                    }
                    else {
                        appRouter.navigate("notsaved", {trigger: true});
                    }
                });
            }
        },
        shortcodeQuiz: function(id){
            var shortcodeQuizId = id;
            $.alert({
                escapeKey: 'ok',
                backgroundDismiss: 'ok',
                animation: 'right',
                closeAnimation: 'scale',
                title: 'Copy this shortcode:',
                content: '<input type="text" class="form-control" value="[onionbuzz quizid='+shortcodeQuizId+'][/onionbuzz]">',
                type: 'blue',
                buttons: {
                    ok: {
                        text: "Got it",
                        btnClass: 'btn-blue',
                        action: function(){
                            appRouter.navigate("",{trigger: true});
                        }
                    }
                }
            });
        },
        saved: function(){
            new PNotify({
                title: 'Info',
                text: 'Changes saved.',
                icon: 'glyphicon glyphicon-info-sign',
                type: 'info',
                hide: true,
                delay: 1000,
                buttons: {
                    closer: true,
                    sticker: false
                },
                history: {
                    history: false
                }
            });
        },
        notsaved: function(){
            new PNotify({
                title: 'Error',
                text: 'Changes not saved. Try again...',
                icon: 'glyphicon glyphicon-info-sign',
                type: 'error',
                hide: true,
                delay: 1000,
                buttons: {
                    closer: true,
                    sticker: false
                },
                history: {
                    history: false
                }
            });
        },
        getParameterByName: function(name, url) {
            if (!url) {
                url = window.location.href;
            }
            name = name.replace(/[\[\]]/g, "\\$&");
            var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
                results = regex.exec(url);
            if (!results) return null;
            if (!results[2]) return '';
            return decodeURIComponent(results[2].replace(/\+/g, " "));
        },
        default2: function(default2){
            console.log("Quiz route: " +  default2);

        }

    });

    var appRouter = new app.Router();

    Backbone.history.start();

    $('#quizzes_search').bind("enterKey",function(e){
        if($(this).val() != ''){
            //appRouter.navigate("feeds/"+$(this).val(), {trigger: true});
            appRouter.hashed.current_page = 1;
            appRouter.hashed.query = $(this).val();
            appRouter.renavigateHashed();
        }
        else{
            //appRouter.navigate("feeds", {trigger: true});
            appRouter.hashed.query = 'all';
            appRouter.renavigateHashed();
        }
    });
    $('#quizzes_search').keyup(function(e){
        if(e.keyCode == 13)
        {
            $(this).trigger("enterKey");
        }
    });
    $('#quizzes_sort').change(function(){
        appRouter.hashed.orderby = $(this).val();
        appRouter.hashed.ordertype = $(this).find(':selected').data('type');
        appRouter.renavigateHashed();
    });
    $('#quizzes_feeds').change(function(){
        if($(this).val() == 'all'){
            //$(this).parent('div').removeClass('laqm-select-blue arrow-grey-down');
            //$(this).parent('div').addClass('disabled');
        }
        else{
            $(this).parent('div').addClass('laqm-select-blue arrow-grey-down');
            $(this).parent('div').removeClass('disabled');
        }
        appRouter.hashed.feed = $(this).val();
        appRouter.renavigateHashed();
    });

    $(".button-show-add-form").on("click", function () {
        $(".container-add-form[data-question-id='0']").toggle();
    });
    $(".submit-add-form").on("click", function(){
        var $container_form = $(this).closest(".container-add-form");
        var edit_question_id = $container_form.data("question-id");

        //console.log(appRouter.options.tab,edit_question_id);
        if(appRouter.options.tab == 'quiz_questions'){
            if(!$container_form.find("input[name='question_title']").val().trim() && !$container_form.find("input[name='featured_image']").val().trim() ){
                new PNotify({
                    title: 'Error',
                    text: 'Please, add at least Title or Image',
                    icon: 'glyphicon glyphicon-info-sign',
                    type: 'error',
                    hide: true,
                    buttons: {
                        closer: true,
                        sticker: false
                    },
                    history: {
                        history: false
                    }
                });
                //appRouter.navigate("#", {trigger: true});
                return false;
            }

            var id = edit_question_id;
            var type = 'save';
            var data = {
                'action': 'ob_quiz_question',
                'id': id,
                'quiz_id': appRouter.options.quiz_id,
                'flag_published': ($container_form.find("input[name='question_published']").is(":checked"))?1:0,
                'title': $container_form.find("input[name='question_title']").val(),
                //'description': $container_form.find("textarea[name='question_description']").val(),
                'description': appRouter.get_tinymce_content('question_description'),
                'featured_image': $container_form.find("input[name='featured_image']").val(),
                'image_caption': $container_form.find("[name='question_image_caption']").val(),
                'attachment_id': $container_form.find("[name='attachment_id']").val(),
                'secondary_image': $container_form.find("input[name='secondary_image']").val(),
                'secondary_image_caption': $container_form.find("[name='secondary_image_caption']").val(),
                'secondary_attachment_id': $container_form.find("[name='secondary_attachment_id']").val(),
                'mediagrid_type': 'flex2',
                'answers_type': "list",
                'explanation_title': '',
                'explanation' : '',
                'explanation_image' : '',
                'flag_explanation' : 0,
                'flag_pagebreak' : 0,
                'flag_casesensitive' : 0
            };
            //console.log(data);
            $('#onionbuzz_loader').addClass("is-active");

            jQuery.post(ajaxurl + '?type=' + type, data, function (response) {

                response = jQuery.parseJSON(response);

                //console.log(response);

                if (response.success == 1) {
                    $('#onionbuzz_loader').removeClass("is-active");
                    //$('.laqm-item-name span').html(data.title);

                    new PNotify({
                        title: 'Info',
                        text: 'Changes saved.',
                        icon: 'glyphicon glyphicon-info-sign',
                        type: 'info',
                        hide: true,
                        buttons: {
                            closer: true,
                            sticker: false
                        },
                        history: {
                            history: false
                        }
                    });

                    $container_form.find('.form-ays').trigger('reinitialize.areYouSure');
                    if (response.id > 0) {
                        //$container_form.data("question-id", response.id);
                        $container_form.find("input[name=question_title]").val("");
                        $container_form.find("input[name=question_image_caption]").val("");
                        $container_form.find("input[name=secondary_image_caption]").val("");
                        //$container_form.find("textarea").val("");
                        appRouter.set_tinymce_content('question_description', '');
                        //tinymce.get('question_description').setContent("");
                        $container_form.find(".remove-featured-image-ajaxform").trigger("click");
                        Backbone.history.stop();
                        Backbone.history.start();
                    }
                }
                else {
                    Backbone.history.stop();
                    Backbone.history.start();
                }
            });
        }

    });
    $.fn.extend({
        animateCss: function (animationName) {
            var animationEnd = 'webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend';
            this.addClass('animated ' + animationName).one(animationEnd, function() {
                $(this).removeClass('animated ' + animationName);
            });
        }
    });

})(jQuery);


