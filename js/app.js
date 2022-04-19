require.config({
	baseUrl: '/js-dev',
	paths: {
		'jquery': 'vendor/jquery-2.1.4',
		'mustache': 'vendor/mustache',
		'text': 'vendor/text',
		'tpl': 'vendor/tpl'
	}
});

require(['main']);
