var app = app || {};
var prfx = 'abm';

(function ($) {
	app.Quiz = BaseNestedModel.extend({

	});

	app.Quizzes = Backbone.Collection.extend({
		model: app.Quiz
	});

	/*{
			id: 1,
			name: 'How many Pixar movies have you seen?',
			author: 'admin',
			thumb: '',
			date: '24/03/2016',
			questions_count: 7,
			players_count: 700,
			views_count: 9000
		}*/
})(jQuery);