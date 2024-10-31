var app = app || {};

(function($) {
    'use sctrict';
    app.singleQuizStatsPlayerView = Backbone.View.extend({

        tagName: 'div',
        className: 'laqm-item quiz-stat-players',

        template: _.template( $('#quizStatsPlayerItem').html() ),

        render: function(){
            var quizStatsPlayerTemplate = this.template(this.model.toJSON());
            this.$el.html(quizStatsPlayerTemplate);
            return this;
        },
        events:{
            //'click .trigger-feeds': 'feedsQuiz',
            //'click .trigger-shortcode': 'shortcodeQuiz',
            //'click .trigger-clone': 'cloneQuiz',
            //'click .trigger-edit': 'editQuiz',
            //'click .trigger-delete': 'deleteQuiz'
        }
    });
})(jQuery);