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
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class BodyController extends Controller
{
    /**
     * @Route("/body/is-json", methods={"POST"}, name="body_is_json")
     *
     * @return Response
     */
    public function isJson(Request $request)
    {
        $result = json_decode($request->getContent(), true);
        $isJson = $request->request->all() === $result;
        return new Response($isJson ? 'body_is_json' : 'body_not_json');
    }
}
