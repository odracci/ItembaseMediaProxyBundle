<?php

namespace Itembase\Bundle\MediaProxyBundle\Exception;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * WrongHashException
 *
 * @author Thomas Bretzke <tb@ib.com>
 * @copyright (c) 2012 IB GmbH
 */
class WrongHashException extends NotFoundHttpException
{
}
