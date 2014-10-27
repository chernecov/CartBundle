<?php
/*
 * This file is part of the Sergey Chernecov software.
 *
 * (c) 2014
 *
 * Do not care about any copyright or license.
 */

namespace Chernecov\Bundle\CartBundle\Services;

use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Config\Definition\Exception\Exception;

/**
 * Channel manager
 *
 * @author Sergey Chernecov <sergey.chernecov@gmail.com>
 */
class ChannelManager
{
    const CHANNEL_DEFAULT = 'default';

    /**
     * Channels
     *
     * @var ArrayCollection
     */
    protected $channels;

    /**
     * Active channel
     *
     * @var string|null
     */
    protected $activeChannel = null;

    /**
     * Constructor
     *
     * @param array $channels
     * @throws Exception
     */
    public function __construct(array $channels = null)
    {
        if (!$channels) {
            $channels = array(self::CHANNEL_DEFAULT);
        }

        $valid = min(array_map('is_string', $channels));
        if (!$valid) {
            throw new Exception('Invalid array of channels given');
        }

        $this->channels = new ArrayCollection(array_values($channels));
        $this->activeChannel = $this->channels->first();
    }

    /**
     * Let's add channel
     *
     * @param string $channel
     *
     * @return $this
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
     * Let's add channel
     *
     * @param string $channel
     *
     * @return $this
     */
    public function removeChannel($channel)
    {
        if ($this->channels->contains($channel)) {
            $this->channels->removeElement($channel);
        }
        return $this;
    }

    /**
     * If channel exists
     *
     * @param $channel
     * @return bool
     */
    public function channelExists($channel)
    {
        return $this->channels->contains($channel) ? true : false;
    }

    /**
     * Channels getter
     *
     * @return ArrayCollection
     */
    public function getChannels()
    {
        return $this->channels;
    }

    /**
     * Let's get active channel
     *
     * @return string
     * @throws Exception
     */
    public function getActiveChannel()
    {
        if ($this->activeChannel === null) {
            if (!$this->channels->isEmpty()) {
                return $this->channels->first();
            } else {
                throw new Exception('You have no cart channel');
            }
        }
        return $this->activeChannel;
    }

    /**
     * Let's set active channel
     *
     * @param $channel
     * @return self
     */
    public function setActiveChannel($channel)
    {
        if ($this->channels->contains($channel)) {
            $this->activeChannel = $channel;
        }
        return $this;
    }
}