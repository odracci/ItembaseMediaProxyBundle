<?php

namespace Itembase\Bundle\MediaProxyBundle\Event;

use Symfony\Component\EventDispatcher\Event;

class MediaProxyEvent extends Event
{
    protected $mediaUrl;

    public function __construct($mediaUrl)
    {
        $this->mediaUrl = $mediaUrl;
    }

    public function getMediaUrl()
    {
        return $this->mediaUrl;
    }
}