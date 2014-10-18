<?php
/*
 * This file is part of the Sergey Chernecov software.
 *
 * (c) 2014
 *
 * Do not care about any copyright or license.
 */

namespace Chernecov\Bundle\CartBundle\Interfaces;

use Chernecov\Bundle\CartBundle\Model\Cart;

/**
 * Cart storage interface
 *
 * @author Sergey Chernecov <sergey.chernecov@gmail.com>
 */
interface CartStorageInterface
{
    const CHANNEL_DEFAULT = 'SHOPPING_CART';

    /**
     * Let's add channel
     *
     * @param string $channel
     * @return self
     */
    public function addChannel($channel);

    /**
     * Let's save cart for channel
     *
     * @param Cart $cart
     * @param string $channel
     *
     * @return bool
     */
    public function save(Cart $cart, $channel);

    /**
     * Let's load the cart from channel
     *
     * @param string $channel
     *
     * @return Cart|null
     */
    public function load($channel);
}