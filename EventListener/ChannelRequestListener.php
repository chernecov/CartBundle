<?php
/*
 * This file is part of the Sergey Chernecov software.
 *
 * (c) 2014
 *
 * Do not care about any copyright or license.
 */

namespace Chernecov\Bundle\CartBundle\EventListener;

use Chernecov\Bundle\CartBundle\Interfaces\EmbeddedInterface;
use Chernecov\Bundle\CartBundle\Services\ChannelManager;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\Event\GetResponseForControllerResultEvent;

/**
 * Channel request listener
 *
 * @author Sergey Chernecov <sergey.chernecov@gmail.com>
 */
class ChannelRequestListener
{
    /**
     * Channel manager
     *
     * @var ChannelManager
     */
    protected $channelManager;

    /**
     * Constructor
     *
     * @param ChannelManager $channelManager
     */
    public function __construct(ChannelManager $channelManager)
    {
        $this->channelManager = $channelManager;
    }

    /**
     * Let's choose channel for cart
     *
     * @param GetResponseEvent $event
     */
    public function onKernelRequest(GetResponseEvent $event)
    {
        $request = $event->getRequest();

        $channel = $request->headers->get('Cart-Channel');
        if (null !== $channel) {
            $this->channelManager->setActiveChannel($channel);
            return;
        }

        $channel = $request->query->get('cart_channel');
        if (null !== $channel) {
            $this->channelManager->setActiveChannel($channel);
            return;
        }
    }
}
