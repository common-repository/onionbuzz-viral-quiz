var app = app || {};

(function($) {
    'use sctrict';
    app.allFeedQuizzesView = Backbone.View.extend({

        tagName: 'form',
        className: 'form-horizontal laqm-items-list',

        render: function(){
            this.collection.each(this.addFeedQuiz, this);
            return this;
        },

        addFeedQuiz: function(feed_quiz){
            var feedQuizView = new app.singleFeedQuizView({model: feed_quiz });
            this.$el.append(feedQuizView.render().el)
        }

    });
})(jQuery);