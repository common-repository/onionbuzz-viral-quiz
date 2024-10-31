var app = app || {};

(function ($) {
    'use strict';
    app.Router = Backbone.Router.extend({
        routes: {
            '': 'index',
            'settings/:type/save': 'settings_save',
            'saved': 'saved',
            '*default2': 'default2'
        },

        index: function(){
            console.log("Settings index route has been called..");
        },

        settings_save: function(type){

            if(type == 'all'){
                var data = {
                    'action': 'ob_settings',
                    'ui_elements_color': $("input[name='ui_elements_color']").val(),
                    'label_color': $("input[name='label_color']").val(),
                    'progress_bar_color': $("input[name='progress_bar_color']").val(),
                    'custom_css': $("[name='custom_css']").val(),

                    'facebook_app_id': $("input[name='facebook_app_id']").val(),
                    'share_results_buttons': ($("input[name='share_results_buttons']").is(":checked"))?1:0,

                    'mailchimp_api_key': $("input[name='mailchimp_api_key']").val(),
                    'mailchimp_list_id': $("select[name='mailchimp_list_id'] option:selected").val(),
                    'display_optin_form': ($("input[name='display_optin_form']").is(":checked"))?1:0,
                    'lock_results_form': ($("input[name='lock_results_form']").is(":checked"))?1:0,
                    'form_heading': $("input[name='form_heading']").val(),
                    'form_subtitle': $("input[name='form_subtitle']").val(),
                    'submit_button_text': $("input[name='submit_button_text']").val(),
                    'optin_warning': $("input[name='optin_warning']").val(),

                    'settings_resultlock': $("select[name='settings_resultlock'] option:selected").val(),
                    'sharing_heading': $("input[name='sharing_heading']").val(),
                    'lock_button_facebook': ($("input[name='lock_button_facebook']").is(":checked"))?1:0,
                    'lock_button_twitter': ($("input[name='lock_button_twitter']").is(":checked"))?1:0,
                    'lock_button_google': ($("input[name='lock_button_google']").is(":checked"))?1:0,
                    'lock_ignore_quizids': $("input[name='lock_ignore_quizids']").val(),
                    'obla_post_type_slug': $("input[name='obla_post_type_slug']").val(),
                    'obla_post_type_text': $("input[name='obla_post_type_text']").val()
                };
            }
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
            else if(type == 'social'){
                var data = {
                    'action': 'ob_settings',
                    'facebook_app_id': $("input[name='facebook_app_id']").val(),
                    'share_quiz_buttons': ($("input[name='share_quiz_buttons']").is(":checked"))?1:0,
                    'share_results_buttons': ($("input[name='share_results_buttons']").is(":checked"))?1:0,
                    'share_button_facebook': ($("input[name='share_button_facebook']").is(":checked"))?1:0,
                    'share_button_twitter': ($("input[name='share_button_twitter']").is(":checked"))?1:0,
                    'share_button_google': ($("input[name='share_button_google']").is(":checked"))?1:0
                };
            }
            else if(type == 'optin'){
                var data = {
                    'action': 'ob_settings',
                    'mailchimp_api_key': $("input[name='mailchimp_api_key']").val(),
                    'mailchimp_list_id': $("select[name='mailchimp_list_id'] option:selected").val(),
                    'display_optin_form': ($("input[name='display_optin_form']").is(":checked"))?1:0,
                    'lock_results_form': ($("input[name='lock_results_form']").is(":checked"))?1:0,
                    'form_heading': $("input[name='form_heading']").val(),
                    'form_subtitle': $("input[name='form_subtitle']").val(),
                    'submit_button_text': $("input[name='submit_button_text']").val(),
                    'optin_warning': $("input[name='optin_warning']").val()
                };
            }
            $('#onionbuzz_loader').addClass("is-active");
            jQuery.post(ajaxurl+'?type='+type, data, function(response) {
                if(response == 1){
                    $('#onionbuzz_loader').removeClass("is-active");
                    appRouter.navigate("saved",{trigger: true});
                    $('.form-ays').trigger('reinitialize.areYouSure');
                    window.location.href = '?page=la_onionbuzz_settings';
                }
            });

            $('.form-ays').trigger('reinitialize.areYouSure');

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

        }

    });

    var appRouter = new app.Router();

    Backbone.history.start();

})(jQuery);