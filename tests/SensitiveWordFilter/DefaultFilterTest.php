<?php declare(strict_types=1);

use PHPUnit\Framework\TestCase;

/**
 * 测试 php-sensitive-word-filter\SensitiveWordFilter\DefaultFilter
 *
 * @author fdipzone
 */
final class DefaultFilterTest extends TestCase
{
    /**
     * @covers \SensitiveWordFilter\DefaultFilter::__construct
     */
    public function testConstruct()
    {
        $sensitive_word_storage = new \SensitiveWordFilter\Storage\MemoryStorage;
        $sensitive_word_storage->save(['a', 'b', 'c']);

        $filter = new \SensitiveWordFilter\DefaultFilter($sensitive_word_storage);
        $this->assertEquals(get_class($filter), 'SensitiveWordFilter\DefaultFilter');
    }

    /**
     * @covers \SensitiveWordFilter\DefaultFilter::isContain
     */
    public function testIsContain()
    {
        $sensitive_word_storage = new \SensitiveWordFilter\Storage\MemoryStorage;
        $sensitive_word_storage->save(['a', 'b', 'c']);

        $filter = new \SensitiveWordFilter\DefaultFilter($sensitive_word_storage);

        $content = 'china';
        $this->assertSame(true, $filter->isContain($content));

        $content = 'program';
        $this->assertSame(true, $filter->isContain($content));

        $content = 'money';
        $this->assertSame(false, $filter->isContain($content));
    }

    /**
     * @covers \SensitiveWordFilter\DefaultFilter::filter
     */
    public function testFilter()
    {
        $sensitive_word_storage = new \SensitiveWordFilter\Storage\MemoryStorage;
        $sensitive_word_storage->save(['巴黎', '奥运', '金牌']);

        $filter = new \SensitiveWordFilter\DefaultFilter($sensitive_word_storage);

        $content = '巴黎2024奥运会，中国获得40面金牌，可喜可贺';
        $expect_content = '**2024**会，中国获得40面**，可喜可贺';
        $this->assertEquals($expect_content, $filter->filter($content, '**'));
    }

    /**
     * @covers \SensitiveWordFilter\DefaultFilter::filter
     */
    public function testFilterException()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('default filter: replacement can not be empty');

        $sensitive_word_storage = new \SensitiveWordFilter\Storage\MemoryStorage;
        $sensitive_word_storage->save(['巴黎', '奥运', '金牌']);

        $filter = new \SensitiveWordFilter\DefaultFilter($sensitive_word_storage);

        $content = '中国人';
        $filter->filter($content, '');
    }
}