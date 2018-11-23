<?php

/**
 * @category Symfony_Bundle
 * @package  Jb\Bundle\SimpleRestBundle\Tests\Fixtures\AppTestBundle\Entity
 * @author   Jonathan Bouzekri <jonathan.bouzekri@gmail.com>
 * @license  MIT <https://github.com/jbouzekri/SimpleRestBundle/blob/master/LICENSE>
 * @link     https://github.com/jbouzekri/SimpleRestBundle
 */

namespace AppTestBundle\Entity;

use Symfony\Component\Serializer\Annotation\Groups;


class TestObj
{
    /**
     * @Groups({"group1", "group2"})
     *
     * @var string|null
     */
    public $foo;

    /**
     * @var string|null
     */
    private $bar;

    /**
     * @Groups({"group3"})
     *
     * @var string
     */
    public $baz = 'baz1';

    /**
     * TestObj constructor.
     *
     * @param string|null $foo
     * @param string|null $bar
     */
    public function __construct($foo = null, $bar = null)
    {
        $this->foo = $foo;
        $this->bar = $bar;
    }

    /**
     * @Groups("group2")
     *
     * @return string|null
     */
    public function getBar()
    {
        return $this->bar;
    }
}