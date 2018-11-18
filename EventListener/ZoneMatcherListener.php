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
use Symfony\Component\HttpFoundation\RequestMatcherInterface;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;

/**
 * Matches simple rest's zones.
 *
 * @author Florian Voutzinos <florian@voutzinos.com>
 * copied from https://github.com/FriendsOfSymfony/FOSRestBundle/blob/master/EventListener/ZoneMatcherListener.php
 * License : https://github.com/FriendsOfSymfony/FOSRestBundle/blob/master/LICENSE
 */
class ZoneMatcherListener
{
    /**
     * @var RequestMatcherInterface[]
     */
    protected $requestMatchers = array();

    /**
     * Register a RequestMatcherInterface object
     *
     * @param RequestMatcherInterface $requestMatcher
     */
    public function addRequestMatcher(RequestMatcherInterface $requestMatcher)
    {
        $this->requestMatchers[] = $requestMatcher;
    }

    /**
     * Adds an optional "_jb_simple_rest_zone" request attribute to be checked for existence by other listeners.
     *
     * @param GetResponseEvent $event
     */
    public function onKernelRequest(GetResponseEvent $event)
    {
        $request = $event->getRequest();

        foreach ($this->requestMatchers as $requestMatcher) {
            if ($requestMatcher->matches($request)) {
                $request->attributes->set(JbSimpleRestBundle::ZONE_ATTRIBUTE, true);
                return;
            }
        }

        $request->attributes->set(JbSimpleRestBundle::ZONE_ATTRIBUTE, false);
    }
}