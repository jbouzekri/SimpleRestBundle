<?php

/**
 * @category Symfony_Bundle
 * @package  Jb\Bundle\SimpleRestBundle\Tests\Fixtures
 * @author   Jonathan Bouzekri <jonathan.bouzekri@gmail.com>
 * @license  MIT <https://github.com/jbouzekri/SimpleRestBundle/blob/master/LICENSE>
 * @link     https://github.com/jbouzekri/SimpleRestBundle
 *
 *
 * Copied from the EasyAdminBundle package.
 * (c) EasyCorp <https://github.com/EasyCorp//>
 * License https://github.com/EasyCorp/EasyAdminBundle/blob/master/LICENSE.md
 */

namespace Jb\Bundle\SimpleRestBundle\Tests\Fixtures;

use Symfony\Bundle\FrameworkBundle\Client;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Class AbstractTestCase.
 */
abstract class AbstractTestCase extends WebTestCase
{
    /** @var Client */
    protected $client;

    protected function setUp()
    {
        $this->initClient();
    }

    protected function initClient(array $options = [])
    {
        $this->client = static::createClient($options);
    }
}
