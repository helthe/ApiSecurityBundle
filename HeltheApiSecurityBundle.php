<?php

/*
 * This file is part of the HeltheApiSecurityBundle package.
 *
 * (c) Carl Alexander <carlalexander@helthe.co>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Helthe\Bundle\ApiSecurityBundle;

use Helthe\Bundle\ApiSecurityBundle\DependencyInjection\Security\Factory\ApiKeyFactory;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * ApiSecurityBundle
 *
 * @author Carl Alexander <carlalexander@helthe.co>
 */
class HeltheApiSecurityBundle extends Bundle
{
    /**
     * {@inheritdoc}
     */
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $extension = $container->getExtension('security');
        $extension->addSecurityListenerFactory(new ApiKeyFactory());
    }
}
