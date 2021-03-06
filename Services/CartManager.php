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
 */
class CartManager
{
    /**
     * Cart
     *
     * @var Cart|null
     */
    protected $cart = null;

    /**
     * Channel manager
     *
     * @var ChannelManager
     */
    protected $channelManager;

    /**
     * CartStorage
     *
     * @var CartStorageInterface
     */
    protected $cartStorage;

    /**
     * Constructor
     *
     * @param CartStorageInterface $cartStorage
     * @param ChannelManager $channelManager
     */
    public function __construct(CartStorageInterface $cartStorage, ChannelManager $channelManager)
    {
        $this->cartStorage = $cartStorage;
        $this->channelManager = $channelManager;

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
            $quantity = $found->getQuantity() + $cartItem->getQuantity();
            $found->setQuantity($quantity);
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
        $this->cartStorage->save($this->cart);
    }

    /**
     * Clearing
     */
    public function clear()
    {
        $this->cartStorage->clear(
            $this->channelManager->getActiveChannel()
        );
    }

    /**
     * Initialize cart
     *
     * @return Cart
     */
    protected function initialize()
    {
        $channel = $this->channelManager->getActiveChannel();

        try {
            $cart = $this->cartStorage->load($channel);
        } catch (\Exception $e) {
            $cart = null;
        }

        if (!$cart instanceof Cart) {
            $cart = new Cart();
            $cart->setChannel($channel);
        }

        return $cart;
    }

    /**
     * Removing item
     *
     * @param string $id
     */
    public function removeItem($id)
    {
        foreach ($this->cart->getItems() as $item) {
            if ($item->getId() == $id) {
                $this->cart->getItems()->removeElement($item);
            }
        }
        $this->save();
    }

    /**
     * Changing item quantity
     *
     * @param string $id
     * @param int $quantity
     */
    public function changeCartItemQuantity($id, $quantity)
    {
        foreach ($this->cart->getItems() as $item) {
            if ($item->getId() == $id) {
                $item->setQuantity((int) $quantity);
            }
        }
        $this->save();
    }
}