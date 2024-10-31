var app = app || {};

(function($) {
    'use sctrict';
    app.singleQuizQuestionAnswerView = Backbone.View.extend({

        tagName: 'div',
        className: 'laqm-item ',

        template: _.template( $('#quizQuestionAnswerItem').html() ),

        render: function(){
            var quizQuestionAnswerTemplate = this.template(this.model.toJSON());
            this.$el.html(quizQuestionAnswerTemplate);
            return this;
        },
        events:{
            'click .trigger-edit': 'editQuizQuestionAnswer',
            'click .trigger-delete': 'deleteQuizQuestionAnswer'
        },
        editQuizQuestionAnswer: function(){
            var editQuizQuestionAnswerId = this.$el.find('.trigger-edit').data('id');
            var editQuizQuestionAnswerQuizId = this.$el.find('.trigger-edit').data('quiz_id');
            var editQuizQuestionAnswerQuestionId = this.$el.find('.trigger-edit').data('question_id');
            window.location.href = '?page=la_onionbuzz_dashboard&tab=quiz_question_answer_edit&quiz_id='+editQuizQuestionAnswerQuizId+'&question_id='+editQuizQuestionAnswerQuestionId+'&answer_id='+editQuizQuestionAnswerId;
        },
        deleteQuizQuestionAnswer: function() {

            var deleteQuizQuestionId = this.$el.find('.trigger-delete').data('id');
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
                                'action': 'ob_quiz_question_answer',
                                'id': deleteQuizQuestionId
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