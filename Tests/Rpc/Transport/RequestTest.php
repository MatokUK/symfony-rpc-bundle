<?php

namespace Seven\RpcBundle\Tests\Transport;

use PHPUnit\Framework\TestCase;
use Seven\RpcBundle\Rpc\Transport\Request;
use Symfony\Component\HttpFoundation\Request as SfRequest;

class RequestTest extends TestCase
{
    public function testConstruct()
    {
        $request = new Request('request content', 'application/test');

        $this->assertEquals('request content', $request->getContent());
        $this->assertEquals('application/test', $request->getContentType());
    }

    public function testGetSchemeAndHttpHost()
    {
        $request = new Request('');
        $request->setHost('example.com');

        $this->assertEquals('http://example.com', $request->getSchemeAndHttpHost());
    }


    public function testGetUserInfoOnlyUsername()
    {
        $request = new Request('');
        $request->setCredentials('admin');

        $this->assertEquals('admin', $request->getUserInfo());
    }

    public function testGetUserInfoFull()
    {
        $request = new Request('');
        $request->setCredentials('admin', 'secret');

        $this->assertEquals('admin:secret', $request->getUserInfo());
    }

    public function testGetContentTypeNull()
    {
        $request = new Request('');

        $this->assertNull($request->getContentType());
    }

    public function testGetContentType()
    {
        $request = new Request('');

        $request->setContentType('text/plain');

        $this->assertEquals('text/plain', $request->getContentType());
    }

    /**
     * @dataProvider uriTests
     */
    public function testUriParse($uri, $expectedHost, $expectedSchemeAndHost, $expectedRequestUri, $expectedUserInfo = null)
    {
        $request = new Request('');

        $request->setFullUri($uri);

        $this->assertEquals($expectedHost, $request->getHttpHost());
        $this->assertEquals($expectedSchemeAndHost, $request->getSchemeAndHttpHost());
        $this->assertEquals($expectedRequestUri, $request->getRequestUri());
        $this->assertEquals($expectedUserInfo, $request->getUserInfo());
    }

    public function uriTests()
    {
        return array(
            array('http://example.com/api/v1', 'example.com', 'http://example.com', '/api/v1'),
            array('http://example.com:80/api/v1', 'example.com', 'http://example.com', '/api/v1'),
            array('https://example.com/api/v1', 'example.com', 'https://example.com', '/api/v1'),
            array('https://example.com:443/api/v1', 'example.com', 'https://example.com', '/api/v1'),
            array('http://example.com:8080/api/v1', 'example.com:8080', 'http://example.com:8080', '/api/v1'),
            array('https://example.com:4330/api/v1', 'example.com:4330', 'https://example.com:4330', '/api/v1'),
            // path & query:
            array('http://example.com', 'example.com', 'http://example.com', '/'),
            array('http://example.com/api?debug', 'example.com', 'http://example.com', '/api?debug'),
            array('http://example.com/api?v=1&debug', 'example.com', 'http://example.com', '/api?v=1&debug'),
            array('http://example.com/api?v=1&debug#fragment', 'example.com', 'http://example.com', '/api?v=1&debug'),
            // username & password:
            array('http://user@example.com', 'example.com', 'http://example.com', '/', 'user'),
            array('http://user:secret@example.com', 'example.com', 'http://example.com', '/', 'user:secret'),
        );
    }
}