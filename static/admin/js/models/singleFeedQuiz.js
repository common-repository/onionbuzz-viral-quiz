var app = app || {};

(function($) {
    'use sctrict';
    app.singleFeedQuiz = Backbone.Model.extend({
        defaults: {
            id: 0,
            feed_id: 0,
            title: 'Title'
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
            //return this.get('title') + 'is showing.';
        }
    });
})(jQuery);