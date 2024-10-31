var app = app || {};

(function($) {
    'use sctrict';
    app.allFeedsView = Backbone.View.extend({

        tagName: 'div',
        className: 'laqm-items-list',

        render: function(){
            this.collection.each(this.addFeed, this);
            return this;
        },

        addFeed: function(feed){
            var feedView = new app.singleFeedView({model: feed });
            this.$el.append(feedView.render().el)
        }

    });
})(jQuery);