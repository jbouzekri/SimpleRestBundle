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


class ZoneController extends Controller
{
    /**
     * @Route("/inzone", methods={"POST"}, name="inzone")
     *
     * @return Response
     */
    public function inZone(Request $request)
    {
        $validator = Validation::createValidator();

        $constraints = new Assert\Collection([
            'key1' => [
                new Assert\NotBlank(),
            ]
        ]);

        $violations = $validator->validate($request->request->all(), $constraints);

        if (0 !== count($violations)) {
            throw new ConstraintViolationListHttpException($violations);
        }

        return new Response('valid_body');
    }

    /**
     * @Route("/outsidezone", methods={"POST"}, name="outsidezone")
     *
     * @param Request $request
     * @return Response
     */
    public function outsideZone(Request $request)
    {
        return $this->inZone($request);
    }
}
