<?php

namespace Seven\RpcBundle\Rpc\Transport;

/**
 * Interface for http request from RPC client.
 * RPC method call is much more simple compared to standard http request (no cookies, no url fragment etc. is needed)
 * therefore provided method are simple and only needed.
 * Naming convention: https://en.wikipedia.org/wiki/URL#/media/File:URI_syntax_diagram.png
 */
interface RequestInterface
{
    /**
     * Get scheme (http or https) together with host and port number (if port is not default)
     * @return string
     */
    public function getSchemeAndHttpHost();

    /**
     * Get path together with query (if present), fragment is dropped.
     * @return string
     */
    public function getRequestUri();

    /**
     * Get userinfo - it is username and password (if present)
     * @return string
     */
    public function getUserInfo();

    /**
     * Get request content.
     * @return string
     */
    public function getContent();

    /**
     * Get request content-type.
     * @return string|null
     */
    public function getContentType();

    /**
     * Set full uri that is parsed into parts.
     * @param string $uri
     */
    public function setFullUri($uri);
}
