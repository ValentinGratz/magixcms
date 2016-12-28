/**
* MAGIX CMS
* @copyright  MAGIX CMS Copyright (c) 2010 Gerits Aurelien,
    * http://www.magix-cms.com, magix-cms.com http://www.magix-cjquery.com
    * @license    Dual licensed under the MIT or GPL Version 3 licenses.
    * @version    1.0
* @author Gérits Aurélien <aurelien@magix-cms.com>
* JS theme default
*
*/
function getPosition(element) {
	var xPosition = 0;
	var yPosition = 0;

	while(element) {
		xPosition += (element.offsetLeft - element.scrollLeft + element.clientLeft);
		yPosition += (element.offsetTop - element.scrollTop + element.clientTop);
		element = element.offsetParent;
	}
	return { x: xPosition, y: yPosition };
}

$(function()
{
	var width = $(window).width();
	// *** In case you don't have firebug...
    if (!window.console || !console.firebug) {
        var names = ["log", "debug", "info", "warn", "error", "assert", "dir", "dirxml", "group", "groupEnd", "time", "timeEnd", "count", "trace", "profile", "profileEnd"];
        window.console = {};
        for (var i = 0; i < names.length; ++i) window.console[names[i]] = function() {};
    }

	// *** target_blank
    $('a.targetblank').click( function() {
        window.open($(this).attr('href'));
        return false;
    });

	// *** Bootstrap components
	$('[data-toggle="tooltip"]').tooltip();
	//$('[data-toggle="popover"]').popover();

	// *** Auto-position of the affix header
	var aHead = document.getElementById('header-fixed');
	if (aHead != null) {
		if ($('#header-fixed').hasClass('affix-menubar')) {
			var target = getPosition(document.getElementById('main-menu'));
		} else {
			var target = getPosition(document.getElementById('header'));
		}
		$('#header-fixed').affix({
			offset: {
				top: target.y,
				bottom: function () {
					return (this.bottom = $('.footer').outerHeight(true))
				}
			}
		})
	} else {
		if(width > 768) {
			var target = getPosition(document.getElementById('header-menu'));
			var space = $('#header-menu').height();

			function affixHead() {
				var scrollTop = $(window).scrollTop();
				if (scrollTop > target.y) {
					$('#header-menu').addClass('affix affix-top');
					if (document.getElementById('toolbar') != null) $('#toolbar').css('margin-bottom',space)
				} else {
					$('#header-menu').removeClass('affix affix-top');
					if (document.getElementById('toolbar') != null) $('#toolbar').css('margin-bottom',0)
				}
			}
			$(window).scroll(affixHead);
			affixHead();
		}
	}

    // *** Smooth Scroll to Top
    var speed = 1000;
    $('.toTop').click(function(e){
        e.preventDefault();
        $('html, body').animate({ scrollTop: 0 }, speed);
        return false;
    });

    // *** Cross effect on mobile
    if(width < 768) {
        $('button.navbar-toggle').click(function(){
            var target = $($(this).data('target'));
            if($(this).hasClass('open') || $(target).hasClass('collapse in')){
                $(this).removeClass('open');
            }else{
                $(this).addClass('open');
            }
        });
    }
});