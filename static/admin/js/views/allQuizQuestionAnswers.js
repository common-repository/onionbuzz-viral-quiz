var app = app || {};

(function($) {
    'use sctrict';
    app.allQuizQuestionAnswersView = Backbone.View.extend({

        tagName: 'div',
        className: 'laqm-items-list',

        render: function(){
            this.collection.each(this.addQuizQuestionAnswer, this);
            return this;
        },

        addQuizQuestionAnswer: function(quizQuestionAnswer){
            var quizQuestionAnswerView = new app.singleQuizQuestionAnswerView({model: quizQuestionAnswer });
            this.$el.append(quizQuestionAnswerView.render().el)
        }

    });
})(jQuery);