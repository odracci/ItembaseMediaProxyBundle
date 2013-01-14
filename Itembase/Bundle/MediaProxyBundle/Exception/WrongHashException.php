<?php

namespace Itembase\Bundle\MediaProxyBundle\Exception;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * WrongHashException
 *
 * @author Thomas Bretzke <tb@itembase.biz>
 * @copyright (c) 2012 itembase GmbH
 */
class WrongHashException extends NotFoundHttpException
{
}
