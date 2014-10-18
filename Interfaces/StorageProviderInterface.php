<?php
/*
 * This file is part of the Sergey Chernecov software.
 *
 * (c) 2014
 *
 * Do not care about any copyright or license.
 */

namespace Chernecov\Bundle\CartBundle\Interfaces;

/**
 * Storage provider interface
 *
 * @author Sergey Chernecov <sergey.chernecov@gmail.com>
 */
interface StorageProviderInterface
{
    /**
     * Save
     *
     * @param string $key
     * @param string $value
     *
     * @return void
     */
    public function save($key, $value);

    /**
     * Load
     *
     * @param string $key
     * @return mixed|null
     */
    public function load($key);
}