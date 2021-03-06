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

use Jb\Bundle\SimpleRestBundle\Annotation\View;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\GetResponseForControllerResultEvent;
use Jb\Bundle\SimpleRestBundle\JbSimpleRestBundle;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

/**
 * class JsonViewListener
 *
 * transform controller returns to JsonResponse
 */
class JsonViewListener
{
    /**
     * @var NormalizerInterface
     */
    protected $normalizer;

    /**
     * JsonViewListener constructor.
     *
     * @param NormalizerInterface $normalizer
     */
    public function __construct(NormalizerInterface $normalizer)
    {
        $this->normalizer = $normalizer;
    }

    /**
     * @param GetResponseForControllerResultEvent $event
     */
    public function onKernelView(GetResponseForControllerResultEvent $event)
    {
        $request = $event->getRequest();

        // Not in this bundle zone, fallback default exception listener
        if (!$event->getRequest()->attributes->get(JbSimpleRestBundle::ZONE_ATTRIBUTE, false)) {
            return;
        }

        $context = [];

        /** @var View $configuration */
        $configuration = $request->attributes->get('_simplerestview');
        if ($configuration && $groups = $configuration->getGroups()) {
            $context['groups'] = $groups;
        }

        $value = $event->getControllerResult();

        $response = new JsonResponse(
            $this->normalizer->normalize($value, null, $context),
            $value === "" ? Response::HTTP_NO_CONTENT : Response::HTTP_OK
        );

        $event->setResponse($response);
    }
}