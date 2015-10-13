define(['text'], function(text) {
	var buildMap = {};

	return {
		load: function(name, req, onLoad, config) {
			if (config.isBuild && config.inlineTpl === false) return onLoad();

			var load = function(data) {
				if (config.isBuild) buildMap[name] = data;
				onLoad(data);
			};

			text.get(req.toUrl('templates/' + name + '.tpl'), load, onLoad.error);
		},

		write: function (pluginName, moduleName, write, config) {
			if (buildMap.hasOwnProperty(moduleName)) {
				var content = text.jsEscape(buildMap[moduleName]);

				write.asModule(
					pluginName + "!" + moduleName,
					"define(function () { return '" + content + "'; });\n"
				);
			}
		}
	};
});
