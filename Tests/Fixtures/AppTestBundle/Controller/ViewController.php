<?php

/**
 * @category Symfony_Bundle
 * @package  Jb\Bundle\SimpleRestBundle\Tests\Fixtures\AppTestBundle\Controller
 * @author   Jonathan Bouzekri <jonathan.bouzekri@gmail.com>
 * @license  MIT <https://github.com/jbouzekri/SimpleRestBundle/blob/master/LICENSE>
 * @link     https://github.com/jbouzekri/SimpleRestBundle
 */

namespace Jb\Bundle\SimpleRestBundle\Tests\Fixtures\AppTestBundle\Controller;

use AppTestBundle\Entity\TestObj;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Jb\Bundle\SimpleRestBundle\Annotation as SimpleRest;


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

    /**
     * @Route("/inzone/view-annotated/obj-nogroup", methods={"GET"}, name="view_obj_inzone_annotated_nogroup")
     * @SimpleRest\View
     *
     * @return TestObj
     */
    public function inZoneAnnotatedObjResponseNoGroup()
    {
        return new TestObj('foo1', 'bar1');
    }

    /**
     * @Route("/inzone/view-annotated/obj-group1", methods={"GET"}, name="view_obj_inzone_annotated_group1")
     * @SimpleRest\View(groups={"group1"})
     *
     * @return TestObj
     */
    public function inZoneAnnotatedObjResponseGroup1()
    {
        return new TestObj('foo1', 'bar1');
    }

    /**
     * @Route("/inzone/view-annotated/obj-group2", methods={"GET"}, name="view_obj_inzone_annotated_group2")
     * @SimpleRest\View(groups={"group2"})
     *
     * @return TestObj
     */
    public function inZoneAnnotatedObjResponseGroup2()
    {
        return new TestObj('foo1', 'bar1');
    }

    /**
     * @Route("/inzone/view-annotated/obj-group13", methods={"GET"}, name="view_obj_inzone_annotated_group13")
     * @SimpleRest\View(groups={"group1", "group3"})
     *
     * @return TestObj
     */
    public function inZoneAnnotatedObjResponseGroup13()
    {
        return new TestObj('foo1', 'bar1');
    }
}
