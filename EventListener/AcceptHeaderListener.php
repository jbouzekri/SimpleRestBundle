<?php
/**
 * @category Symfony_Bundle
 * @package  Jb\Bundle\SimpleRestBundle\EventListener
 * @author   Jonathan Bouzekri <jonathan.bouzekri@gmail.com>
 * @license  MIT <https://github.com/jbouzekri/SimpleRestBundle/blob/master/LICENSE>
 * @link     https://github.com/jbouzekri/SimpleRestBundle
 */

namespace Jb\Bundle\SimpleRestBundle\EventListener;

use Jb\Bundle\SimpleRestBundle\JbSimpleRestBundle;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

/**
 * Class AcceptHeaderListener
 *
 * @package Jb\Bundle\SimpleRestBundle\EventListener
 *
 * Check that the header Accept has been send with json to use APIs
 */
class AcceptHeaderListener
{
    /**
     * @param GetResponseEvent $event
     */
    public function onKernelRequest(GetResponseEvent $event)
    {
        $request = $event->getRequest();

        // Not in this bundle zone, don't force an Accept header value
        if (!$request->attributes->get(JbSimpleRestBundle::ZONE_ATTRIBUTE, false)) {
            return;
        }

        if (!in_array('application/json', $request->getAcceptableContentTypes())) {
            throw new BadRequestHttpException(
                'Client does not support json response. Set application/json in Accept header.'
            );
        }
    }
}