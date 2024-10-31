var app = app || {};
var prfx = 'abm';

(function ($) {
    $(document).ready(function () {
        app.QuizView = Backbone.View.extend({
            model: window[prfx + '_quiz'],
            template: _.template($("#quiz-template").html()),
            render: function () {
                this.$el.html(this.template(this.model.toJSON()));

                return this;
            }
        });
        app.QuizzesView = Backbone.View.extend({
            model: window[prfx + '_settings'],
            template: _.template($("#page-tabs-template").html()),
            initialize: function () {

            },
            bindings: function () {
                var result = {};
                var prfx = 'general.';
                var fields = this.model.defaults.general;

                _.each(fields, function (val, key, list) {
                    result['[name="' + key + '"]'] = prfx + key;
                });

                return result;
            },
            render: function () {
                var html = this.template({});
                this.$el.html(html);

                var Collection = Backbone.Collection.extend({});
                var quizzes_tabs = new Collection([
                    {
                        id: 'index',
                        label: 'All Quizzes'
                    }
                ]);
                var tabs = app.Cp.Tabs({
                    el: '#page-tabs',
                    collection: quizzes_tabs
                });

                tabs.on("selectionChanged", function () {
                    var selectedModel = tabs.getSelectedModel();
                    var html = app.CpView({
                        template: '#quizzes-' + selectedModel.get('id') + '-template',
                        model: {
                            filters: app.Cp.Filter({}),
                            pagination: app.Cp.Pagination({})
                        }
                    });
                    $('#page-tabs-content').html(html);
                    var collection_view = new Backbone.CollectionView({
                        el: $('#quizzes'),
                        class: 'active',
                        collection: window[prfx + '_quizzes'],
                        modelView: app.QuizView
                    });
                    collection_view.render();
                });



                this.delegateEvents();
                return this;
            },
            close: function () {
                this.unstickit();
            }
        });
    });
})(jQuery);

