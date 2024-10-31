var app = app || {};

(function($) {
    'use sctrict';
    app.singleQuiz = Backbone.Model.extend({
        defaults: {
            id: 0,
            post_id: 0,
            type: 0,
            user_id: 0,
            user_name: 'Unknown user',
            title: 'Title',
            slug: '',
            description: 'Description of the quiz',
            featured_image: 'images/ad.jpg',
            image_caption: '',
            feeds_count: 0,
            questions_count: 0,
            results_count: 0,
            views_count: 0,
            players_count: 0,
            preview_link: '',
            date_updated: '0000-00-00 00:00:00',
            date_added: '0000-00-00 00:00:00',
            flag_published: 0
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