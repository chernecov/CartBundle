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

/**
 * Cart
 *
 * @author Sergey Chernecov <sergey.chernecov@gmail.com>
 */
class CartItem implements EmbeddedInterface
{
    use EmbeddedTrait;

    /**
     * @var int
     */
    protected $id;

    /**
     * @var string
     */
    protected $title;

    /**
     * @var float
     */
    protected $price;

    /**
     * @var int
     */
    protected $quantity;

    /**
     * @var int
     */
    protected $relatedId;

    /**
     * @var float
     */
    protected $total;

    /**
     * @var Cart
     */
    protected $Cart;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->id = UUID::generate();
    }

    /**
     * Cart setter
     *
     * @param Cart $Cart
     * @return self
     */
    public function setCart($Cart)
    {
        $this->Cart = $Cart;
        return $this;
    }

    /**
     * Cart getter
     *
     * @return Cart
     */
    public function getCart()
    {
        return $this->Cart;
    }

    /**
     * Quantity setter
     *
     * @param int $quantity
     * @return self
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;
        return $this;
    }

    /**
     * Quantity getter
     *
     * @return int
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * Id setter
     *
     * @param int $id
     * @return self
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * Id getter
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Price setter
     *
     * @param float $price
     * @return self
     */
    public function setPrice($price)
    {
        $this->price = $price;
        return $this;
    }

    /**
     * Price getter
     *
     * @return float
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * RelatedId setter
     *
     * @param int $relatedId
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
     * @return int
     */
    public function getRelatedId()
    {
        return $this->relatedId;
    }

    /**
     * Title setter
     *
     * @param string $title
     * @return self
     */
    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }

    /**
     * Title getter
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Total setter
     *
     * @param float $total
     * @return self
     */
    public function setTotal($total)
    {
        $this->total = $total;
        return $this;
    }

    /**
     * Total getter
     *
     * @return float
     */
    public function getTotal()
    {
        return $this->total;
    }

    /**
     * Think that would be better to serialize
     * cart item using some kind of Patchable annotation.
     * But for now: Let's just return array of patchable and postable
     * properties;
     *
     * @return array
     */
    static public function getSchema()
    {
        return array(
            'json' => array('title', 'price', 'quantity', 'relatedId')
        );
    }
}