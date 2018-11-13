<?php
/**
 * @category Symfony_Bundle
 * @package  Jb\Bundle\SimpleRestBundle\Exception
 * @author   Jonathan Bouzekri <jonathan.bouzekri@gmail.com>
 * @license  MIT <https://github.com/jbouzekri/SimpleRestBundle/blob/master/LICENSE>
 * @link     https://github.com/jbouzekri/SimpleRestBundle
 */

namespace Jb\Bundle\SimpleRestBundle\Exception;

use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\PropertyAccess\PropertyAccess;

/**
 * Class ConstraintViolationListHttpException
 *
 * @package Jb\Bundle\SimpleRestBundle\Exception
 */
class ConstraintViolationListHttpException extends BadRequestHttpException
{
    /**
     * @var array
     */
    protected $errors = [];

    /**
     * ConstraintViolationListHttpException constructor.
     *
     * @param ConstraintViolationListInterface|null $errors
     * @param string $message
     * @param \Exception|null $previous
     * @param int $code
     * @param array $headers
     */
    public function __construct(
        ConstraintViolationListInterface $errors = null,
        $message = 'contraint violation error',
        \Exception $previous = null,
        $code = 0,
        array $headers = array()
    ) {
        parent::__construct(
            $message,
            $previous,
            $code,
            $headers
        );
        $this->setErrors($errors);
    }

    /**
     * Get the formatted errors
     *
     * @return array
     */
    public function getErrors()
    {
        return $this->errors;
    }

    /**
     * Format and set errors based on a ConstraintViolationList object
     *
     * @param ConstraintViolationListInterface|null $errors
     */
    public function setErrors(ConstraintViolationListInterface $errors = null)
    {
        if (!$errors) {
            return;
        }

        $propertyAccessor = PropertyAccess::createPropertyAccessor();

        /** @var \Symfony\Component\Validator\ConstraintViolation $error */
        foreach ($errors as $error) {
            $propertyAccessor->setValue($this->errors, $error->getPropertyPath(), $error->getMessage());
        }
    }
}