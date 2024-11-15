<?php declare(strict_types=1);
namespace Tests\HtmlAnalyzer\DocumentParser;

use PHPUnit\Framework\TestCase;

/**
 * 测试 php-html-analyzer\HtmlAnalyzer\DocumentParser\EmailParser
 *
 * @author fdipzone
 */
final class EmailParserTest extends TestCase
{
    /**
     * @covers \HtmlAnalyzer\DocumentParser\EmailParser::parse
     */
    public function testParse()
    {
        $url = 'https://www.sina.com.cn';
        $doc = file_get_contents(dirname(dirname(__FILE__)).'/test_data/test.html');
        $document = new \HtmlAnalyzer\Document($url, $doc);

        $result = \HtmlAnalyzer\DocumentParser\EmailParser::parse($document);
        $this->assertTrue(count($result)>0);
    }
}