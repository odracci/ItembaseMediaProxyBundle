<?php

namespace Itembase\Bundle\MediaProxyBundle\Event;

use Symfony\Component\EventDispatcher\Event;

class MediaProxyEvent extends Event
{
    protected $mediaUrl;
    protected $objectId;

    public function __construct($mediaUrl, $objectId=null)
    {
        $this->mediaUrl = $mediaUrl;
        $this->objectId = $objectId;
    }

    public function getMediaUrl()
    {
        return $this->mediaUrl;
    }

    public function getObjectId()
    {
        return $this->objectId;
    }
}