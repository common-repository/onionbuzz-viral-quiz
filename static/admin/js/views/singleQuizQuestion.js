var app = app || {};

(function($) {
    'use sctrict';
    app.singleQuizQuestionView = Backbone.View.extend({

        tagName: 'div',
        className: 'laqm-item',

        template: _.template( $('#quizQuestionItem').html() ),

        render: function(){
            var quizQuestionTemplate = this.template(this.model.toJSON());
            this.$el.html(quizQuestionTemplate);
            return this;
        },
        events:{
            'click .trigger-edit': 'editQuizQuestion',
            'click .trigger-delete': 'deleteQuizQuestion'
        },
        editQuizQuestion: function(){
            var editQuizQuestionId = this.$el.find('.trigger-edit').data('id');
            var editQuizQuestionQuizId = this.$el.find('.trigger-edit').data('quiz_id');
            var editInline = this.$el.find('.trigger-edit').data('editinline');

            if(editInline == 0){
                window.location.href = '?page=la_onionbuzz_dashboard&tab=quiz_question_edit&quiz_id='+editQuizQuestionQuizId+'&question_id='+editQuizQuestionId;
            }
            else{
                /*$root_item = this.$el.parents().find('.laqm-item').data("123",123);
                $(".laqm-item").removeClass("with-form");
                $root_item.addClass("with-form");
                $(".container-add-form").hide();
                this.$el.parents().find(".laqm-item-info[data-id='"+editQuizQuestionId+"']").find(".container-add-form").show();*/
                console.log('edit inline');
                window.location.href = '?page=la_onionbuzz_dashboard&tab=quiz_question_edit&quiz_id='+editQuizQuestionQuizId+'&question_id='+editQuizQuestionId;
            }
        },
        deleteQuizQuestion: function() {

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
                                'action': 'ob_quiz_question',
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