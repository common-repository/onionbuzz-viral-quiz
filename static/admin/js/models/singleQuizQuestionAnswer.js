var app = app || {};

(function($) {
    'use sctrict';
    app.singleQuizQuestionAnswer = Backbone.Model.extend({
        defaults: {
            id: 0,
            quiz_id: 0,
            question_id: 0,
            title: 'Title',
            description: 'Description of the quiz',
            featured_image: 'images/ad.jpg',
            flag_correct: 0,
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