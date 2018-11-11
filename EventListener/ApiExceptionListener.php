<?php
/**
 * @category Symfony_Bundle
 * @package  Jb\Bundle\SimpleRestBundle\EventListener
 * @author   Jonathan Bouzekri <jonathan.bouzekri@gmail.com>
 * @license  MIT <https://github.com/jbouzekri/SimpleRestBundle/blob/master/LICENSE>
 * @link     https://github.com/jbouzekri/SimpleRestBundle
 */

namespace Jb\Bundle\SimpleRestBundle\EventListener;

use Jb\Bundle\SimpleRestBundle\Model\ApiError;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

/**
 * Handle Kernel exceptions by returning a proper API response
 */
class ApiExceptionListener
{

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @var NormalizerInterface
     */
    private $normalizer;

    /**
     * ApiExceptionListener constructor.
     *
     * @param LoggerInterface $logger
     * @param NormalizerInterface $normalizer
     */
    public function __construct(LoggerInterface $logger, NormalizerInterface $normalizer)
    {
        $this->logger = $logger;
        $this->normalizer = $normalizer;
    }

    /**
     * @param GetResponseForExceptionEvent $event
     */
    public function onKernelException(GetResponseForExceptionEvent $event)
    {
        $exception = $event->getException();

        $error = new ApiError();

        switch (true) {
            case $exception instanceof HttpException:
                $error->setMessage($exception->getMessage());
                $error->setCode($exception->getStatusCode());
                break;

            default:
                $error->setMessage('The application has encountered an unhandled error.');
                $error->setCode(Response::HTTP_INTERNAL_SERVER_ERROR);
                break;
        }


        $errorData = $this->normalizer->normalize($error);

        $response = new JsonResponse();
        $response->setData($errorData);
        $response->setStatusCode($error->getCode());

        $event->setResponse($response);
        $event->allowCustomResponseCode();
    }
}