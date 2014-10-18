<?php
/*
 * This file is part of the Sergey Chernecov software.
 *
 * (c) 2014
 *
 * Do not care about any copyright or license.
 */

namespace Chernecov\Bundle\CartBundle\Services;

use Chernecov\Bundle\CartBundle\Interfaces\CartStorageInterface;
use Chernecov\Bundle\CartBundle\Model\Cart,
    Chernecov\Bundle\CartBundle\Model\CartItem;

/**
 * Cart Manager
 *
 * @author Sergey Chernecov <sergey.chernecov@gmail.com>
 *
 * @property Cart cart
 */
class CartManager
{
    /**
     * Constructor
     *
     * @param CartStorageInterface $cartStorage
     */
    public function __construct(CartStorageInterface $cartStorage)
    {
        $this->cartStorage = $cartStorage;
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
        $this->cartStorage->save(
            $this->cart,
            CartStorageInterface::CHANNEL_DEFAULT
        );
    }

    /**
     * Saving
     */
    public function clear()
    {
        $this->cart->clear();
        $this->save();
    }

    /**
     * Initialize cart
     *
     * @return Cart
     */
    protected function initialize()
    {
        $cart = $this->cartStorage->load(CartStorageInterface::CHANNEL_DEFAULT);
        if (!$cart instanceof Cart) {
            $cart = new Cart();
        }
        return $cart;
    }
}