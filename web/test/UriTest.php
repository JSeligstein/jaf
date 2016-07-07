<?php

namespace jaf\web\test;
use jaf\web\Uri;

class UriTest extends \PHPUnit_Framework_TestCase {

    public function testFullParse() {
        $uriStr = 'http://a.b.domain.com/path/path2/file.html?q1=1&q2&q3=3';
        $uri = new Uri($uriStr);
        $this->assertEquals($uri->getProtocol(), 'http');
        $this->assertEquals($uri->getPath(), 'path/path2/file.html');
        $this->assertEquals($uri->getDomain(), 'domain.com');
        $this->assertEquals($uri->getSubdomain(), 'a.b');
        $this->assertEquals($uri->getFullDomain(), 'a.b.domain.com');
        $this->assertEquals($uri->getQueryStr(), 'q1=1&q2&q3=3');
        $this->assertEquals((string)$uri, $uriStr);
    }

    public function testFullChange() {
        $uriStr = 'http://a.b.domain.com/path/path2/file.html?q1=1&q2&q3=3';
        $uri = new Uri($uriStr);

        $uri->setProtocol('https');
        $uri->setPath('newpath.php');
        $uri->setDomain('newdomain.net');
        $uri->setSubdomain('c.d');
        $uri->setParam('q1', null);
        $uri->setParam('q2', 2);

        $this->assertEquals($uri->getProtocol(), 'https');
        $this->assertEquals($uri->getPath(), 'newpath.php');
        $this->assertEquals($uri->getDomain(), 'newdomain.net');
        $this->assertEquals($uri->getSubdomain(), 'c.d');
        $this->assertEquals($uri->getFullDomain(), 'c.d.newdomain.net');
        $this->assertEquals($uri->getQueryStr(), 'q1&q2=2&q3=3');
        $this->assertEquals((string)$uri, 'https://c.d.newdomain.net/newpath.php?q1&q2=2&q3=3');
    }
}
