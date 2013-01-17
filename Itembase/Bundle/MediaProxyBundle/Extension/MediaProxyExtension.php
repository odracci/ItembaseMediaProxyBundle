<?php
namespace Itembase\Bundle\MediaProxyBundle\Extension;

use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

/**
 * Itembase MediaProxyExtension
 * A twig extension to generate and use a proxy path
 *
 * @author Thomas Bretzke <tb@itembase.biz>, Bora Tunca <bt@itembase.biz>
 **/
class MediaProxyExtension extends \Twig_Extension {

	private $prefixPath;
	private $ignoreHttps;
	private $algorithm;
	private $secret;
	private $router;

    /**
     *
     * @param string $prefixPath
     * @param string $ignoreHttps
     * @param string $algorithm
     * @param string $secret
     * @param UrlGeneratorInterface $router
     */
	public function __construct($prefixPath, $ignoreHttps, $algorithm, $secret, UrlGeneratorInterface $router)
	{
		$this->prefixPath = $prefixPath;
		$this->ignoreHttps = $ignoreHttps;
		$this->algorithm = $algorithm;
		$this->secret = $secret;
		$this->router = $router;
	}

    /**
	 *
     * @return array
     */
	public function getFilters()
	{
		return array(
			'ib_proxy_url'  => new \Twig_Filter_Method($this, 'proxyUrl'),
		);
	}

    /**
	 *
	 * @param string $url
     * @return string
     */
    public function proxyUrl($url) 
	{
		$parsedUrl = parse_url($url);

		if (false === array_key_exists('scheme', $parsedUrl)) { return $this->prefixPath.$url; }

		if ($this->ignoreHttps && 'https' === $parsedUrl['scheme']) { return $url; }

		$isSecure = (!empty($_SERVER['HTTPS'])) && ($_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443);
		if (false === $isSecure) {
			return $url;
		}

		// Generate proxy path
		$hash = hash_hmac($this->algorithm, $url, $this->secret);
		return $this->router->generate('ItembaseMediaProxyBundle_proxy', array('hash' => urlencode($hash), 'path' => rawurlencode($url)));
	}

    /**
	 *
     * @return string
     */
	public function getName()
	{
		return 'itembase_media_proxy';
	}
}