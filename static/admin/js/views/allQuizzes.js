var app = app || {};

(function($) {
    'use sctrict';
    app.allQuizzesView = Backbone.View.extend({

        tagName: 'div',
        className: 'laqm-items-list',

        render: function(){
            this.collection.each(this.addQuiz, this);
            return this;
        },

        addQuiz: function(quiz){
            var quizView = new app.singleQuizView({model: quiz });
            this.$el.append(quizView.render().el)
        }

    });
})(jQuery);