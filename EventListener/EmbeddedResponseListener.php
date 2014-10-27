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
use FOS\RestBundle\View\View;
use Symfony\Component\HttpKernel\Event\GetResponseForControllerResultEvent;

/**
 * Embedded response listener
 *
 * @author Sergey Chernecov <sergey.chernecov@gmail.com>
 */
class EmbeddedResponseListener
{
    /**
     * Let's embed our response
     *
     * @param GetResponseForControllerResultEvent $event
     */
    public function onKernelView(GetResponseForControllerResultEvent $event)
    {
        $request = $event->getRequest();
        $view = $event->getControllerResult();

        if (!$view instanceof View) {
            return;
        }

        $data = $view->getData();
        if (!$data instanceof EmbeddedInterface) {
            return;
        }

        if ('POST' === $request->getRealMethod()) {
            $embedded = true;
        } else {
            $embedded = filter_var($request->get('_embedded'), FILTER_VALIDATE_BOOLEAN);
        }

        $data->setShowEmbedded((bool) $embedded);
    }
}
