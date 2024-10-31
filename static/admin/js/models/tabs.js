var app = app || {};
var prfx = 'abm';

(function ($) {
	app.Tab = Backbone.Model.extend({});

	app.Tabs = Backbone.Collection.extend({
		model: app.Tab
	});

	window[prfx + '_tabs'] = new app.Tabs([
		{
			id: 'quizzes',
			label: 'Quizzes'
		},
		{
			id: 'feeds',
			label: 'Feeds'
		},
		{
			id: 'settings',
			label: 'Settings'
		},
		{
			id: 'help',
			label: 'Help'
		}
	]);
})(jQuery);