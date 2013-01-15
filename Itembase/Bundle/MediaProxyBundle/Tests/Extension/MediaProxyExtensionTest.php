<?php
namespace Itembase\Bundle\MediaProxyBundle\Tests\Extension;

use Symfony\Component\Locale\Exception\NotImplementedException;

/**
 * Imap protocol service tests
 *
 * @author Bora Tunca <bt@itembase.biz>
 * @copyright (c) 2012 Itembase GmbH
 */
class StorageTest extends \PHPUnit_Framework_TestCase
{

	/**
	 * Test test
	 *
	 */
	public function testTestMethod()
	{
		$ex = new NotImplementedException('get me');
		$this->assertInstanceOf('Symfony\Component\Locale\Exception\NotImplementedException', $ex, ' I am impossible. ');
		$this->assertTrue(true, 'true is not true');
	}
}