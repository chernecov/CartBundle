<?php
/*
 * This file is part of the Sergey Chernecov software.
 *
 * (c) 2014
 *
 * Do not care about any copyright or license.
 */

namespace Chernecov\Bundle\CartBundle\Controller;

use Chernecov\Bundle\CartBundle\Services\CartManager;

use FOS\RestBundle\Controller\FOSRestController,
    FOS\RestBundle\Controller\Annotations as FOS,
    FOS\RestBundle\View\View;

use JMS\DiExtraBundle\Annotation as DI;
use Nelmio\ApiDocBundle\Annotation as Nelmio;

/**
 * Channel controller class
 *
 * @author Sergey Chernecov <sergey.chernecov@gmail.com>
 */
class CartController extends FOSRestController
{
    /**
     * @DI\Inject("chernecov.cart.manager")
     *
     * @var CartManager
     */
    protected $cartManager;

    /**
     * Let's get our cart
     *
     * @Nelmio\ApiDoc(
     *      section="Cart",
     *      resource=true,
     *      statusCodes={
     *          200="Returned when successful",
     *          404="Returned when not found"
     *      }
     * )
     *
     * @FOS\Route(
     *      pattern="/content"
     * )
     *
     * @FOS\View(statusCode=200)
     *
     * @return View
     */
    public function getAction()
    {
        $cart = $this->cartManager->getCart();
        return $this->view($cart);
    }

    /**
     * Let's clear our cart
     *
     * @Nelmio\ApiDoc(
     *      section="Cart",
     *      resource=true,
     *      statusCodes={
     *          200="Returned when successful",
     *          404="Returned when not found"
     *      }
     * )
     *
     * @FOS\Route(
     *      pattern = "/clear",
     *      requirements = {
     *          "_method" = "DELETE"
     *      }
     * )
     *
     * @FOS\View(statusCode=200)
     *
     * @return View
     */
    public function deleteAction()
    {
        $this->cartManager->clear();
        return $this->view('success');
    }
}