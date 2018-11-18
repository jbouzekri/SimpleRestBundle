<?php

/**
 * @category Symfony_Bundle
 * @package  Jb\Bundle\SimpleRestBundle\Tests\Controller
 * @author   Jonathan Bouzekri <jonathan.bouzekri@gmail.com>
 * @license  MIT <https://github.com/jbouzekri/SimpleRestBundle/blob/master/LICENSE>
 * @link     https://github.com/jbouzekri/SimpleRestBundle
 */

namespace Jb\Bundle\SimpleRestBundle\Tests\Controller;

use Jb\Bundle\SimpleRestBundle\Exception\ConstraintViolationListHttpException;
use Jb\Bundle\SimpleRestBundle\Tests\Fixtures\AbstractTestCase;


class ZoneControllerTest extends AbstractTestCase
{
    public function setUp()
    {
        parent::setUp();
        $this->initClient(['environment' => 'testzones']);
    }

    public function testInZoneErrorAreFormatted()
    {
        $this->client->request(
            'POST',
            '/inzone',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json', 'HTTP_ACCEPT' => 'application/json'],
            json_encode([])
        );

        $this->assertEquals(
            400,
            $this->client->getResponse()->getStatusCode()
        );

        $this->assertEquals(
            json_encode([
                "message" => "contraint violation error",
                "code" => 400,
                "errors" => [
                    "key1" => "This field is missing."
                ]
            ]),
            $this->client->getResponse()->getContent()
        );
    }

    public function testInZoneBodyIsDecoded()
    {
        $this->client->request(
            'POST',
            '/inzone',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json', 'HTTP_ACCEPT' => 'application/json'],
            json_encode(['key1' => 'as a value'])
        );

        $this->assertEquals(
            200,
            $this->client->getResponse()->getStatusCode()
        );

        $this->assertEquals(
            'valid_body',
            $this->client->getResponse()->getContent()
        );
    }

    public function testOutsideZoneErrorAreNotFormatted()
    {
        $this->expectException(ConstraintViolationListHttpException::class);

        $this->client->request(
            'POST',
            '/outsidezone',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode([])
        );
    }

    public function testOutsideZoneBodyIsNotDecoded()
    {
        $this->expectException(ConstraintViolationListHttpException::class);

        $this->client->request(
            'POST',
            '/outsidezone',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode(['key1' => 'as a value'])
        );
    }
}