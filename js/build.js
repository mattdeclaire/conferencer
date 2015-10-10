({
	baseUrl: './',
	mainConfigFile: 'app.js',
	name: 'app',
	out: '../www/js/app.js',
	stubModules: [
		'text',
		'tpl'
	],
	optimize: 'uglify2',
	uglify2: {
		output: {
			comments: false
		}
	},
	paths: {
		'requireLib': 'require'
	},
	wrap: true,
	include: [
		'requireLib'
	],
	namespace: 'Conferencer',
	preserveLicenseComments: false
})
