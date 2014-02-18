<?php

/*
 * This file is part of the HeltheApiSecurityBundle package.
 *
 * (c) Carl Alexander <carlalexander@helthe.co>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Helthe\Bundle\ApiSecurityBundle\Tests\DependencyInjection\Security\Factory;

use Helthe\Bundle\ApiSecurityBundle\DependencyInjection\Security\Factory\ApiKeyFactory;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class ApiKeyFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testCreate()
    {
        $container = new ContainerBuilder();
        $factory = new ApiKeyFactory();

        $result = $factory->create($container, 'foo', array('name'=> 'api-key', 'method' => 'http_header'), 'user_provider', 'entry_point');
        $this->assertEquals(array(
            'helthe_api_security.security.authentication.provider.foo',
            'helthe_api_security.security.authentication.listener.http_header.foo',
            'entry_point'
        ), $result);

        $this->assertTrue($container->hasDefinition('helthe_api_security.security.authentication.provider.foo'));
        $this->assertTrue($container->hasDefinition('helthe_api_security.security.authentication.listener.http_header.foo'));

        $providerDefintion = $container->getDefinition('helthe_api_security.security.authentication.provider.foo');
        $this->assertEquals(array('index_0' => new Reference('user_provider'), 'index_2' => 'foo'), $providerDefintion->getArguments());

        $listenerDefintion = $container->getDefinition('helthe_api_security.security.authentication.listener.http_header.foo');
        $this->assertEquals(array('index_2' => 'foo', 'index_3' => 'api-key'), $listenerDefintion->getArguments());
    }

    public function testGetPosition()
    {
        $factory = new ApiKeyFactory();

        $this->assertEquals('pre_auth', $factory->getPosition());
    }

    public function testGetKey()
    {
        $factory = new ApiKeyFactory();

        $this->assertEquals('api_key', $factory->getKey());
    }
}
