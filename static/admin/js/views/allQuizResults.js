var app = app || {};

(function($) {
    'use sctrict';
    app.allQuizResultsView = Backbone.View.extend({

        tagName: 'div',
        className: 'laqm-items-list',

        render: function(){
            this.collection.each(this.addQuizResult, this);
            return this;
        },

        addQuizResult: function(quizResult){
            var quizResultView = new app.singleQuizResultView({model: quizResult });
            this.$el.append(quizResultView.render().el)
        }

    });
})(jQuery);