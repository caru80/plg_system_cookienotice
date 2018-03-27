'use strict';

(function($){

	window.cookieNotice = {

		defaults : {
			stage			: 'body',
			css 			: {visible : 'visible', button : 'msg-close', msgclass : 'plg-cookienotice'},
			cookiename 		: 'cookienotice',
			html 			: ''
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
			Entfernt alle Cookiehinweise
		*/
		removeMessages : function()
		{
			let messages 	= $('.'+this.options.css.msgclass),	// Alle Cookiehinweise
				time 		= 0, // Transition duration
				m;	// Ein Cookiehinweis


			let afterTransition = function()
			{
				this.remove();
			};

			for(let i = 0, len = messages.length; i < len; i++)
			{
				m = messages.eq(i);

				m.css('transition-duration').split(',').forEach(function(dur)
				{
					dur = parseFloat(dur);
					time = dur > time ? dur : time;
				});

				if(time > 0)
				{
					window.setTimeout(
						afterTransition.bind(m),
						time * 1000
					);
					m.removeClass(this.options.css.visible);
				}
				else
				{
					m.remove();
				}
			}
		},

		setTrigger : function()
		{
			let self 	= this,
				trigger = this.msg.find('.' + this.options.css.button);

			if(trigger.length)
			{
				trigger.on('click.cookienotice', function(ev)
				{
					ev.preventDefault();
					document.cookie = self.options.cookiename + "=1; expires=Fri, 31 Dec 9999 23:59:59 GMT; path=/";
					self.removeMessages();
					return false;
				});
			}
		},

		show : function(html)
		{
			this.msg = $(html);
			this.stage.append(this.msg);
			this.msg.get(0).offsetWidth;
			this.msg.addClass(this.options.css.visible);
			this.setTrigger();
		}
	}
})(jQuery);
