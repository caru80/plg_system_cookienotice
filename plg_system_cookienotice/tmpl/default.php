<?php
	defined('_JEXEC') or die;
	/**
		Cookie-Hinweis Template

		$this->textOverride = Der im Backend eingetragene Override-Text – Oder Nix
		$this->privacyLink  = Der zusammengesetzte URL des im Backend eingestellten Menüeintrag zum Datenschutzhinweis – Oder Nix
		$this->cookieName 	= Der Name des Cookies, der beim akzeptieren gesetzt wird.
	*/
?>
<script>
'use strict';
(function($) {
	$(function() {

		var message 	= '<?php echo $this->textOverride != '' ? $this->textOverride : JText::_('PLG_COOKIENOTICE_FRONT_TEXT');?>',
			info		= <?php if(!empty($this->privacyLink)) : ?>'<a class="btn" href="<?php echo $this->privacyLink;?>"><?php echo JText::_('PLG_COOKIENOTICE_FRONT_BTN_INFO');?></a>'<?php else : ?>''<?php endif; ?>;

		<?php
			/**
			window.cookieNotice.init Parameter, erwartet ein Objekt mit:

			cookiename 	- String; Cookie-Name
			stage 		- String; Optional, Default: 'body'; jQuery Selektor für ein HTML Element, an welchem der Cookiehinweis eingehängt werden soll.
			css 		- Objekt; Optional, Default: {
									visible 	: 'visible' – Klasse wenn Sichtbar
									button 		: 'msg-close' – Klasse des Schließen Button, beachte var template
									msgclass 	: 'plg-cookienotice' – Klasse des Cookiehinweis, beachte var template
								}

			window.cookieNotive.show Parameter:

			html – String; Dein HTML
			*/
		?>
		var template = 	'<div id="plg-cookienotice" class="plg-cookienotice">' +
							'<span>' + message + '</span>' +
							'<span>' +
								'<a tabindex="0" class="btn msg-close"><?php echo JText::_('PLG_COOKIENOTICE_FRONT_BTN_OK');?></a>' +
								info +
							'</span>' +
						'</div>';

		window.cookieNotice.init({cookiename : '<?php echo $this->cookieName;?>'});
		window.cookieNotice.show(template);

		<?php
		/**
			HILFE... ich muss – weil das Layout der Website „es erfordert” – zusätzlich einen 2. Cookiehinweis anzeigen lassen:

			window.cookieNotice.init({stage : '.hier-anzeigen', cookiename : '<?php echo $this->cookieName;?>'});
			window.cookieNotice.show(template);

			Wird ein Cookiehinweis geschlossen, werden auch alle Anderen geschlossen!
		*/
		?>
	});
})(jQuery);
</script>
