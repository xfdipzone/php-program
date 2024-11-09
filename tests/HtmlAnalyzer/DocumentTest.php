<?php declare(strict_types=1);
namespace Tests\HtmlAnalyzer;

use PHPUnit\Framework\TestCase;

/**
 * 测试 php-html-analyzer\HtmlAnalyzer\Document
 *
 * @author fdipzone
 */
final class DocumentTest extends TestCase
{
    /**
     * @covers \HtmlAnalyzer\Document::__construct
     */
    public function testConstruct()
    {
        $url = 'https://www.fdipzone.com';
        $doc = '<p>fdipzone</p>';

        $document = new \HtmlAnalyzer\Document($url, $doc);
        $this->assertEquals('HtmlAnalyzer\Document', get_class($document));
    }

    /**
     * @covers \HtmlAnalyzer\Document::__construct
     */
    public function testConstructUrlEmptyException()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('html analyzer doc: url is empty');

        $url = '';
        $doc = '<p>fdipzone</p>';

        new \HtmlAnalyzer\Document($url, $doc);
    }

    /**
     * @covers \HtmlAnalyzer\Document::__construct
     */
    public function testConstructUrlInvalidException()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('html analyzer doc: url is invalid');

        $url = 'http://fdipzone';
        $doc = '<p>fdipzone</p>';

        new \HtmlAnalyzer\Document($url, $doc);
    }

    /**
     * @covers \HtmlAnalyzer\Document::__construct
     */
    public function testConstructDocEmptyException()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('html analyzer doc: doc is empty');

        $url = 'https://www.fdipzone.com';
        $doc = '';

        new \HtmlAnalyzer\Document($url, $doc);
    }

    /**
     * @covers \HtmlAnalyzer\Document::url
     * @covers \HtmlAnalyzer\Document::doc
     */
    public function testGet()
    {
        $url = 'https://www.fdipzone.com';
        $doc = '<p>fdipzone</p>';

        $document = new \HtmlAnalyzer\Document($url, $doc);
        $this->assertEquals($url, $document->url());
        $this->assertEquals($doc, $document->doc());
    }
}