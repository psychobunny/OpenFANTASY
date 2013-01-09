function init() {
	dcp.templates.load(['header', 'example', 'form', 'dropdown', 'list'], function() {
		
		buildExample();
		buildHeader();
		buildDropdown();
		buildForm();
		buildList();

	});	
}

function buildExample() {
	var exampleTpl = dcp.templates('example');
	document.getElementById('example').innerHTML = exampleTpl({'difficulty': 'basic'});
}

function buildHeader() {
	var data  = {
		'title' : 'dcp.templates sample',
		'description' : 'dcp.templates is a simple javascript templating engine',
		'keywords' : 'templates templating javascript js engine tpl'
	};

	var header = dcp.templates('header');
	document.getElementsByTagName('head')[0].innerHTML = header(data);
}

/* this is an example of using namespaces. apart from the organizational benefit,
	it speeds up parsing by limiting replacements within block level. */
function buildForm() {
	var data = {
		'title' : 'Namespace Example',
		'form' : {
			'title' : 'First form',
			'firstname' : 'Enter your first name',
			'lastname' : 'Enter your last name',
			'action' : 'first.php'
		}
	}

	var form = dcp.templates('form');
	var a = form(data);


	data.form.title = 'Another Form';
	data.form.action = 'second.php';
	var b = form(data);

	result = a + b;
	
	document.getElementById('form').innerHTML = result;
}

/* dataset example: use an array to duplicate data within a block.
	this is useful for populating things like a select input with a predefined json string */
function buildList() {
	var data = {
		'title' : 'List of my favourite Fruits',
		'fruits' : [
			{'text' : 'Apples'},
			{'text' : 'Oranges'},
			{'text' : 'Bananas'}
		]
	}
	var list = dcp.templates('list');
	document.getElementById('list').innerHTML = list(data);
}
/* another dataset example */
function buildDropdown() {
	var data = {
		'title' : 'Choose a Month',
		'dates' : [
			{
				'value' : 'jan',
				'text' : 'January'
			},
			{
				'value' : 'feb',
				'text': 'February'
			},
			{
				'value' : 'mar',
				'text': 'March'
			},
			{
				'value' : 'apr',
				'text': 'April'
			},
			{
				'value' : 'may',
				'text': 'May'
			},
			{
				'value' : 'jun',
				'text': 'June'
			},
			{
				'value' : 'jul',
				'text': 'July'
			},
			{
				'value' : 'aug',
				'text': 'August'
			},
			{
				'value' : 'sep',
				'text': 'September'
			},
			{
				'value' : 'oct',
				'text': 'October'
			},
			{
				'value' : 'nov',
				'text': 'November'
			},
			{
				'value' : 'dec',
				'text': 'December'
			}
		]
	}

	var dropdown = dcp.templates('dropdown');
	
	document.getElementById('dropdown').innerHTML = dropdown(data);
}




window.onload = init;