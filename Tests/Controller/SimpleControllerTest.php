<?php

/**
 * @category Symfony_Bundle
 * @package  Jb\Bundle\SimpleRestBundle\Tests\Controller
 * @author   Jonathan Bouzekri <jonathan.bouzekri@gmail.com>
 * @license  MIT <https://github.com/jbouzekri/SimpleRestBundle/blob/master/LICENSE>
 * @link     https://github.com/jbouzekri/SimpleRestBundle
 */

namespace Jb\Bundle\SimpleRestBundle\Tests\Controller;

use Jb\Bundle\SimpleRestBundle\Tests\Fixtures\AbstractTestCase;

/**
 * Class SimpleControllerTest
 *
 * @package Jb\Bundle\SimpleRestBundle\Tests\Controller
 */
class SimpleControllerTest extends AbstractTestCase
{
    public function setUp()
    {
        parent::setUp();
        //$this->initClient(['environment' => 'action_override']);
    }

    public function testInit()
    {
        $this->client->request('GET', '/simple');

        $this->assertEquals(
            200,
            $this->client->getResponse()->getStatusCode()
        );

        $this->assertEquals(
            'simple_response',
            $this->client->getResponse()->getContent()
        );
    }
}
