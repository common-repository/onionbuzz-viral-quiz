(function ($) {
    'use strict';
    $(document).ready(function () {
        var app = app || {};

        app.Router = Backbone.Router.extend({
            routes: {
                '': 'index',
                'show/:id': 'show',
                'quizz/:id/edit': 'edit',
                'quizz/:id/embed' : 'quizzembed',
                'feed/:id/embed' : 'feedembed',
                'feed/:id/edit' : 'edit',
                'feeds:query' : 'feeds_select',
                'download/*random': 'download',
                'search/:query': 'search',
                'settings/:type/save': 'settings_save',
                'saved': 'saved',
                '*default2': 'default2'

            },

            index: function(){
                console.log("Index route has been called..");
            },

            settings_save: function(type){

                if(type == 'general'){
                    var data = {
                        'action': 'ob_settings',
                        'quizzes_per_page': $("input[name='quizzes_per_page']").val(),
                        'display_feed_filters': ($("input[name='display_feed_filters']").is(":checked"))?1:0,
                        'post_date': ($("input[name='post_date']").is(":checked"))?1:0,
                        'post_author': ($("input[name='post_author']").is(":checked"))?1:0,
                        'post_feed': ($("input[name='post_feed']").is(":checked"))?1:0,
                        'post_players_number': ($("input[name='post_players_number']").is(":checked"))?1:0,
                        'post_views': ($("input[name='post_views']").is(":checked"))?1:0
                    };
                }
                else if(type == 'appearance'){
                    var data = {
                        'action': 'ob_settings',
                        'ui_elements_color': $("input[name='ui_elements_color']").val(),
                        'label_color': $("input[name='label_color']").val(),
                        'progress_bar_color': $("input[name='progress_bar_color']").val(),
                        'custom_css': $("[name='custom_css']").val()
                    };
                }
                jQuery.post(ajaxurl+'?type='+type, data, function(response) {
                    if(response == 1){
                        appRouter.navigate("saved",{trigger: true});
                    }
                });

                $('.form-ays').trigger('reinitialize.areYouSure');

            },

            edit: function(id){
                console.log("Show route has been called.. with id equals : " +  id);
                var data = {
                    'action': 'my_action',
                    'whatever': 1234
                };

                // note: ajaxurl = admin-ajax.php
                jQuery.post(ajaxurl+'?test=1', data, function(response) {
                    console.log(response);
                });
            },

            download: function(random){
                console.log("download route has been called.. with random equals : " +  random);
            },

            search: function(query){
                console.log("Search route has been called.. with query equals : " +  query);
            },
            quizzembed: function(id){
                new PNotify({
                    title: 'Copy this shortcode:',
                    text: '<input type="text" class="form-control" value="[onionbuzz quizz-id='+id+']">',
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
            feedembed: function(id){
                new PNotify({
                    title: 'Copy this shortcode:',
                    text: '<input type="text" class="form-control" value="[onionbuzz feed-id='+id+']">',
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
            default2: function(default2){
                console.log("Try run route: " +  default2);
                /*new PNotify({
                 title: 'Error',
                 text: "you tried to access: " +  default2,
                 type: 'error',
                 delay: 2000,
                 icon: false,
                 after_init: function(notice) {
                 notice.attention('shake');
                 }
                 });*/
            }

        });

        var appRouter = new app.Router();

        Backbone.history.start();
        /*var AppRouter = Backbone.Router.extend({
            routes: {
                '*id': 'default',
                '*Error': 'error'
            },
            default: function (id) {

            },
            error: function () {

            }
        });

        app.Router = new AppRouter();
        Backbone.history.start();*/
    });
})(jQuery);