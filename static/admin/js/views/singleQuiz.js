var app = app || {};

(function($) {
    'use sctrict';
    app.singleQuizView = Backbone.View.extend({

        tagName: 'div',
        className: 'laqm-item',

        template: _.template( $('#quizItem').html() ),

        render: function(){
            var quizTemplate = this.template(this.model.toJSON());
            this.$el.html(quizTemplate);
            return this;
        },
        events:{
            'click .trigger-feeds': 'feedsQuiz',
            'click .trigger-shortcode': 'shortcodeQuiz',
            'click .trigger-clone': 'cloneQuiz',
            'click .trigger-edit': 'editQuiz',
            'click .trigger-delete': 'deleteQuiz'
        },
        feedsQuiz: function(){
            var editQuizId = this.$el.find('.trigger-feeds').data('id');
            console.log("show feeds of quiz "+editQuizId);
        },
        cloneQuiz: function(){
            var editQuizId = this.$el.find('.trigger-clone').data('id');
            var thismodel = this.model;
            var thisview = this;

            $.confirm({
                escapeKey: true,
                backgroundDismiss: true,
                animation: 'right',
                closeAnimation: 'scale',
                title: 'Please, confirm',
                content: 'Do You want to clone this?',
                type: 'blue',
                buttons: {
                    ok: {
                        text: "Clone",
                        btnClass: 'btn-blue',
                        keys: ['enter'],
                        action: function(){

                            var id = editQuizId;
                            var type = 'clone';
                            var data = {
                                'action': 'ob_quiz',
                                'id': id
                            };
                            console.log('try clone:'+id);
                            jQuery.post(ajaxurl+'?type='+type, data, function(response) {
                                response = jQuery.parseJSON(response);
                                if(response.success == 1){
                                    //thismodel.destroy(); it make ajax http://wordpress/wp-admin/admin-ajax.php/14 with DELETE request
                                    //thisview.remove();//Delete view
                                    console.log('cloned:'+id);
                                    Backbone.history.stop();
                                    Backbone.history.start();
                                }
                                else{
                                    //appRouter.navigate("notdeleted",{trigger: true});
                                }
                            });
                        }
                    },
                    cancel: function(){
                        //console.log('the user clicked cancel');
                    }
                }
            });
        },
        editQuiz: function(){
            var editQuizId = this.$el.find('.trigger-edit').data('id');
            window.location.href = '?page=la_onionbuzz_dashboard&tab=quiz_edit&quiz_id='+editQuizId;
        },
        shortcodeQuiz: function(){
            var shortcodeQuizId = this.$el.find('.trigger-shortcode').data('id');
            $.alert({
                escapeKey: true,
                backgroundDismiss: true,
                animation: 'right',
                closeAnimation: 'scale',
                title: 'Copy this shortcode:',
                content: '<input type="text" class="form-control" value="[onionbuzz quizid='+shortcodeQuizId+'][/onionbuzz]">',
                type: 'blue',
                buttons: {
                    ok: {
                        text: "Got it",
                        btnClass: 'btn-blue'
                    }
                }
            });

        },
        deleteQuiz: function() {

            var deleteQuizId = this.$el.find('.trigger-delete').data('id');
            var thismodel = this.model;
            var thisview = this;

            $.confirm({
                escapeKey: true,
                backgroundDismiss: true,
                animation: 'right',
                closeAnimation: 'scale',
                title: 'Please, confirm',
                content: 'Do You want to delete this?',
                type: 'red',
                buttons: {
                    ok: {
                        text: "Delete",
                        btnClass: 'btn-danger',
                        keys: ['enter'],
                        action: function(){


                            var type = 'delete';
                            var data = {
                                'action': 'ob_quiz',
                                'id': deleteQuizId
                            };
                            jQuery.post(ajaxurl+'?type='+type, data, function(response) {
                                response = jQuery.parseJSON(response);
                                if(response.success == 1){
                                    //thismodel.destroy(); it make ajax http://wordpress/wp-admin/admin-ajax.php/14 with DELETE request
                                    thisview.remove();//Delete view
                                }
                                else{
                                    appRouter.navigate("notdeleted",{trigger: true});
                                }
                            });
                        }
                    },
                    cancel: function(){
                        //console.log('the user clicked cancel');
                    }
                }
            });

        }

    });
})(jQuery);