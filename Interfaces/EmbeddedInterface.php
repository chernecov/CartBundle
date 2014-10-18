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
 * Embedded interface
 *
 * @author Sergey Chernecov <sergey.chernecov@gmail.com>
 */
interface EmbeddedInterface
{
    /**
     * Show embedded setter
     *
     * @param boolean $showEmbedded
     *
     * @return self
     */
    public function setShowEmbedded($showEmbedded);

    /**
     * Show embedded?
     *
     * @return boolean
     */
    public function showEmbedded();
}