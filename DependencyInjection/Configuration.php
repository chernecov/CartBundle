<?php
/*
 * This file is part of the Sergey Chernecov software.
 *
 * (c) 2014
 *
 * Do not care about any copyright or license.
 */

namespace Chernecov\Bundle\CartBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder,
    Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * Cart configuration
 *
 * @author Sergey Chernecov <sergey.chernecov@intexsys.lv>
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('cart');

        // Here you should define the parameters that are allowed to
        // configure your bundle. See the documentation linked above for
        // more information on that topic.

        return $treeBuilder;
    }
}
