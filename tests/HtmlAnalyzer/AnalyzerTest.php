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
}