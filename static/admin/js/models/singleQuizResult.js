var app = app || {};

(function($) {
    'use sctrict';
    app.singleQuizResult = Backbone.Model.extend({
        defaults: {
            id: 0,
            indx: 0,
            title: 'Title',
            description: 'Description of the quiz',
            quiz_type: 0,
            conditions: '',
            condition_less: '',
            featured_image: 'images/ad.jpg',
            image_caption: '',
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