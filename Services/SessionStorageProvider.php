<?php
/*
 * This file is part of the Sergey Chernecov software.
 *
 * (c) 2014
 *
 * Do not care about any copyright or license.
 */

namespace Chernecov\Bundle\CartBundle\Services;

use Chernecov\Bundle\CartBundle\Interfaces\StorageProviderInterface;
use Symfony\Component\HttpFoundation\Session\Session;

/**
 * Session storage provider
 *
 * @author Sergey Chernecov <sergey.chernecov@gmail.com>
 */
class SessionStorageProvider implements StorageProviderInterface
{
    /**
     * Session
     *
     * @var Session
     */
    protected $session;

    /**
     * Constructor
     *
     * @param Session $session
     */
    public function __construct(Session $session)
    {
        $this->session = $session;
    }

    /**
     * {@inheritdoc}
     */
    public function save($key, $value)
    {
        $this->session->set($key, $value);
    }

    /**
     * {@inheritdoc}
     */
    public function load($key)
    {
        return $this->session->get($key);
    }
}