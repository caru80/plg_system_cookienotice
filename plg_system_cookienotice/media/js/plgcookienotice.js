'use strict';

(function($){

	window.cookieNotice = {

		defaults : {
			stage			: 'body',
			css 			: {visible : 'visible', button : 'msg-close'},
			cookiename 		: 'cookienotice'
		},

		init : function( options )
		{
			if( options )
			{
				this.options = $.extend(true, {}, this.defaults, options);
			}
			else
			{
				this.options = this.defaults;
			}

			this.stage = $(this.options.stage);
		},

		/*
			Entfernt eine Nachricht von this.options.stage
		*/
		removeMessage : function(msg)
		{
			let self 	= this,
				removed = false; // Evtl. Chromes doppeltes Event-Abfeuern fixen

			document.cookie = this.options.cookiename + "=1; expires=Fri, 31 Dec 9999 23:59:59 GMT; path=/";

			$(msg).one('transitionend webkitTransitionEnd oTransitionEnd', function() {
				if(removed) return;
				$(this).remove();
				removed = true;
			}).removeClass(this.options.css.visible);
		},

		setTrigger : function( msg )
		{
			let self 	= this,
				trigger = msg.find('.' + this.options.css.button);

			if(trigger.length)
			{
				trigger.data('app-message', msg).on('click.cookienotic', function(ev)
				{
					ev.preventDefault();
					let msg = trigger.data('app-message');
					self.removeMessage( msg );
					return false;
				});
			}
		},

		/*
			m{
				text 					: String Text
			}
		*/
		show : function( m )
		{
			if(m.text == '') return;

			var $msg = $(m.text);

			this.stage.append($msg);
			$msg.get(0).offsetWidth; // Browser zwingen das Ding zu rendern, ganz wichtig!

			this.setTrigger($msg);
			$msg.addClass(this.options.css.visible);
		}
	}
})(jQuery);
