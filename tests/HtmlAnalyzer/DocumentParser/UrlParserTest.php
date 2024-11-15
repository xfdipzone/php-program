<?php declare(strict_types=1);
namespace Tests\HtmlAnalyzer\DocumentParser;

use PHPUnit\Framework\TestCase;

/**
 * 测试 php-html-analyzer\HtmlAnalyzer\DocumentParser\UrlParser
 *
 * @author fdipzone
 */
final class UrlParserTest extends TestCase
{
    /**
     * @covers \HtmlAnalyzer\DocumentParser\UrlParser::parse
     */
    public function testParse()
    {
        $url = 'https://www.sina.com.cn';
        $doc = file_get_contents(dirname(dirname(__FILE__)).'/test_data/test.html');
        $document = new \HtmlAnalyzer\Document($url, $doc);

        $result = \HtmlAnalyzer\DocumentParser\UrlParser::parse($document);
        $this->assertTrue(count($result)>0);
    }
}