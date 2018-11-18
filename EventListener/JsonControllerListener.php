<?php
/**
 * @category Symfony_Bundle
 * @package  Jb\Bundle\SimpleRestBundle\EventListener
 * @author   Jonathan Bouzekri <jonathan.bouzekri@gmail.com>
 * @license  MIT <https://github.com/jbouzekri/SimpleRestBundle/blob/master/LICENSE>
 * @link     https://github.com/jbouzekri/SimpleRestBundle
 *
 *
 * Inspired by Peter Lafferty post on:
 * https://medium.com/@peter.lafferty/converting-a-json-post-in-symfony-13a24c98fc0e
 */

namespace Jb\Bundle\SimpleRestBundle\EventListener;

use function json_last_error;
use function json_last_error_msg;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Jb\Bundle\SimpleRestBundle\JbSimpleRestBundle;

/**
 * class JsonControllerListener
 *
 * On Kernel controller event, if content type is json, it decodes the body of the request
 * and replace the request string with the decoded body
 */
class JsonControllerListener
{
    public function onKernelController(FilterControllerEvent $event)
    {

        $request = $event->getRequest();

        // Not in this bundle zone, fallback default exception listener
        if (!$request->attributes->get(JbSimpleRestBundle::ZONE_ATTRIBUTE, false)) {
            return;
        }

        if ($request->getContentType() != 'json' || !$request->getContent()) {
            return;
        }

        $data = json_decode($request->getContent(), true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new BadRequestHttpException('invalid json body: ' . json_last_error_msg());
        }

        $request->request->replace(is_array($data) ? $data : array());
    }
}