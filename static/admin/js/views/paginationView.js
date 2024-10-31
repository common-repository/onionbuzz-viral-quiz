var app = app || {};

(function($) {
    'use sctrict';

    app.PaginationView = Backbone.View.extend({
        el: '',
        tagName: 'div',
        className: 'laqm-pagination',
        template: _.template($("#paginationView").html()), // шаблон
        link: "", // ссылка
        page_count: null, // кол-во страниц
        page_active: null, // активная страница
        page_show: 5, // кол-во страниц в блоке видимости
        attributes: { // атрибуты элемента
            "class": "pagination"
        },
        initialize: function(params) { // конструктор
            this.link = params.link;
            this.page_count = params.page_count;
            if (this.page_count <= this.page_show) {
                this.page_show = this.page_count;
            }
            this.page_active = params.page_active;
            this.render('ww');
            console.log('init pagination');
        },

        render: function(eventName) { // выдача
            var range = Math.floor(this.page_show / 2);
            var nav_begin = this.page_active - range;
            if (this.page_show % 2 == 0) { // Если четное кол-во
                nav_begin++;
            }
            var nav_end = this.page_active + range;
            var left_dots = true;
            var right_dots = true;
            if (nav_begin <= 2) {
                nav_end = this.page_show;
                if (nav_begin == 2) {
                    nav_end++;
                }
                nav_begin = 1;
                left_dots = false;
            }

            if (nav_end >= this.page_count - 1 ) {
                nav_begin = this.page_count - this.page_show + 1;
                if (nav_end == this.page_count - 1) {
                    nav_begin--;
                }
                nav_end = this.page_count;
                right_dots = false;
            }
            var template = _.template( $("#pagination-view").html());
            // Load the compiled HTML into the Backbone "el"
            this.$el.html( template );

        }
    });
})(jQuery);