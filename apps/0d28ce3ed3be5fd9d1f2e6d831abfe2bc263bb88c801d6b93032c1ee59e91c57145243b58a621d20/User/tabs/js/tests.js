jQuery(document).ready(function () {
	var url = OF_PATH + 'web/user';

	// TODO: write helper functions ex. OF.Call(method, params, callback);
	function getvar(name) {
		return window[name];
	}
	function storevar(name, value) {
		window[name] = value;
	}
	// End helper functions

	asyncTest( "Authenticating", function() {
		var xhr = jQuery.get(OF_PATH + 'web/openfantasy/authenticate', {'appKey': APP_KEY, 'appSecret': APP_SECRET}, function(data) {
			ok(data.status == 1, JSON.stringify(data));
			start();
		});
	});
		
	asyncTest( "Registering user", function() {
		storevar('id', Math.floor(Math.random()* +new Date));

		var registrationInfo = {
			'username': 'of_tester' + getvar('id'),
			'password': 'of_tester' + getvar('id'),
			'email': 'of_tester@' + getvar('id') + 'openfantasy.org'
		};

		var xhr = jQuery.post(url + '/register', registrationInfo, function(data) {
			ok(data.status == 1, JSON.stringify(data));
			storevar('userID', data.userID);			
			start();
		});
	});

	asyncTest( "Logging in the user", function() {
		var loginInfo = {
			'email': 'of_tester@' + getvar('id') + 'openfantasy.org',
			'password': 'of_tester' + getvar('id')
		};

		var xhr = jQuery.post(url + '/login', loginInfo, function(data) {
			ok(data.status, JSON.stringify(data));
			start();
		});
	});

	asyncTest( "Getting User Info", function() {		
		var xhr = jQuery.get(url + '/get', {}, function(data) {
			ok(true, JSON.stringify(data));
			start();
		});

	});

	asyncTest( "Getting User Info by ID", function() {		
		var xhr = jQuery.get(url + '/get', {'userID': getvar(userID)}, function(data) {
			ok(true, JSON.stringify(data));
			start();
		});
	});

	asyncTest( "Logging out the user", function() {
		var xhr = jQuery.post(url + '/logout', {}, function(data) {
			ok(true, JSON.stringify(data));
			start();
		});
	});

	asyncTest( "Getting User Info (Should return empty array since logged out)", function() {		
		var xhr = jQuery.get(url + '/get', {}, function(data) {
			ok(data == false, JSON.stringify(data));
			start();
		});
	});

	asyncTest( "Getting User Info by ID", function() {		
		var xhr = jQuery.get(url + '/get', {'userID': getvar('userID')}, function(data) {
			ok(true, JSON.stringify(data));
			start();
		});
	});

	asyncTest( "Admin: Get full information about the user", function() {
		var xhr = jQuery.get(url + '/admin/get', {'userID' : getvar('userID')}, function(data) {
			ok(true, JSON.stringify(data));
			start();
		});
	});

	asyncTest( "Admin: Edit User's Information", function() {
		var xhr = jQuery.post(url + '/admin/edit', {}, function(data) {
			ok(true, JSON.stringify(data));
			start();
		});
	});

	asyncTest( "Admin: Delete User", function() {
		var xhr = jQuery.post(url + '/admin/delete', {'userID' : getvar('userID')}, function(data) {
			ok(data.status, JSON.stringify(data));
			start();
		});
	});


	asyncTest( "Attempt to Login back to account (Should fail)", function() {
		var loginInfo = {
			'email': 'of_tester' + getvar('id'),
			'password': 'of_tester' + getvar('id')
		};

		var xhr = jQuery.post(url + '/login', loginInfo, function(data) {
			ok(true, JSON.stringify(data));
			start();
		});
	});
	console.log('end');
});