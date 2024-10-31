var app = app || {};

(function($) {
    'use sctrict';
    app.allQuizQuestionsView = Backbone.View.extend({

        tagName: 'div',
        className: 'laqm-items-list',

        render: function(){
            this.collection.each(this.addQuizQuestion, this);
            return this;
        },

        addQuizQuestion: function(quizQuestion){
            var quizQuestionView = new app.singleQuizQuestionView({model: quizQuestion });
            this.$el.append(quizQuestionView.render().el)
        }

    });
})(jQuery);