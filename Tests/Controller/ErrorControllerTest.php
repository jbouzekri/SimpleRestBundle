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
            '{"message":"invalid json body: Syntax error","code":400,"errors":[]}',
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
            json_encode([
                "message" => "The application has encountered an unhandled error",
                "code" => 500,
                "errors" => []
            ]),
            $this->client->getResponse()->getContent()
        );
    }

    public function testException400AllConstraintFailed()
    {
        $this->client->request(
            'POST',
            '/error/400',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode([
                "key2" => "not_an_email",
                "embed1" => [
                    "embed_child1.1" => "value_too_long"
                ],
                "list1" => ["oneitem"],
                "list2" => [
                    [
                        "list_child2.1" => "anothervalue_too_long",
                        "list_child2.2" => "is_here"
                    ],
                    [
                        "list_child2.1" => "short"
                    ]
                ]
            ])
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
                    "key1" => "This field is missing.",
                    "key2" => "This value is not a valid email address.",
                    "embed1" => [
                        "embed_child1.1" => "This value is too long. It should have 5 characters or less."
                    ],
                    "embed2" => "This field is missing.",
                    "list1" => "This collection should contain 2 elements or more.",
                    "list2" => [
                        [
                            "list_child2.1" => "This value is too long. It should have 5 characters or less."
                        ],
                        [
                            "list_child2.2" => "This field is missing."
                        ]
                    ]
                ]
            ]),
            $this->client->getResponse()->getContent()
        );
    }

    public function testException400NoConstraintFailed()
    {
        $this->client->request(
            'POST',
            '/error/400',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode([
                "key1" => "not_blank",
                "key2" => "test@gmail.com",
                "embed1" => [
                    "embed_child1.1" => "short"
                ],
                "embed2" => [
                    "embed_child2.1" => "not_blank"
                ],
                "list1" => ["oneitem", "twoitem"],
                "list2" => [
                    [
                        "list_child2.1" => "short",
                        "list_child2.2" => "is_here"
                    ],
                    [
                        "list_child2.1" => "min",
                        "list_child2.2" => "is_here"
                    ]
                ]
            ])
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
}
