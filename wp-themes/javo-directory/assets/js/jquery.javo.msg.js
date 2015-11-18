/******************************
** javoThemes Custom Modal
** ver 1.0
******************************/
;(function($){
	"use strict";
	var javo_msg = {
		options:{}
		, el:{
			bg: null
			, modal: null
			, close_button: '<div class="text-center"><div class="javo-alert-box-close btn btn-dark">OK</div></div>'
		}
		, init: function(a, d){
			var a = $.extend({
				content			: 'No Message'
				, delay			: 5000
				, close			: true
				, confirm		: false
			}, a);
			window.jv_msg_call	= d;
			if( typeof javo_msg.options.nTimeID != 'undefined' ){
				javo_msg.close();
			}

			$('body').prepend('<div class="javo-alert-box" tabindex="-1"></div><div class="javo-alert-box-bg"></div>');

			javo_msg.el.bg = $('.javo-alert-box-bg');
			javo_msg.el.modal = $('.javo-alert-box');

			javo_msg.el.modal
				.html( '<h5>' + a.content + '</h5>' + javo_msg.el.close_button )
				.css({
					position		: 'fixed'
					, top			: '50%'
					, left			: '50%'
					, zIndex		: '999999'
					, background	: '#fff'
					, borderRadius	: '5px'
					, borderTop		: 'solid 5px #bbb'
					, padding		: '10px'
					, boxShadow		: '0 0 20px #aaa'
				}).css({
					marginLeft	: -(javo_msg.el.modal.outerWidth(true)) / 2
					, marginTop		: -(javo_msg.el.modal.outerHeight(true)) / 2
				}).focus();

			javo_msg.el.bg
				.css({
					'position'		:'fixed'
					, 'background'	: 'rgba(45, 45, 45, .2)'
					, 'top'			: '0px'
					, 'left'		: '0px'
					, 'right'		: '0px'
					, 'bottom'		: '0px'
					, 'zIndex'		: '999998'
				});
			var $object = this;

			javo_msg.options.nTimeID = setInterval(function(){
				javo_msg.close();
			}, a.delay);
			javo_msg.events();
		}
		, events: function(){
			var $object = this;
			$(document)
				.on('click', '.javo-alert-box-close', function(){
					javo_msg.close();
				});
		}
		, close: function(){
			javo_msg.el.bg.fadeOut('fast', function(){
				$(this).remove();
			});
			javo_msg.el.modal.fadeOut('fast', function(){
				$(this).remove();
			});
			if( typeof( window.jv_msg_call ) == 'function' ){
				window.jv_msg_call();
			};
			clearInterval( javo_msg.options.nTimeID );
		}
	}
	$.javo_msg = javo_msg.init;
})(jQuery);