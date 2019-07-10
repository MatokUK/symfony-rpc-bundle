<?php

/*
 * This file is part of the Symfony bundle Seven/Rpc.
 *
 * (c) Sergey Kolodyazhnyy <sergey.kolodyazhnyy@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 */

namespace Seven\RpcBundle\Exception;

use Exception;
use Symfony\Component\HttpFoundation\Response;

class RpcException extends Exception
{
    /**
     * @var string
     */
    private $data;
    /**
     * @var bool
     */
    private $loggable = true;

    /**
     * @var int
     */
    private $httpStatusCode;


    /**
     * Throw a new exception.
     *
     * @param string $message Error message
     * @param int $code Error code (default = 0)
     * @param int $httpStatusCode HTTP status code to send
     */
    public function __construct($message, $code = 0, $httpStatusCode = Response::HTTP_BAD_REQUEST)
    {
        parent::__construct($message, $code);
        $this->httpStatusCode = $httpStatusCode;
    }

    /**
     * Set additional information about the error.
     *
     * @param mixed $data
     */
    public function setData($data)
    {
        $this->data = $data;
    }

    /**
     * Get additional information about the error.
     *
     * @return mixed
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * Get response http status code
     *
     * @return int
     */
    public function getHttpStatusCode()
    {
        return $this->httpStatusCode;
    }

    /**
     * Set response http status code
     *
     * @param int $httpStatusCode
     */
    public function setHttpStatusCode($httpStatusCode)
    {
        $this->httpStatusCode = $httpStatusCode;
    }

    /**
     * @return bool
     */
    public function isLoggable()
    {
        return $this->loggable;
    }

    /**
     * @param bool $loggable
     */
    public function setLoggable($loggable)
    {
        $this->loggable = $loggable;
    }
}
