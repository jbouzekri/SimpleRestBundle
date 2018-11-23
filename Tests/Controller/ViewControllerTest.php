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


class ViewControllerTest extends AbstractTestCase
{
    public function setUp()
    {
        parent::setUp();
        $this->initClient(['environment' => 'testzones']);
    }

    public function testInZoneEmptyResponseView()
    {
        $this->client->request(
            'GET',
            '/inzone/view/empty',
            [],
            [],
            ['HTTP_ACCEPT' => 'application/json']
        );

        $this->assertEquals(
            204,
            $this->client->getResponse()->getStatusCode()
        );

        $this->assertEquals(
            '',
            $this->client->getResponse()->getContent()
        );
    }

    public function testInZoneArrayResponseView()
    {
        $this->client->request(
            'GET',
            '/inzone/view/array',
            [],
            [],
            ['HTTP_ACCEPT' => 'application/json']
        );

        $this->assertEquals(
            200,
            $this->client->getResponse()->getStatusCode()
        );

        $this->assertEquals(
            json_encode(['key' => 'value']),
            $this->client->getResponse()->getContent()
        );
    }

    public function testOutsideZoneEmptyResponseView()
    {
        $this->expectException(\LogicException::class);

        $this->client->request(
            'GET',
            '/view/empty',
            [],
            [],
            ['HTTP_ACCEPT' => 'application/json']
        );
    }

    public function testOutsideZoneArrayResponseView()
    {
        $this->expectException(\LogicException::class);

        $this->client->request(
            'GET',
            '/view/array',
            [],
            [],
            ['HTTP_ACCEPT' => 'application/json']
        );
    }

    public function testInZoneAnnotatedObjResponseNoGroupView()
    {
        $this->client->request(
            'GET',
            '/inzone/view-annotated/obj-nogroup',
            [],
            [],
            ['HTTP_ACCEPT' => 'application/json']
        );

        $this->assertEquals(
            200,
            $this->client->getResponse()->getStatusCode()
        );

        $this->assertEquals(
            json_encode(['bar' => 'bar1', 'foo' => 'foo1', 'baz' => 'baz1']),
            $this->client->getResponse()->getContent()
        );
    }

    public function testInZoneAnnotatedObjResponseGroup1View()
    {
        $this->client->request(
            'GET',
            '/inzone/view-annotated/obj-group1',
            [],
            [],
            ['HTTP_ACCEPT' => 'application/json']
        );

        $this->assertEquals(
            200,
            $this->client->getResponse()->getStatusCode()
        );

        $this->assertEquals(
            json_encode(['foo' => 'foo1']),
            $this->client->getResponse()->getContent()
        );
    }

    public function testInZoneAnnotatedObjResponseGroup2View()
    {
        $this->client->request(
            'GET',
            '/inzone/view-annotated/obj-group2',
            [],
            [],
            ['HTTP_ACCEPT' => 'application/json']
        );

        $this->assertEquals(
            200,
            $this->client->getResponse()->getStatusCode()
        );

        $this->assertEquals(
            json_encode(['foo' => 'foo1', 'bar' => 'bar1']),
            $this->client->getResponse()->getContent()
        );
    }

    public function testInZoneAnnotatedObjResponseGroup13View()
    {
        $this->client->request(
            'GET',
            '/inzone/view-annotated/obj-group13',
            [],
            [],
            ['HTTP_ACCEPT' => 'application/json']
        );

        $this->assertEquals(
            200,
            $this->client->getResponse()->getStatusCode()
        );

        $this->assertEquals(
            json_encode(['foo' => 'foo1', 'baz' => 'baz1']),
            $this->client->getResponse()->getContent()
        );
    }
}