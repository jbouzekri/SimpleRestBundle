<?php
/**
 * @category Symfony_Bundle
 * @package  Jb\Bundle\SimpleRestBundle\Annotation
 * @author   Jonathan Bouzekri <jonathan.bouzekri@gmail.com>
 * @license  MIT <https://github.com/jbouzekri/SimpleRestBundle/blob/master/LICENSE>
 * @link     https://github.com/jbouzekri/SimpleRestBundle
 */

namespace Jb\Bundle\SimpleRestBundle\Annotation;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\ConfigurationAnnotation;


/**
 * View annotation class.
 *
 * @Annotation
 */
class View extends ConfigurationAnnotation
{
    /**
     * @var array
     */
    protected $groups;

    /**
     * @param array $groups
     */
    public function setGroups($groups)
    {
        $this->groups = $groups;
    }
    /**
     * @return array
     */
    public function getGroups()
    {
        return $this->groups;
    }

    /**
     * Returns the alias name for an annotated configuration.
     *
     * @return string
     */
    public function getAliasName()
    {
        return 'simplerestview';
    }

    /**
     * Returns whether multiple annotations of this type are allowed.
     *
     * @return bool
     */
    public function allowArray()
    {
        return false;
    }
}