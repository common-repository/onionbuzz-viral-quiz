var app = app || {};

(function($) {
    'use sctrict';
    app.allQuizStatsPlayersView = Backbone.View.extend({

        tagName: 'div',
        className: 'laqm-items-list',

        render: function(){
            this.collection.each(this.addQuizStatsPlayer, this);
            return this;
        },

        addQuizStatsPlayer: function(quizStatsPlayer){
            var quizStatsPlayerView = new app.singleQuizStatsPlayerView({model: quizStatsPlayer });
            this.$el.append(quizStatsPlayerView.render().el)
        }

    });
})(jQuery);