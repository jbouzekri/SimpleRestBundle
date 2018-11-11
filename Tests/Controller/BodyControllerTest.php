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
 * Class BodyControllerTest
 *
 * @package Jb\Bundle\SimpleRestBundle\Tests\Controller
 */
class BodyControllerTest extends AbstractTestCase
{
    public function testPostEmptyBodyNotJson()
    {
        $this->client->request(
            'POST',
            '/body/is-json'
        );

        $this->assertEquals(
            200,
            $this->client->getResponse()->getStatusCode()
        );

        $this->assertEquals(
            'body_not_json',
            $this->client->getResponse()->getContent()
        );
    }

    public function testPostBodyNotJson()
    {
        $this->client->request(
            'POST',
            '/body/is-json',
            [],
            [],
            ['CONTENT_TYPE' => 'text/xml'],
            '<simple-xml-string>A simple XML string</simple-xml-string>'
        );

        $this->assertEquals(
            200,
            $this->client->getResponse()->getStatusCode()
        );

        $this->assertEquals(
            'body_not_json',
            $this->client->getResponse()->getContent()
        );
    }

    public function testPostBodyIsJson()
    {
        $this->client->request(
            'POST',
            '/body/is-json',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            '{"key": "value"}'
        );

        $this->assertEquals(
            200,
            $this->client->getResponse()->getStatusCode()
        );

        $this->assertEquals(
            'body_is_json',
            $this->client->getResponse()->getContent()
        );
    }
}
