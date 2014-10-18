<?php
/*
 * This file is part of the Sergey Chernecov software.
 *
 * (c) 2014
 *
 * Do not care about any copyright or license.
 */

namespace Chernecov\Bundle\CartBundle\Services;

use Chernecov\Bundle\CartBundle\Model\Cart,
    Chernecov\Bundle\CartBundle\Model\CartItem;

use Symfony\Component\EventDispatcher\EventDispatcherInterface,
    Symfony\Component\HttpFoundation\Session\Session;

/**
 * /**
 * Embedded trait
 *
 * @author Sergey Chernecov <sergey.chernecov@gmail.com>
 *
 * @property Cart cart
 */
class CartManager
{
    const CHANNEL_CART = 'cart';

    /**
     * Constructor
     *
     * @param Session $session
     * @param EventDispatcherInterface $dispatcher
     */
    public function __construct(Session $session, EventDispatcherInterface $dispatcher)
    {
        $this->session = $session;
        $this->dispatcher = $dispatcher;
        $this->cart = $this->initialize();
    }

    /**
     * Getting cart
     *
     * @return Cart
     */
    public function getCart()
    {
        return $this->cart;
    }

    /**
     * Adding
     *
     * @param CartItem $cartItem
     */
    public function add(CartItem $cartItem)
    {
        $found = $this->find($cartItem);
        if ($found instanceof CartItem) {
            $count = $found->getCount() + $cartItem->getCount();
            $found->setCount($count);
        } else {
            $this->cart->addItem($cartItem);
        }
        $this->save();
    }

    /**
     * Find
     *
     * @param CartItem $cartItem
     * @return CartItem|null
     */
    protected function find(CartItem $cartItem)
    {
        foreach ($this->cart->getItems() as $item) {
            if ($item->getRelatedId() === $cartItem->getRelatedId()) {
                return $item;
            }
        }
        return null;
    }

    /**
     * Saving
     */
    protected function save()
    {
        $this->session->set(
            self::CHANNEL_CART,
            serialize($this->cart)
        );
    }

    /**
     * Saving
     */
    public function clear()
    {
        $this->cart->clear();
        $this->session->set(
            self::CHANNEL_CART,
            serialize($this->cart)
        );
    }

    /**
     * Initialize cart
     *
     * @return Cart
     */
    protected function initialize()
    {
        $cart = unserialize($this->session->get(self::CHANNEL_CART));
        if (!$cart instanceof Cart) {
            $cart = new Cart();
            $cart->setSessionId($this->session->getId());
        }
        return $cart;
    }
}