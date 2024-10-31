var app = app || {};

(function($) {
    'use sctrict';
    app.singleQuizStatsPlayer = Backbone.Model.extend({
        defaults: {
            id: 0,
            user_id: 0,
            user_name: 'Unknown user',
            user_email: '—',
            score: 0,
            date_added: '0000-00-00 00:00:00'
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