<?php
/*
 * This file is part of the Sergey Chernecov software.
 *
 * (c) 2014
 *
 * Do not care about any copyright or license.
 */

namespace Chernecov\Bundle\CartBundle\Model;

use Chernecov\Bundle\CartBundle\Interfaces\EmbeddedInterface,
    Chernecov\Bundle\CartBundle\Services\UUID,
    Chernecov\Bundle\CartBundle\Traits\EmbeddedTrait;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * Cart
 *
 * @author Sergey Chernecov <sergey.chernecov@gmail.com>
 */
class Cart implements EmbeddedInterface
{
    use EmbeddedTrait;

    /**
     * @var int
     */
    protected $cartId;

    /**
     * @var int
     */
    protected $sessionId;

    /**
     * @var int
     */
    protected $relatedId;

    /**
     * @var ArrayCollection|CartItem[]
     */
    protected $items;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->cartId = UUID::generate();
        $this->items = new ArrayCollection();
    }

    /**
     * CartId setter
     *
     * @param mixed $cartId
     * @return self
     */
    public function setCartId($cartId)
    {
        $this->cartId = $cartId;
        return $this;
    }

    /**
     * CartId getter
     *
     * @return mixed
     */
    public function getCartId()
    {
        return $this->cartId;
    }

    public function addItem(CartItem $cartItem)
    {
        $this->items->add($cartItem);
        $cartItem->setCart($this);
        return $this;
    }

    /**
     * Items getter
     *
     * @return ArrayCollection|CartItem[]
     */
    public function getItems()
    {
        return $this->items;
    }

    /**
     * Clear item
     *
     * @return self
     */
    public function clear()
    {
        foreach ($this->items as $item) {
            $this->items->removeElement($item);
        }
        return $this;
    }


    /**
     * RelatedId setter
     *
     * @param mixed $relatedId
     * @return self
     */
    public function setRelatedId($relatedId)
    {
        $this->relatedId = $relatedId;
        return $this;
    }

    /**
     * RelatedId getter
     *
     * @return mixed
     */
    public function getRelatedId()
    {
        return $this->relatedId;
    }

    /**
     * SessionId setter
     *
     * @param mixed $sessionId
     * @return self
     */
    public function setSessionId($sessionId)
    {
        $this->sessionId = $sessionId;
        return $this;
    }

    /**
     * SessionId getter
     *
     * @return mixed
     */
    public function getSessionId()
    {
        return $this->sessionId;
    }
}