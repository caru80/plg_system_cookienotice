<?php
defined( '_JEXEC' ) or die();

jimport('joomla.plugin.plugin');

class plgSystemCookienotice extends JPlugin
{
	protected $autoloadLanguage = true;

	private $cookieName;
	private $config;		// Spachabhängige Einstellungen (Sprache, Menüeintrag Datenschutz, Text Override)
	private $privacyLink;
	private $textOverride;
	private $html;

	public function __construct( &$subject, $params )
	{
		parent::__construct( $subject, $params );

		$this->cookieName 	= $this->params->get('cookiename','cookienotice');
		$this->config 		= $this->params->get('privacy-links',null);

		if($this->config)
		{
			foreach($this->config as $i => $config)
			{
				if($config->target_language === JFactory::getLanguage()->getTag())
				{
					$this->config = $config;
					break;
				}
			}
		}
	}

	private function insertAssets()
	{
		$doc = JFactory::getApplication()->getDocument();

		$doc->addScript('media/plg_cookienotice/js/plgcookienotice.min.js');

		if((bool)$this->params->get('loadcssfile', true))
		{
			$doc->addStylesheet('media/plg_cookienotice/css/plgcookienotice.min.css');
		}

		return;
	}

	private function getPrivacyStatementLink()
	{
		$item = JFactory::getApplication()->getMenu()->getItem($this->config->target_menuitem);

		if($item)
		{
			$this->privacyLink = $item->link;
			if($item->type != 'url')
			{
				$this->privacyLink =  $this->privacyLink. "&Itemid=".$item->id;
			}
		}

		return;
	}

	public function onBeforeRender()
	{
		if(!$this->config || JFactory::getApplication()->input->cookie->get($this->cookieName, false) || JFactory::getApplication()->isAdmin()) return;

		$this->insertAssets();
		$this->getPrivacyStatementLink();
		$this->textOverride = $this->config->text_override;

		$path = JPluginHelper::getLayoutPath('system', 'cookienotice');
		// Rendere den Cookiehinweis
		ob_start();
		include $path;
		$this->html = ob_get_clean();
	}

	public function onAfterRender()
	{
		if(empty($this->html)) return;

		$buffer = JResponse::getBody();
		$buffer = str_replace("</body>", $this->html . "\n</body>", $buffer);

		JResponse::setBody( $buffer );
	}

}
