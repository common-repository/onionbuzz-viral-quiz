var app = app || {};

(function($) {
    'use sctrict';
    app.singleFeedView = Backbone.View.extend({

        tagName: 'div',
        className: 'laqm-item',

        template: _.template( $('#feedItem').html() ),

        render: function(){
            var feedTemplate = this.template(this.model.toJSON());
            this.$el.html(feedTemplate);
            return this;
        },
        events:{
            'click .trigger-embed': 'embedFeed',
            'click .trigger-delete': 'deleteFeed',
            'click .trigger-edit': 'editFeed'
        },
        editFeed: function(){
            var editFeedId = this.$el.find('.trigger-edit').data('id');
            window.location.href = '?page=la_onionbuzz_feeds&tab=feed_edit&feed_id='+editFeedId;
        },
        embedFeed: function(){
            //console.log(this.$el.find('.trigger-embed').data('id'));
            var embedFeedId = this.$el.find('.trigger-embed').data('id');
            new PNotify({
                title: 'Copy this shortcode:',
                text: '<input type="text" class="form-control" value="[onionbuzz feed-id='+embedFeedId+']">',
                icon: 'glyphicon glyphicon-info-sign',
                type: 'info',
                hide: false,
                confirm: {
                    confirm: true,
                    buttons: [{
                        text: 'Ok',
                        addClass: 'btn-primary',
                        click: function(notice) {
                            notice.remove();
                        }
                    },
                        null]
                },
                buttons: {
                    closer: false,
                    sticker: false
                },
                history: {
                    history: false
                }
            });
        },
        deleteFeed: function() {

            var deleteFeedId = this.$el.find('.trigger-delete').data('id');
            var thismodel = this.model;
            var thisview = this;

            $.confirm({
                escapeKey: true,
                backgroundDismiss: true,
                animation: 'right',
                closeAnimation: 'scale',
                title: 'Please, confirm',
                content: 'Do You want to delete this?',
                type: 'red',
                buttons: {
                    ok: {
                        text: "Delete",
                        btnClass: 'btn-danger',
                        keys: ['enter'],
                        action: function(){
                            var type = 'delete';
                            var data = {
                                'action': 'ob_feed',
                                'id': deleteFeedId
                            };
                            jQuery.post(ajaxurl+'?type='+type, data, function(response) {
                                response = jQuery.parseJSON(response);
                                if(response.success == 1){
                                    //thismodel.destroy(); it make ajax http://wordpress/wp-admin/admin-ajax.php/14 with DELETE request
                                    thisview.remove();//Delete view
                                }
                                else{
                                    appRouter.navigate("notdeleted",{trigger: true});
                                }
                            });
                        }
                    },
                    cancel: function(){
                        //console.log('the user clicked cancel');
                    }
                }
            });

        }

    });
})(jQuery);