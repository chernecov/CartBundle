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
    /**
     * @param $channel
     * @return mixed
     */
    public function clear($channel);

    /**
     * Let's save cart for channel
     *
     * @param Cart $cart
     *
     * @return bool
     */
    public function save(Cart $cart);

    /**
     * Let's load the cart from channel
     *
     * @param string $channel
     *
     * @return Cart|null
     */
    public function load($channel);
}