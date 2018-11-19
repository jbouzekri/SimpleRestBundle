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
use Symfony\Component\Routing\Annotation\Route;


class ViewController extends Controller
{
    /**
     * @Route("/view/empty", methods={"GET"}, name="view_empty")
     *
     * @return string
     */
    public function emptyResponse()
    {
        return '';
    }

    /**
     * @Route("/view/array", methods={"GET"}, name="view_array")
     *
     * @return array
     */
    public function arrayResponse()
    {
        return ['key' => 'value'];
    }

    /**
     * @Route("/inzone/view/empty", methods={"GET"}, name="view_empty_inzone")
     *
     * @return string
     */
    public function inZoneEmptyResponse()
    {
        return $this->emptyResponse();
    }

    /**
     * @Route("/inzone/view/array", methods={"GET"}, name="view_array_inzone")
     *
     * @return array
     */
    public function inZoneArrayResponse()
    {
        return $this->arrayResponse();
    }
}
