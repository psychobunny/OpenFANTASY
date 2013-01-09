var dcp = dcp || {};

dcp.ajax = {};

(function() {	
	var CACHED = false; // TODO
	
	dcp.ajax.call = function(url,callback,postData) {
		var req = createXMLHTTPObject();
		
		req.open('GET', url, true);

		req.onreadystatechange = function () {
			if (req.readyState != 4) return;
			callback(req.responseText);
		}

		req.send(postData);
	}

	// taken from here: www.quirksmode.org/js/xmlhttp.html
	var XMLHttpFactories = [
		function () {return new XMLHttpRequest()},
		function () {return new ActiveXObject("Msxml2.XMLHTTP")},
		function () {return new ActiveXObject("Msxml3.XMLHTTP")},
		function () {return new ActiveXObject("Microsoft.XMLHTTP")}
	];

	function createXMLHTTPObject() {
		var xmlhttp = false;
		for (var i=0;i<XMLHttpFactories.length;i++) {
			try {
				xmlhttp = XMLHttpFactories[i]();
			}
			catch (e) {
				continue;
			}
			break;
		}
		return xmlhttp;
	}
}());
