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
     * Channel manager
     *
     * @var ChannelManager
     */
    protected $channelManager;

    /**
     * Constructor
     *
     * @param StorageProviderInterface $storageProvider
     * @param ChannelManager $channelManager
     */
    public function __construct(
        StorageProviderInterface $storageProvider,
        ChannelManager $channelManager
    ) {
        $this->storageProvider = $storageProvider;
        $this->channelManager = $channelManager;
    }

    /**
     * {@inheritdoc}
     */
    public function clear($channel)
    {
        $this->storageProvider->clear($channel);
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function save(Cart $cart)
    {
        $channel = $cart->getChannel();
        if (!$this->channelManager->channelExists($channel)) {
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
        if (!$this->channelManager->channelExists($channel)) {
            return null;
        }
        try {
            $cart = unserialize(
                $this->storageProvider->load($channel)
            );
        } catch (\Exception $exception) {
            return null;
        }
        return $cart;
    }
}