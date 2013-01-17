<?php
namespace Itembase\Bundle\MediaProxyBundle\Tests\Extension;

use Itembase\Bundle\MediaProxyBundle\Extension\MediaProxyExtension;

/**
 * MediaProxyExtension twig filter tests
 *
 * @author Bora Tunca <bt@itembase.biz>
 * @copyright (c) 2013 Itembase GmbH
 */
class MediaProxyExtensionTest extends \PHPUnit_Framework_TestCase
{

	/**
	 *
	 * @return UrlGeneratorInterface mock object
	 */
	private function createRouterMock()
	{
		return $this->getMockBuilder('Symfony\Component\Routing\Generator\UrlGeneratorInterface')
			->disableOriginalConstructor()
			->getMock();
	}

	/**
	 *
	 */
	public function testGetFilters()
	{
		$router = $this->createRouterMock();

		$extension = new MediaProxyExtension(null, null, null, null, $router);
		$filters = $extension->getFilters();

		$this->assertArrayHasKey('ib_proxy_url', $filters, 'expected filter is not loaded.');

		$filterMethod = $filters['ib_proxy_url'];
		$this->assertInstanceOf('\Twig_Filter_Method', $filterMethod, 'filter does not registers a correct callable.');
		
		$callable = $filterMethod->getCallable();

		$this->assertSame($callable[0], $extension, 'callable instance is not set correctly');
		$this->assertSame($callable[1], 'proxyUrl', 'callable method name is not set correctly');
	}

	/**
	 *
	 */
	public function testGetName()
	{
		$router = $this->createRouterMock();

		$extension = new MediaProxyExtension(null, null, null, null, $router);
		$this->assertSame($extension->getName(), 'itembase_media_proxy', 'callable method name is not set correctly');
	}

	/**
	 *
	 */
	public function testProxyUrlReturnPrefix()
	{
		$router = $this->createRouterMock();

		$prefixPath = 'www.cdn.domain.com';
		$ignoreHttps = false;
		$algorithm = 'sha2';
		$secret = 'secretttToptttTen';

		$extension = new MediaProxyExtension($prefixPath, $ignoreHttps, $algorithm, $secret, $router);
		$urlParameter = '/high/12312.jpg';
		$url = $extension->proxyUrl($urlParameter);
		$this->assertSame('www.cdn.domain.com/high/12312.jpg', $url, 'prefix return failed');
	}

	/**
	 *
	 */
	public function testProxyUrlIgnoreHttps()
	{
		$router = $this->createRouterMock();

		$prefixPath = 'www.cdn.domain.com';
		$ignoreHttps = true;
		$algorithm = 'sha2';
		$secret = 'secretttToptttTen';

		$extension = new MediaProxyExtension($prefixPath, $ignoreHttps, $algorithm, $secret, $router);
		$urlParameter = 'https://www.test.domain.com/high/12312.jpg';
		$url = $extension->proxyUrl($urlParameter);
		$this->assertSame($urlParameter, $url);
	}

	/**
	 *
	 */
	public function testProxyUrlUnsecureConnection()
	{
		$router = $this->createRouterMock();

		$prefixPath = 'www.cdn.domain.com';
		$algorithm = 'sha2';
		$secret = 'secretttToptttTen';

		$_SERVER['HTTPS'] = null; //make unsecure

		$ignoreHttps = true;

		$extension = new MediaProxyExtension($prefixPath, $ignoreHttps, $algorithm, $secret, $router);
		$urlParameter = 'http://www.test.domain.com/high/12312.jpg';
		$url = $extension->proxyUrl($urlParameter);
		$this->assertSame($urlParameter, $url);

		$ignoreHttps = false;

		$extension = new MediaProxyExtension($prefixPath, $ignoreHttps, $algorithm, $secret, $router);
		$urlParameter = 'https://www.test.domain.com/high/12312.jpg';
		$url = $extension->proxyUrl($urlParameter);
		$this->assertSame($urlParameter, $url);
	}

	/**
	 *
	 */
	public function testProxyUrlSecureConnection()
	{
		$this->markTestIncomplete(
          'This test has not been implemented yet.'
        );
		$router = $this->createRouterMock();
		$prefixPath = 'www.cdn.domain.com';
		$ignoreHttps = false;
		$algorithm = 'sha1';
		$secret = 'secretttToptttTen';

		$_SERVER['HTTPS'] = 'on'; //make secure
		
		$urlParameter = 'https://www.test.domain.com/high/12312.jpg';
		$resultUrlParameter = 'https://www.test.domain.com/origin/123sdfsdf23dfsdfhash?path=encodedUrl';

		$hash = hash_hmac($algorithm, $resultUrlParameter, $secret); //TODO find a work around

		$router->expects($this->once())
			->method('generate')
			->with('ItembaseMediaProxyBundle_proxy', array('hash' => urlencode($hash), 'path' => rawurlencode($urlParameter)))
			->will($this->returnValue('$resultUrlParameter'));

		$extension = new MediaProxyExtension($prefixPath, $ignoreHttps, $algorithm, $secret, $router);
		$extension->proxyUrl($urlParameter);
	}
}