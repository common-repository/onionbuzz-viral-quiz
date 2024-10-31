var app = app || {};

(function($) {
    'use sctrict';
    app.QuizStatsPlayersCollection = Backbone.Collection.extend({

        model: app.singleQuizStatsPlayer,
        url: ajaxurl,
        page: 1,
        total_items: 0,
        total_pages: 0,

        parse: function(response) {
            //console.log(response);
            this.page=response.page;
            this.total_items=response.total_items;
            this.total_pages=response.total_pages;
            return response.items;
        }

    });
})(jQuery);