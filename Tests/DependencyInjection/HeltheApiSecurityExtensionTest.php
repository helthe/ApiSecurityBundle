<?php

/*
 * This file is part of the HeltheTurbolinksBundle package.
 *
 * (c) Carl Alexander <carlalexander@helthe.co>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Helthe\Bundle\ApiSecurityBundle\Tests\DependencyInjection;

use Helthe\Bundle\ApiSecurityBundle\DependencyInjection\HeltheApiSecurityExtension;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class HeltheApiSecurityExtensionTest extends \PHPUnit_Framework_TestCase
{
    public function testLoadDefault()
    {
        $container = new ContainerBuilder();
        $loader = new HeltheApiSecurityExtension();
        $loader->load(array(array()), $container);

        // Authentication Provider
        $this->assertTrue($container->hasParameter('helthe_api_security.security.authentication.provider.class'));
        $this->assertEquals('Helthe\Component\Security\Api\Authentication\Provider\ApiKeyAuthenticationProvider', $container->getParameter('helthe_api_security.security.authentication.provider.class'));
        $this->assertTrue($container->hasDefinition('helthe_api_security.security.authentication.provider'));

        // Http Header Listener
        $this->assertTrue($container->hasParameter('helthe_api_security.security.authentication.listener.http_header.class'));
        $this->assertEquals('Helthe\Component\Security\Api\Firewall\HttpHeaderListener', $container->getParameter('helthe_api_security.security.authentication.listener.http_header.class'));
        $this->assertTrue($container->hasDefinition('helthe_api_security.security.authentication.listener.http_header'));

        // Query String Listener
        $this->assertTrue($container->hasParameter('helthe_api_security.security.authentication.listener.query_string.class'));
        $this->assertEquals('Helthe\Component\Security\Api\Firewall\QueryStringListener', $container->getParameter('helthe_api_security.security.authentication.listener.query_string.class'));
        $this->assertTrue($container->hasDefinition('helthe_api_security.security.authentication.listener.query_string'));
    }
}
