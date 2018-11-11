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
    private $message;

    /**
     * @var int
     */
    private $code;

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
     * @return int|null
     */
    public function getCode(): ?int
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
}