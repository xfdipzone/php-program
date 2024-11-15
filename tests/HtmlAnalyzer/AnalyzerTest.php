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
     * @covers \HtmlAnalyzer\Analyzer::getResource
     */
    public function testGetResource()
    {
        $url = 'https://www.sina.com.cn';
        $doc = file_get_contents(dirname(__FILE__).'/test_data/test.html');
        $document = new \HtmlAnalyzer\Document($url, $doc);

        $analyzer = new \HtmlAnalyzer\Analyzer($document);
        $emails = $analyzer->getResource(\HtmlAnalyzer\Type::EMAIL);
        $urls = $analyzer->getResource(\HtmlAnalyzer\Type::URL);
        $images = $analyzer->getResource(\HtmlAnalyzer\Type::IMAGE);
        $css = $analyzer->getResource(\HtmlAnalyzer\Type::CSS);

        $this->assertTrue(count($emails)>0);
        $this->assertTrue(count($urls)>0);
        $this->assertTrue(count($images)>0);
        $this->assertTrue(count($css)>0);
    }

    /**
     * @covers \HtmlAnalyzer\Analyzer::getResource
     */
    public function testGetResourceException()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('html analyzer: type not_exists_type not exists');

        $url = 'https://www.sina.com.cn';
        $doc = file_get_contents(dirname(__FILE__).'/test_data/test.html');
        $document = new \HtmlAnalyzer\Document($url, $doc);

        $analyzer = new \HtmlAnalyzer\Analyzer($document);
        $type = 'not_exists_type';
        $analyzer->getResource($type);
    }
}