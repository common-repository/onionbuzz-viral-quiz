var app = app || {};

(function($) {
    'use sctrict';
    app.singleQuizQuestion = Backbone.Model.extend({
        defaults: {
            id: 0,
            quiz_id: 0,
            quiz_type: 1,
            answers_type: 'list',
            question_id: 0,
            title: 'Title',
            description: 'Description of the quiz',
            featured_image: 'images/ad.jpg',
            image_caption: '',
            flag_explanation: 0,
            flag_pagebreak: 0,
            flag_publish: 0,
            answers_count: 0,
            correct_count: 0
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