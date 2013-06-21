/**
 * ProcessWire Admin Theme jQuery/Javascript
 *
 * Copyright 2012 by Ryan Cramer
 *
 */

var ProcessWireAdminTheme = {

	/**
	 * Initialize the default ProcessWire admin theme
	 *
	 */
	init: function() {
		this.setupCloneButton();
		this.setupButtonStates();
		this.setupFieldFocus();
		this.sizeTitle();
		$('#content').removeClass('fouc_fix'); // FOUC fix
		this.browserCheck();
	},

	/**
	 * Clone a button at the bottom to the top
	 *
	 */
	setupCloneButton: function() {
		// if there are buttons in the format "a button" without ID attributes, copy them into the masthead
		// or buttons in the format button.head_button_clone with an ID attribute.
		// var $buttons = $("#content a[id=] button[id=], #content button.head_button_clone[id!=]");
		var $buttons = $("#main a:not([id]) button:not([id]), #content button.head_button_clone[id!=]");

		// don't continue if no buttons here or if we're in IE
		if($buttons.size() == 0 || $.browser.msie) return;

		var $head = $("<div id='head_button'></div>").appendTo("#bread .container").show();
		$buttons.each(function() {
			var $t = $(this);
			var $a = $t.parent('a');
			if($a.size()) {
				$button = $t.parent('a').clone();
				$head.append($button);
			} else if($t.is('.head_button_clone')) {
				$button = $t.clone();
				$button.attr('data-from_id', $t.attr('id')).attr('id', $t.attr('id') + '_copy');
				$a = $("<a></a>").attr('href', '#');
				$button.click(function() {
					$("#" + $(this).attr('data-from_id')).click(); // .parents('form').submit();
					return false;
				});
				$head.append($a.append($button));
			}
		});
	},

	/**
	 * Make buttons utilize the jQuery button state classes
	 *
 	 */
	setupButtonStates: function() {
		// jQuery UI button states
		$(".ui-button").hover(function() {
			$(this).removeClass("ui-state-default").addClass("ui-state-hover");
		}, function() {
			$(this).removeClass("ui-state-hover").addClass("ui-state-default");
		}).click(function() {
			$(this).removeClass("ui-state-default").addClass("ui-state-active").effect('highlight', {}, 500);
		});

		// make buttons with <a> tags click to the href of the <a>
		$("a > button").click(function() {
			window.location = $(this).parent("a").attr('href');
		});
	},

	/**
	 * Give a notice to IE versions we don't support
	 *
	 */
	browserCheck: function() {
		if($.browser.msie && $.browser.version < 9)
			$("#metro_pw").html("<div id='footer' class='footer'><div class='container'><br><br><br><br><br><br><h1>This ProcessWire THEME does not support IE7 and below at this time. <br>Please try again with a newer browser.</h1><br><br><br><br></div></div>").show();
	}

};


$(document).ready(function() {

	$(".Inputfields > .Inputfield > .ui-widget-header").addClass("InputfieldStateToggle").click(function() {
		var $li = $(this).parent('.Inputfield');
		$li.toggleClass('InputfieldStateCollapsed', 0);
		return false;
	});


	$(window).scroll(function () {
		$cont = $('#content > .container');
    	var offset = $(window).scrollTop();

    	var dist = 168;
    	if ($('.WireTabs').length != 0) {
	    	if(offset > dist){
	    		$cont.addClass('fixedNav');
	    	}
	    	else if(offset < (dist+1)){
	    		$cont.removeClass('fixedNav');
	    	}
    	}

    });

    $('a.PageListActionSelectToggle').click(function(){
    	$(this).hide();
    });

	$("#submit_save, #submit_save_unpublished, #submit_publish, #Inputfield_submit").clone().appendTo('.WireTabs');
	$(".ui-button-text:contains('Cancel')").parent('.ui-button').addClass('ui-button-cancel');
	$("span.PageListNumChildren:empty").remove();

});

