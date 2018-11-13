<?php

/**
 * @category Symfony_Bundle
 * @package  Jb\Bundle\SimpleRestBundle\Tests\Fixtures\AppTestBundle\Controller
 * @author   Jonathan Bouzekri <jonathan.bouzekri@gmail.com>
 * @license  MIT <https://github.com/jbouzekri/SimpleRestBundle/blob/master/LICENSE>
 * @link     https://github.com/jbouzekri/SimpleRestBundle
 */

namespace Jb\Bundle\SimpleRestBundle\Tests\Fixtures\AppTestBundle\Controller;

use Jb\Bundle\SimpleRestBundle\Exception\ConstraintViolationListHttpException;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validation;
use Symfony\Component\Validator\Constraints as Assert;


class ErrorController extends Controller
{
    /**
     * @Route("/error", methods={"POST"}, name="error_simple")
     *
     * @return Response
     */
    public function simple()
    {
        return new Response('error_simple');
    }

    /**
     * @Route("/error/500", methods={"POST"}, name="error_raised_500_exception")
     *
     * @throws \Exception
     */
    public function raised500Exception()
    {
        throw new \Exception('unhandled exception');
    }

    /**
     * @Route("/error/400", methods={"POST"}, name="error_raised_400_exception")
     *
     * @return Response
     * @throws \Exception
     */
    public function raised400Exception(Request $request)
    {
        $validator = Validation::createValidator();

        $constraints = new Assert\Collection([
            'key1' => [
                new Assert\NotBlank(),
            ],
            'key2' => [
                new Assert\Email(),
            ],
            'embed1' => new Assert\Collection([
                'embed_child1.1' => [
                    new Assert\Length(array('max' => 5)),
                ]
            ]),
            'embed2' => new Assert\Collection([
                'embed_child2.1' => [
                    new Assert\NotBlank(),
                ]
            ]),
            'list1' => [
                new Assert\Count(['min' => 2])
            ],
            'list2' => new Assert\All([
                new Assert\Collection([
                    'list_child2.1' => [
                        new Assert\Length(array('max' => 5)),
                    ],
                    'list_child2.2' => [
                        new Assert\NotBlank(),
                    ]
                ])
            ])
        ]);

        $violations = $validator->validate($request->request->all(), $constraints);

        if (0 !== count($violations)) {
            throw new ConstraintViolationListHttpException($violations);
        }

        return new Response('valid_body');
    }
}
