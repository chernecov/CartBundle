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
     * Identifier
     *
     * @var int
     */
    protected $id;

    /**
     * Session Id
     *
     * @var int
     */
    protected $sessionId;

    /**
     * Related Id
     *
     * @var int
     */
    protected $relatedId;

    /**
     * Items
     *
     * @var ArrayCollection|CartItem[]
     */
    protected $items;

    /**
     * Channel
     *
     * @var string
     */
    protected $channel;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->id = UUID::generate();
        $this->items = new ArrayCollection();
    }

    /**
     * Cart id setter
     *
     * @param mixed $id
     * @return self
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * Cart id getter
     *
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Adding cart item
     *
     * @param CartItem $cartItem
     * @return $this
     */
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

    /**
     * Channel setter
     *
     * @param string $channel
     * @return self
     */
    public function setChannel($channel)
    {
        $this->channel = $channel;
        return $this;
    }

    /**
     * Channel getter
     *
     * @return string
     */
    public function getChannel()
    {
        return $this->channel;
    }
}