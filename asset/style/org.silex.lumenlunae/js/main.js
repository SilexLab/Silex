/* User panel behavior */
function updateUserPanel(e, action, ajaxSource, ajaxData) {
	// optional ajaxData value
	ajaxData = typeof ajaxData !== 'undefined' ? ajaxData : {};

	// prevent hyperlink
	e.preventDefault();

	var defObj = $.Deferred();

	// user panel
	var panel = $('#user-panel');

	function openPanel() {
		panel.css('height', panel.children('.w-size').outerHeight());
		if(!panel.hasClass('opened'))
			panel.addClass('opened');
	}

	function closePanel() {
		panel.css('height', 0);
		panel.removeClass('opened');
	}

	function getContent() {
		$.ajax({
			url: ajaxSource,
			data: ajaxData,
			async: false}).done(function(data) {
			panel.find('.w-content').html(data);
		});
	}

	if(panel.hasClass('opened')) {
		if(action.hasClass('active')) {
			closePanel();
			action.removeClass('active');
		} else {
			getContent();
			$('nav.user').find('.active').removeClass('active');
			action.addClass('active');
			openPanel();
		}
	} else {
		getContent();
		action.addClass('active');
		openPanel();
	}

	// function done
	return defObj.resolve();
	// function promise to be done soon
	//return defObj.promise();
}

/* */
$(document).ready(function() {
	// user panel
	$('#user-search').on('click', function(e) {
		updateUserPanel(e, $(this), baseURL + 'api/user-panel/searchbar.html').done(function() {
			$('#user-search-bar input').focus();
		});
	});
	$('#user-login').on('click', function(e) {
		updateUserPanel(e, $(this), baseURL + 'api/user-panel/login.html');
	});

	/* Functions */
	// Passwordswitch behavior
	$('body').on('mousedown', '.switch', function(e) {
		$(this).prev('[type="password"]').addClass('focus').attr('type', 'text');
	}).on('mouseup mouseleave', '.switch', function(e) {
		$(this).prev('[type="text"]').attr('type', 'password').focus().removeClass('focus');
	});
	$('body').on('focus', '[type="password"]', function(e) {
		$(this).next('.switch').addClass('focus');
	}).on('blur', '[type="password"]', function(e) {
		$(this).next('.switch').removeClass('focus');
	});
});
