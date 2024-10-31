var app = app || {};

(function($) {
    'use sctrict';
    app.FeedQuizzesCollection = Backbone.Collection.extend({

        model: app.singleFeedQuiz,
        url: ajaxurl,
        page: 1,
        total_items: 0,

        parse: function(response) {
            this.page=response.page;
            return response.items;
        }

    });
})(jQuery);