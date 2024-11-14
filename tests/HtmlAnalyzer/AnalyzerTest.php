<?php declare(strict_types=1);
namespace Tests\HtmlAnalyzer;

use PHPUnit\Framework\TestCase;

/**
 * 测试 php-html-analyzer\HtmlAnalyzer\Analyzer
 *
 * @author fdipzone
 */
final class AnalyzerTest extends TestCase
{
    /**
     * @covers \HtmlAnalyzer\Analyzer::__construct
     */
    public function testConstruct()
    {
        $url = 'https://www.fdipzone.com';
        $doc = '<p>fdipzone</p>';
        $document = new \HtmlAnalyzer\Document($url, $doc);

        $analyzer = new \HtmlAnalyzer\Analyzer($document);
        $this->assertEquals('HtmlAnalyzer\Analyzer', get_class($analyzer));
    }

    /**
     * @covers \HtmlAnalyzer\Analyzer::emails
     * @covers \HtmlAnalyzer\Analyzer::urls
     * @covers \HtmlAnalyzer\Analyzer::images
     */
    public function testAnalyzer()
    {
        $url = 'https://www.sina.com.cn';
        $doc = file_get_contents(dirname(__FILE__).'/test_data/test.html');
        $document = new \HtmlAnalyzer\Document($url, $doc);

        $analyzer = new \HtmlAnalyzer\Analyzer($document);
        $emails = $analyzer->emails();
        $urls = $analyzer->urls();
        $images = $analyzer->images();

        $this->assertTrue(count($emails)>0);
        $this->assertTrue(count($urls)>0);
        $this->assertTrue(count($images)>0);
    }
}