<?php
/*
 * This file is part of the Sergey Chernecov software.
 *
 * (c) 2014
 *
 * Do not care about any copyright or license.
 */

namespace Chernecov\Bundle\CartBundle\Controller;

use Chernecov\Bundle\CartBundle\Model\CartItem,
    Chernecov\Bundle\CartBundle\Services\CartManager;

use FOS\RestBundle\Controller\FOSRestController,
    FOS\RestBundle\Controller\Annotations as FOS,
    FOS\RestBundle\View\View;

use Nelmio\ApiDocBundle\Annotation as Nelmio;
use Sensio\Bundle\FrameworkExtraBundle\Configuration as Extra;
use JMS\DiExtraBundle\Annotation as DI;
use Symfony\Component\Validator\ConstraintViolationList;

/**
 * Cart item controller
 *
 * @author Sergey Chernecov <sergey.chernecov@gmail.com>
 *
 */
class CartItemController extends FOSRestController
{
    /**
     * @DI\Inject("chernecov.cart.manager")
     *
     * @var CartManager
     */
    protected $cartManager;

    /**
     * Let's patch cart item quantity
     *
     * @Nelmio\ApiDoc(
     *      section="Cart Item",
     *      resource=true,
     *      statusCodes={
     *          200="Returned when successful"
     *      }
     * )
     *
     * @FOS\Route(
     *      pattern = "/item/{id}/quantity/{quantity}",
     *      requirements = {
     *          "_method" = "PATCH"
     *      }
     * )
     *
     * @FOS\View(statusCode=200)
     *
     * @param string $id
     * @param int $quantity
     *
     * @return View
     */
    public function patchQuantityAction($id, $quantity)
    {
        $this->cartManager->changeCartItemQuantity($id, $quantity);
        return $this->view($this->cartManager->getCart());
    }

    /**
     * Let's remove cart item
     *
     * @Nelmio\ApiDoc(
     *      section="Cart Item",
     *      resource=true,
     *      statusCodes={
     *          200="Returned when successful"
     *      }
     * )
     *
     * @FOS\Route(
     *      pattern = "/item/{id}/remove",
     *      requirements = {
     *          "_method" = "DELETE"
     *      }
     * )
     *
     * @FOS\View(statusCode=200)
     *
     * @param string $id
     *
     * @return View
     */
    public function deleteAction($id)
    {
        $this->cartManager->removeItem($id);
        return $this->cartManager->getCart();
    }

    /**
     * Let's patch cart item with json
     *
     * @Nelmio\ApiDoc(
     *      section="Cart Item",
     *      resource=true,
     *      statusCodes={
     *          200="Returned when successful"
     *      }
     * )
     *
     * @FOS\Route(
     *      pattern = "/item/{id}/modify",
     *      requirements = {
     *          "_method" = "PATCH"
     *      }
     * )
     *
     * @FOS\View(statusCode=200)
     *
     * @param string $id
     *
     * @return View
     */
    public function patchAction($id)
    {
        return $this->view('success');
    }

    /**
     * Let's post new item
     *
     * @Nelmio\ApiDoc(
     *      section="Cart Item",
     *      resource=true,
     *      statusCodes={
     *          201="Returned when successful"
     *      }
     * )
     *
     * @Extra\ParamConverter(
     *      "cartItem",
     *      class="Chernecov\Bundle\CartBundle\Model\CartItem",
     *      converter = "converter.json_to_model"
     * )
     *
     * @FOS\Route(
     *      pattern = "/item/add",
     *      defaults={
     *          "_format" = "json"
     *      },
     *      requirements = {
     *          "_method" = "POST"
     *      }
     * )
     *
     * @FOS\View(statusCode=201)
     *
     * @param CartItem $cartItem
     * @param ConstraintViolationList $violations
     *
     * @return View
     */
    public function postAction(CartItem $cartItem = null, ConstraintViolationList $violations)
    {
        if ($violations->count()) {
            return $this->view('Bad request', 400);
        }

        $this->cartManager->add($cartItem);
        $cart = $this->cartManager->getCart();

        return $this->view($cart);
    }
}