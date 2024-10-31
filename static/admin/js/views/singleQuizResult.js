var app = app || {};

(function($) {
    'use sctrict';
    app.singleQuizResultView = Backbone.View.extend({

        tagName: 'div',
        className: 'laqm-item quiz-result',

        template: _.template( $('#quizResultItem').html() ),

        render: function(){
            var quizResultTemplate = this.template(this.model.toJSON());
            this.$el.html(quizResultTemplate);
            return this;
        },
        events:{
            'click .trigger-edit': 'editQuizResult',
            'click .trigger-delete': 'deleteQuizResult'
        },
        editQuizResult: function(){
            var editQuizResultId = this.$el.find('.trigger-edit').data('id');
            var editQuizResultQuizId = this.$el.find('.trigger-edit').data('quiz_id');
            window.location.href = '?page=la_onionbuzz_dashboard&tab=quiz_result_edit&quiz_id='+editQuizResultQuizId+'&result_id='+editQuizResultId;
        },
        deleteQuizResult: function() {

            var deleteQuizResultId = this.$el.find('.trigger-delete').data('id');
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
                                'action': 'ob_quiz_result',
                                'id': deleteQuizResultId
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