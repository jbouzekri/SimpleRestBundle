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
 * Class ErrorControllerTest
 *
 * @package Jb\Bundle\SimpleRestBundle\Tests\Controller
 */
class ErrorControllerTest extends AbstractTestCase
{
    public function testPostBodyInvalidJson()
    {
        $this->client->request(
            'POST',
            '/error',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            '{"key": "value"'
        );

        $this->assertEquals(
            400,
            $this->client->getResponse()->getStatusCode()
        );

        $this->assertEquals(
            '{"message":"invalid json body: Syntax error","code":400}',
            $this->client->getResponse()->getContent()
        );
    }

    public function testException500()
    {
        $this->client->request(
            'POST',
            '/error/500'
        );

        $this->assertEquals(
            500,
            $this->client->getResponse()->getStatusCode()
        );

        $this->assertEquals(
            '{"message":"The application has encountered an unhandled error.","code":500}',
            $this->client->getResponse()->getContent()
        );
    }
}
