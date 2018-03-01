<?php
	defined('_JEXEC') or die;
	/**
		Cookie-Hinweis Template

		$this->textOverride = Der im Backend eingetragene Override-Text
		$this->privacyLink  = Der zusammengesetzte URL des im Backend eingestellten Menüeintrag zum Datenschutzhinweis
		$this->cookieName 	= Der Name des Cookies, der beim akzeptieren gesetzt wird.
	*/
?>
<script>
'use strict';
(function($) {
	$(function() {
		window.cookieNotice.init({cookiename : '<?php echo $this->cookieName;?>'});

		var message = '<?php echo $this->textOverride != '' ? $this->textOverride : JText::_('PLG_COOKIENOTICE_FRONT_TEXT');?>',
			info	= <?php if(!empty($this->privacyLink)) : ?>'<a class="btn" href="<?php echo $this->privacyLink;?>"><?php echo JText::_('PLG_COOKIENOTICE_FRONT_BTN_INFO');?></a>'<?php else : ?>''<?php endif; ?>;

		window.cookieNotice.show({
			text : '<div id="plg-cookienotice" class="plg-cookienotice">' +
						'<span>' + message + '</span>' +
						'<span>' +
							'<a tabindex="0" class="btn ' + window.cookieNotice.options.css.button + '"><?php echo JText::_('PLG_COOKIENOTICE_FRONT_BTN_OK');?></a>' +
							info +
						'</span>' +
					'</div>'
		});
	});
})(jQuery);
</script>
