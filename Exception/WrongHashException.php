<?php

namespace IB\MediaProxyBundle\Exception;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * IB WrongHashException
 *
 * @author Thomas Bretzke <tb@ib.com>
 * @copyright (c) 2012 IB GmbH
 */
class WrongHashException extends NotFoundHttpException
{
}
