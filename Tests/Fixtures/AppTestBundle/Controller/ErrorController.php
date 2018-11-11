<?php

/**
 * @category Symfony_Bundle
 * @package  Jb\Bundle\SimpleRestBundle\Tests\Fixtures\AppTestBundle\Controller
 * @author   Jonathan Bouzekri <jonathan.bouzekri@gmail.com>
 * @license  MIT <https://github.com/jbouzekri/SimpleRestBundle/blob/master/LICENSE>
 * @link     https://github.com/jbouzekri/SimpleRestBundle
 */

namespace Jb\Bundle\SimpleRestBundle\Tests\Fixtures\AppTestBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


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
     * @return Response
     * @throws \Exception
     */
    public function raised500Exception()
    {
        throw new \Exception('unhandled exception');
    }
}
