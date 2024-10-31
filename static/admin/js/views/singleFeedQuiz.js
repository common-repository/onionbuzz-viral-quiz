var app = app || {};

(function($) {
    'use sctrict';
    app.singleFeedQuizView = Backbone.View.extend({

        tagName: 'div',
        className: 'form-group',

        template: _.template( $('#feedQuizItem').html() ),

        render: function(){
            var feedTemplate = this.template(this.model.toJSON());
            this.$el.html(feedTemplate);
            return this;
        },
        events:{
            'click .trigger-select': 'select'
        },
        select: function(id){
            console.log('quiz selected '+id);
        }


    });
})(jQuery);