<?php

namespace Seven\RpcBundle\Rpc\Transport;

class Request implements RequestInterface
{
    /** @var string */
    private $scheme = 'http';

    /** @var int */
    private $port = 80;

    /** @var string */
    private $host;

    /** @var string */
    private $path;

    /** @var string */
    private $query;

    /** @var string */
    private $user;

    /** @var string */
    private $password;

    /** @var string */
    private $contentType;

    /** @var string */
    private $content;

    /**
     * @param string $content
     * @param string $contentType
     */
    public function __construct($content, $contentType = null)
    {
        $this->content = $content;
        $this->contentType = $contentType;
    }

    public function setFullUri($uri)
    {
        $components = parse_url($uri);

        if (isset($components['host'])) {
            $this->host = $components['host'];
        }

        if (isset($components['scheme'])) {
            if ('https' === $components['scheme']) {
                $this->scheme = 'https';
                $this->port = 443;
            } else {
                $this->scheme = 'http';
                $this->port = 80;
            }
        }

        if (!isset($components['path'])) {
            $components['path'] = '/';
        }

        if (isset($components['port'])) {
            $this->port = $components['port'];
        }

        $this->path = $components['path'];

        if (isset($components['query'])) {
            $this->query = $components['query'];
        }

        if (isset($components['user'])) {
            $this->user = $components['user'];
        }

        if (isset($components['pass'])) {
            $this->password = $components['pass'];
        }
    }

    public function setPort($port)
    {
        $this->port = $port;
    }

    /**
     * @param string $scheme
     */
    public function setScheme($scheme)
    {
        $this->scheme = $scheme;
    }

    /**
     * @param string $host
     */
    public function setHost($host)
    {
        $this->host = $host;
    }

    /**
     * @param string $user
     * @param string $password
     */
    public function setCredentials($user, $password = '')
    {
        $this->user = $user;
        $this->password = $password;
    }

    /**
     * @param string $contentType
     */
    public function setContentType($contentType)
    {
        $this->contentType = $contentType;
    }

    /**
     * @return string
     */
    public function getSchemeAndHttpHost()
    {
        return $this->getScheme().'://'.$this->getHttpHost();
    }

    private function getScheme()
    {
        return $this->scheme;
    }

    public function getHttpHost()
    {
        $scheme = $this->getScheme();
        $port = $this->getPort();
        if (('http' == $scheme && 80 == $port) || ('https' == $scheme && 443 == $port)) {
            return $this->getHost();
        }
        return $this->getHost().':'.$port;
    }

    private function getPort()
    {
        return $this->port;
    }

    private function getHost()
    {
        return $this->host;
    }

    /**
     * @return string
     */
    public function getRequestUri()
    {
        if (empty($this->query)) {
            return $this->path;
        }

        return $this->path.'?'.$this->query;
    }

    /**
     * @return string
     */
    public function getUserInfo()
    {
        $userinfo = $this->getUser();
        $pass = $this->getPassword();
        if ('' != $pass) {
            $userinfo .= ":$pass";
        }
        return $userinfo;
    }

    private function getUser()
    {
        return $this->user;
    }

    private function getPassword()
    {
        return $this->password;
    }

    /**
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @return string|null
     */
    public function getContentType()
    {
        return empty($this->contentType) ? null : $this->contentType;
    }
}