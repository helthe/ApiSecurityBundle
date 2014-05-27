<?php

/*
 * This file is part of the HeltheApiSecurityBundle package.
 *
 * (c) Carl Alexander <carlalexander@helthe.co>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Helthe\Bundle\ApiSecurityBundle\DependencyInjection\Security\Factory;

use Symfony\Bundle\SecurityBundle\DependencyInjection\Security\Factory\SecurityFactoryInterface;
use Symfony\Component\Config\Definition\Builder\NodeDefinition;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\DependencyInjection\DefinitionDecorator;

/**
 * ApiKeyFactory creates services for API key authentication.
 *
 * @author Carl Alexander <carlalexander@helthe.co>
 */
class ApiKeyFactory implements SecurityFactoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function create(ContainerBuilder $container, $id, $config, $userProvider, $defaultEntryPoint)
    {
        $providerId = 'helthe_api_security.security.authentication.provider.'. $id;
        $container
            ->setDefinition($providerId, new DefinitionDecorator('helthe_api_security.security.authentication.provider'))
            ->replaceArgument(0, new Reference($userProvider))
            ->replaceArgument(2, $id)
        ;

        $listenerId = 'helthe_api_security.security.authentication.listener.' . $config['method'] . '.' . $id;
        $listener = $container->setDefinition($listenerId, new DefinitionDecorator('helthe_api_security.security.authentication.listener.' . $config['method']));
        $listener->replaceArgument(2, $id);
        $listener->replaceArgument(3, $config['name']);

        return array($providerId, $listenerId, $defaultEntryPoint);
    }

    /**
     * {@inheritdoc}
     */
    public function getPosition()
    {
        return 'pre_auth';
    }

    /**
     * {@inheritdoc}
     */
    public function getKey()
    {
        return 'api_key';
    }

    /**
     * {@inheritdoc}
     */
    public function addConfiguration(NodeDefinition $node)
    {
        $node
            ->children()
                ->scalarNode('provider')->end()
                ->scalarNode('method')
                    ->defaultValue('http_header')
                    ->validate()
                        ->ifNotInArray(array('http_header', 'query_string'))
                        ->thenInvalid('The %s type is not supported')
                    ->end()
                ->end()
                ->scalarNode('name')->isRequired()->cannotBeEmpty()->end()
            ->end()
        ;
    }
}
