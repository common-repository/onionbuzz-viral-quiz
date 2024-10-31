var app = app || {};

(function($) {
    'use sctrict';
    app.Router = Backbone.Router.extend({
        routes: {
            '': 'index',
            'feed/:id/embed' : 'embedFeed',
            'feed/:id/save' : 'save',
            'feeds(/:query)(/:page)(/:ob/:ot)' : 'feeds',
            'quizzes/:feed_id(/:query)(/:page)(/:ob/:ot)' : 'quizzes',
            'saved': 'saved',
            'notsaved': 'notsaved',
            '*default2': 'default2'
        },
        options:{
            'page': 'la_onionbuzz_feeds',
            'tab': '',
            'feed_id': 0
        },
        hashed:{
            'items': 'feeds',
            'feed_id': 'feed_id',
            'query': 'all',
            'current_page': 1,
            'orderby': 'date_added',
            'ordertype' : 'desc'
        },
        initialize: function() {

            //this.bind( "all", this.change )
            this.options.page = this.getParameterByName('page');
            this.options.tab = this.getParameterByName('tab');
            this.options.feed_id = this.getParameterByName('feed_id');

        },
        renavigateHashed: function(type){
                appRouter.navigate('/' + this.hashed.items + '/' + this.hashed.query + '/' + this.hashed.current_page + '/' + this.hashed.orderby + '/' + this.hashed.ordertype, {trigger: true});

        },
        index: function(){

            //console.log(this.options.page);

            if(this.options.page == 'la_onionbuzz_feeds' && !this.options.tab){
                //appRouter.navigate('/feeds', { trigger: true });
                appRouter.renavigateHashed();
            }
            if(this.options.page == 'la_onionbuzz_feeds' && this.options.tab == 'feed_quizzes'){
                appRouter.navigate('/quizzes/'+this.options.feed_id, { trigger: true });
            }

        },
        feeds: function(query, page, ob, ot){

            var feedGroup = new app.FeedsCollection([]);
            $('#laqm-feeds-list').html("<div class='uil-rolling-css' style='transform:scale(0.2);'><div><div></div><div></div></div></div>");
            feedGroup.fetch({
                data: {
                    action: 'ob_feeds',
                    section: 'feeds',
                    do: 'loadlist',
                    query: query,
                    page: page,
                    orderby: ob,
                    ordertype: ot
                },
                success: function(collection, object, jqXHR) {
                    //console.log(feedGroup.page);
                    //console.log(feedGroup.total_items);

                    var feedGroupView = new app.allFeedsView({collection: feedGroup});
                    $('#laqm-feeds-list').html(feedGroupView.render().el);

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
                            console.log(type + ':' + num);
                        }
                    };
                    if(collection.total_pages > 0) {
                        $.jqPaginator('.laqm-pagination', pgOptions);
                    }

                },
                error: function(jqXHR, statusText, error) {
                    $('#laqm-feeds-list').html(error);
                }
            });

        },
        quizzes: function(feed_id, query, page, ob, ot){
            console.log('show quizzes of feed:'+feed_id);
            this.hashed.feed_id = feed_id;
            var feedQuizzesGroup = new app.FeedQuizzesCollection();
            $('#laqm-feed-quizzes-list').html("<div class='uil-rolling-css' style='transform:scale(0.2);'><div><div></div><div></div></div></div>");
            feedQuizzesGroup.fetch({
                data: {
                    action: 'ob_feed_quizzes',
                    section: 'feed_quizzes',
                    do: 'loadlist',
                    query: query,
                    page: page,
                    orderby: ob,
                    ordertype: ot
                },
                success: function(collection, object, jqXHR) {
                    //console.log(feedQuizzesGroup.page);
                    //console.log(feedQuizzesGroup.total_items);
                    //console.log(1);
                    var feedQuizzesView = new app.allFeedQuizzesView({collection: feedQuizzesGroup});
                    $('#laqm-feed-quizzes-list').html(feedQuizzesView.render().el);
                    //appRouter.renavigateHashed('feed_quizzes');

                },
                error: function(jqXHR, statusText, error) {
                    $('#laqm-feed-quizzes-list').html(error);
                }
            });
        },

        save: function(id){
            //console.log(this.options.tab);
            if(this.options.tab == 'feed_edit') {

                if(!$("input[name='feed_title']").val().trim()){
                    new PNotify({
                        title: 'Error',
                        text: 'Enter Title',
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
                    'action': 'ob_feed',
                    'id': id,
                    'title': $("input[name='feed_title']").val(),
                    'description': $("textarea[name='feed_description']").val(),
                    //'featured_image': $("input[name='featured_image']").val(),
                    //'attachment_id': $("input[name='attachment_id']").val(),
                    'slug': $("[name='feed_slug']").val(),
                    'flag_published': ($("input[name='feed_published']").is(":checked"))?1:0,
                    'flag_main': this.getParameterByName('main')
                };
                jQuery.post(ajaxurl + '?type=' + type, data, function (response) {
                    response = jQuery.parseJSON(response);
                    //console.log(response.action);
                    if (response.success == 1) {

                        $('#onionbuzz_loader').removeClass("is-active");

                        $('.laqm-item-name span').html(data.title);

                        appRouter.navigate("saved", {trigger: true});
                        $('.form-ays').trigger('reinitialize.areYouSure');
                        if (response.id > 0) {
                            if(id == 0) {
                                window.location.href = '?page=la_onionbuzz_feeds&tab=feed_edit&feed_id=' + response.id + '';
                            }
                        }
                    }
                    else {
                        $('#onionbuzz_loader').removeClass("is-active");
                        appRouter.navigate("notsaved", {trigger: true});
                    }
                });
            }
            if(this.options.tab == 'feed_quizzes'){
                console.log('save selected feed`s quizzes');
            }

        },
        embedFeed: function(id){
            var embedFeedId = id;
            new PNotify({
                title: 'Copy this shortcode:',
                text: '<input type="text" class="form-control" value="[onionbuzz feed-id='+embedFeedId+']">',
                icon: 'glyphicon glyphicon-info-sign',
                type: 'info',
                hide: false,
                confirm: {
                    confirm: true,
                    buttons: [{
                        text: 'Ok',
                        addClass: 'btn-primary',
                        click: function(notice) {
                            notice.remove();
                            appRouter.navigate("",{trigger: true});
                        }
                    },
                        null]
                },
                buttons: {
                    closer: false,
                    sticker: false
                },
                history: {
                    history: false
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
            console.log("Feed route: " +  default2);

        }

    });

    var appRouter = new app.Router();

    Backbone.history.start();

    $('#feeds_search').bind("enterKey",function(e){
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
    $('#feeds_search').keyup(function(e){
        if(e.keyCode == 13)
        {
            $(this).trigger("enterKey");
        }
    });
    $('#feeds_sort').change(function(){
        appRouter.hashed.orderby = $(this).val();
        appRouter.hashed.ordertype = $(this).find(':selected').data('type');
        appRouter.renavigateHashed();
    });




})(jQuery);


