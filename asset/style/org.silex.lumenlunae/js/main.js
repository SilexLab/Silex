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

$(document).ready(function() {
	// user panel
	$('#user-search').on('click', function(e) {
		updateUserPanel(e, $(this), 'api/user-panel/searchbar.html').done(function() {
			// update input focus
			$('#user-search-bar input').on('focus', function(e) {
				$(this).closest('.input').addClass('focus');
			}).on('blur', function(e) {
				$(this).closest('.input').removeClass('focus');
			});
			
			$('#user-search-bar input').focus();
		});
	});
	$('#user-login').on('click', function(e) {
		updateUserPanel(e, $(this), 'api/user-panel/login.html');
	});

	/* Style */
	// $('#user_panel_toggle').on('click', function(e) {
	// 	e.preventDefault();
	// 	/* because css3 can't handle height auto / 100% with transition */
	// 	var panel = $('#user_panel_content');
	// 	if(panel.height())
	// 		panel.css('height', 0);
	// 	else
	// 		panel.css('height', $('#user_panel_content_inner').outerHeight());
	// 	/* end damn css3 workaround */
	// 	$('#user_panel_content').closest('.user_panel').toggleClass('opened');
	// 	$('#user_panel_toggle').toggleClass('active');
	// });

	// input focus
	$('.input input').on('focus', function(e) {
		$(this).closest('.input').addClass('focus');
	}).on('blur', function(e) {
		$(this).closest('.input').removeClass('focus');
	});


	/* Functions */
	// Passwordswitch behavior
	$('.switch').on('mousedown', function(e) {
		$(this).prev('[type="password"]').attr('type', 'text');
	}).on('mouseup mouseleave', function(e) {
		$(this).prev('[type="text"]').attr('type', 'password').focus();
	});
	// Searchbar behavior
	// $('#main_search').children('input[type="search"]').on('blur', function(e) {
	// 	if($(this).val().length > 0)
	// 		$(this).addClass('focus');
	// 	else
	// 		$(this).removeClass('focus');
	// });
});
