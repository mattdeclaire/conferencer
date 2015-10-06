PlatformElement.extend({
	initialize: function() {
		console.log(this.settings.toJSON());

		this.settings.save({
			test: "testing"
		}).done(function() {
			console.log(arguments);
		});
	}
});