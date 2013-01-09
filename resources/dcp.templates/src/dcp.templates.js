var dcp = dcp || {};

dcp.templates = {};

(function() {	
	var 
		TEMPLATES_DIRECTORY = '../../templates/',
		stored_templates = {}
	;


	/**
	 * @param tpl A string containing the name of a loaded template
	 */
	dcp.templates = function(tpl) {

		function replace(key, value, template) {
			return template.replace("{" + key + "}", value);
		}

		function makeRegex(block) {
			return new RegExp("<!-- BEGIN " + block + " -->[^]*<!-- END " + block + " -->", 'g');
		}

		function getBlock(regex, block, template) {
			data = template.match(regex);			
			if (data == null) return;

			data = data[0]
				.replace("<!-- BEGIN " + block + " -->", "")
				.replace("<!-- END " + block + " -->", "");

			return data;
		}

		function setBlock(regex, block, template) {
			return template.replace(regex, block);
		}

		return function(data) {
			var template = stored_templates[tpl], regex, block;

			return (function parse(data, namespace, template) {

				for (var d in data) {
					if (data.hasOwnProperty(d)) {
						if (data[d] instanceof String) {
							continue;
						} else if (data[d].constructor == Array) {
							namespace += d;
							
							regex = makeRegex(d),
							block = getBlock(regex, namespace, template)
							if (block == null) continue;

							var numblocks = data[d].length - 1, i = 0, result = "";

							do {
								result += parse(data[d][i], namespace + '.', block);
							} while (i++ < numblocks);
							
							template = setBlock(regex, result, template);
							
						} else if (data[d] instanceof Object) {
							namespace += d + '.';
							
							regex = makeRegex(d),
							block = getBlock(regex, namespace, template)
							if (block == null) continue;

							block = parse(data[d], namespace, block);
							template = setBlock(regex, block, template);
						} else {								
							template = replace(namespace + d, data[d], template);
						}
					}					
				}

				return template;
				
			})(data, "", template);
		}
	}

	/**
	 * @param templates An array of templates to load
	 * @param callback A function called after all templates have been loaded (optional)
	 */
	dcp.templates.load = function (templates, callback) {		
		var 
			templatesToLoad = templates.length,
			templatesLoaded = 0
		;
		
		while(templatesToLoad--) {
			(function() {
				var i = templatesToLoad;

				dcp.ajax.call(TEMPLATES_DIRECTORY + templates[i] + '.tpl', function(template) {
					stored_templates[templates[i]] = template;					

					templatesLoaded++;
					if (templatesLoaded == templates.length) {
						if (callback) {
							callback();
						}
					}
				});	
			})(templatesToLoad);
		}
	}


}());