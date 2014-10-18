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
use Chernecov\Bundle\CartBundle\Interfaces\StorageProviderInterface;
use Chernecov\Bundle\CartBundle\Model\Cart;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Cart storage
 *
 * @author Sergey Chernecov <sergey.chernecov@gmail.com>
 */
class CartStorage implements CartStorageInterface
{
    /**
     * Storage provider
     *
     * @var StorageProviderInterface
     */
    protected $storageProvider;

    /**
     * Channels
     *
     * @var ArrayCollection
     */
    protected $channels;

    /**
     * Constructor
     */
    public function __construct(StorageProviderInterface $storageProvider)
    {
        $this->storageProvider = $storageProvider;
        $this->channels = new ArrayCollection();
    }

    /**
     * {@inheritdoc}
     */
    public function addChannel($channel = self::CHANNEL_DEFAULT)
    {
        if (!is_string($channel)) {
            return $this;
        }

        if ($this->channels->contains($channel)) {
            return $this;
        }

        $this->channels->add($channel);
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function save(Cart $cart, $channel)
    {
        if (!$this->channels->contains($channel)) {
            return false;
        }
        try {
            $this->storageProvider->save($channel, serialize($cart));
        } catch (\Exception $exception) {
            return false;
        }
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function load($channel)
    {
        if (!$this->channels->contains($channel)) {
            return null;
        }
        try {
            $cart = unserialize($this->storageProvider->load($channel));
        } catch (\Exception $exception) {
            return null;
        }
        return $cart;
    }
}