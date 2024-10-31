var app = app || {};

(function($) {
    'use sctrict';
    app.singleFeed = Backbone.Model.extend({
        defaults: {
            id: 0,
            term_id: 0,
            user_id: 0,
            user_name: 'Unknown user',
            slug: 'slug',
            title: 'Title',
            description: 'Description of the feed',
            featured_image: 'images/ad.jpg',
            preview_link: '',
            submits_count: 0,
            views_count: 0,
            quizzes_count: 0,
            players_count: 0,
            date_updated: '0000-00-00 00:00:00',
            date_added: '0000-00-00 00:00:00',
            flag_published: 0,
            flag_main: 0
        },

        validate: function(attributes){
            if(attributes.title === undefined){
                return "Set title for model";
            }
        },

        initialize: function(){
            //console.log('This model has been initialized.');
            this.on('change', function(){ //this.on('change:title', function(){
                console.log('Changes in model');
            });
        },
        test: function () {
            return this.get('title') + 'is showing.';
        }
    });
})(jQuery);