<?php

namespace Itembase\Bundle\MediaProxyBundle;

final class MediaProxyEvents
{
    /**
     * The media.proxy event is thrown each time a resource is
     * proxied.
     *
     * The event listener receives an
     * Itembase\Bundle\MediaProxyBundle\Event\MediaProxyEvent instance.
     *
     * @var string
     */
    const MEDIA_PROXY = 'media.proxy';
}