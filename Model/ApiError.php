<?php
/**
 * Created by PhpStorm.
 * User: jobou
 * Date: 11/11/18
 * Time: 18:49
 */

namespace Jb\Bundle\SimpleRestBundle\Model;

/**
 * ApiError Model
 */
class ApiError
{
    /**
     * @var string
     */
    protected $message;

    /**
     * @var int
     */
    protected $code;

    /**
     * @var array
     */
    protected $errors = [];

    /**
     * @return string|null
     */
    public function getMessage(): ?string
    {
        return $this->message;
    }

    /**
     * @param string|null $message
     */
    public function setMessage(string $message = null)
    {
        $this->message = $message;
    }

    /**
     * @return int
     */
    public function getCode(): int
    {
        return $this->code;
    }

    /**
     * @param int|null $code
     */
    public function setCode(int $code = null)
    {
        $this->code = $code;
    }

    /**
     * @return array
     */
    public function getErrors(): array
    {
        return $this->errors;
    }

    /**
     * @param array $errors
     */
    public function setErrors(array $errors = [])
    {
        $this->errors = $errors;
    }
}
