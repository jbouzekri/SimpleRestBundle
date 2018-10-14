<?php

/**
 * @category Symfony_Bundle
 * @package  Jb\Bundle\SimpleRestBundle\Tests
 * @author   Jonathan Bouzekri <jonathan.bouzekri@gmail.com>
 * @license  MIT <https://github.com/jbouzekri/SimpleRestBundle/blob/master/LICENSE>
 * @link     https://github.com/jbouzekri/SimpleRestBundle
 *
 *
 * Copied from the EasyAdminBundle package.
 * (c) EasyCorp <https://github.com/EasyCorp//>
 * License https://github.com/EasyCorp/EasyAdminBundle/blob/master/LICENSE.md
 */

$file = __DIR__.'/../vendor/autoload.php';
if (!file_exists($file)) {
    throw new RuntimeException('Install dependencies using Composer to run the test suite.');
}

include __DIR__.'/Fixtures/App/AppKernel.php';
