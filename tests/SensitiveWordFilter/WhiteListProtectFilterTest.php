<?php declare(strict_types=1);

use PHPUnit\Framework\TestCase;

/**
 * 测试 php-sensitive-word-filter\SensitiveWordFilter\WhiteListProtectFilter
 *
 * @author fdipzone
 */
final class WhiteListProtectFilterTest extends TestCase
{
    /**
     * @covers \SensitiveWordFilter\WhiteListProtectFilter::__construct
     */
    public function testConstruct()
    {
        $resource = new \SensitiveWordFilter\Resource(\SensitiveWordFilter\Resource::MEMORY);
        $resource->setWords(['a', 'b', 'c']);

        $sensitive_word_storage = \SensitiveWordFilter\Storage\Factory::make(\SensitiveWordFilter\Storage\Type::MEMORY);
        $sensitive_word_storage->setResource($resource);

        // default filter
        $filter = new \SensitiveWordFilter\DefaultFilter($sensitive_word_storage);

        // white list protect filter
        $white_list_filter = new \SensitiveWordFilter\WhiteListProtectFilter($filter);
        $this->assertEquals(get_class($white_list_filter), 'SensitiveWordFilter\WhiteListProtectFilter');
    }

    /**
     * @covers \SensitiveWordFilter\WhiteListProtectFilter::isContain
     */
    public function testIsContain()
    {
        $resource = new \SensitiveWordFilter\Resource(\SensitiveWordFilter\Resource::MEMORY);
        $resource->setWords(['a', 'b', 'c']);

        $sensitive_word_storage = \SensitiveWordFilter\Storage\Factory::make(\SensitiveWordFilter\Storage\Type::MEMORY);
        $sensitive_word_storage->setResource($resource);

        // default filter
        $filter = new \SensitiveWordFilter\DefaultFilter($sensitive_word_storage);

        // white list protect filter
        $white_list_filter = new \SensitiveWordFilter\WhiteListProtectFilter($filter);

        $content = 'china';
        $this->assertSame(true, $white_list_filter->isContain($content));

        $content = 'program';
        $this->assertSame(true, $white_list_filter->isContain($content));

        $content = 'money';
        $this->assertSame(false, $white_list_filter->isContain($content));

        // set white list
        $white_list_filter->setWhiteListWords(['china', 'programmer', 'money']);
        $content = 'I love china';
        $this->assertSame(false, $white_list_filter->isContain($content));

        $content = 'program';
        $this->assertSame(true, $white_list_filter->isContain($content));

        $content = 'show money';
        $this->assertSame(false, $white_list_filter->isContain($content));
    }

    /**
     * @covers \SensitiveWordFilter\WhiteListProtectFilter::filter
     */
    public function testFilter()
    {
        $resource = new \SensitiveWordFilter\Resource(\SensitiveWordFilter\Resource::MEMORY);
        $resource->setWords(['巴黎', '奥运', '金牌']);

        $sensitive_word_storage = \SensitiveWordFilter\Storage\Factory::make(\SensitiveWordFilter\Storage\Type::MEMORY);
        $sensitive_word_storage->setResource($resource);

        // default filter
        $filter = new \SensitiveWordFilter\DefaultFilter($sensitive_word_storage);

        // white list protect filter
        $white_list_filter = new \SensitiveWordFilter\WhiteListProtectFilter($filter);

        $content = '巴黎2024奥运会，中国获得40面金牌，可喜可贺';
        $expect_content = '**2024**会，中国获得40面**，可喜可贺';
        $this->assertEquals($expect_content, $white_list_filter->filter($content, '**'));

        // set white list
        $white_list_filter->setWhiteListWords(['巴黎人', '奥运会', '获金牌']);
        $content = '今天巴黎人们很开心，举办了巴黎2024奥运会，中国获得40面金牌，可喜可贺，再次祝贺获金牌的运动员';
        $expect_content = '今天巴黎人们很开心，举办了**2024奥运会，中国获得40面**，可喜可贺，再次祝贺获金牌的运动员';
        $this->assertEquals($expect_content, $white_list_filter->filter($content, '**'));
    }

    /**
     * @covers \SensitiveWordFilter\WhiteListProtectFilter::filter
     */
    public function testFilterException()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('default filter: replacement can not be empty');

        $resource = new \SensitiveWordFilter\Resource(\SensitiveWordFilter\Resource::MEMORY);
        $resource->setWords(['巴黎', '奥运', '金牌']);

        $sensitive_word_storage = \SensitiveWordFilter\Storage\Factory::make(\SensitiveWordFilter\Storage\Type::MEMORY);
        $sensitive_word_storage->setResource($resource);

        // default filter
        $filter = new \SensitiveWordFilter\DefaultFilter($sensitive_word_storage);

        // white list protect filter
        $white_list_filter = new \SensitiveWordFilter\WhiteListProtectFilter($filter);

        $content = '中国人';
        $white_list_filter->filter($content, '');
    }

    /**
     * @covers \SensitiveWordFilter\WhiteListProtectFilter::setWhiteListWords
     * @covers \SensitiveWordFilter\WhiteListProtectFilter::whiteListWords
     */
    public function testSetAndGetWhiteListWords()
    {
        $resource = new \SensitiveWordFilter\Resource(\SensitiveWordFilter\Resource::MEMORY);
        $resource->setWords(['a', 'b', 'c']);

        $sensitive_word_storage = \SensitiveWordFilter\Storage\Factory::make(\SensitiveWordFilter\Storage\Type::MEMORY);
        $sensitive_word_storage->setResource($resource);

        // default filter
        $filter = new \SensitiveWordFilter\DefaultFilter($sensitive_word_storage);

        // white list protect filter
        $white_list_filter = new \SensitiveWordFilter\WhiteListProtectFilter($filter);
        $white_list_filter->setWhiteListWords(['b', 'c', 'd']);
        $this->assertEquals('b,c,d', implode(',', $white_list_filter->whiteListWords()));
    }

    /**
     * @covers \SensitiveWordFilter\WhiteListProtectFilter::setWhiteListWords
     */
    public function testSetWhiteListWordsException()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('white list protect filter: white list words is empty');

        $resource = new \SensitiveWordFilter\Resource(\SensitiveWordFilter\Resource::MEMORY);
        $resource->setWords(['a', 'b', 'c']);

        $sensitive_word_storage = \SensitiveWordFilter\Storage\Factory::make(\SensitiveWordFilter\Storage\Type::MEMORY);
        $sensitive_word_storage->setResource($resource);

        // default filter
        $filter = new \SensitiveWordFilter\DefaultFilter($sensitive_word_storage);

        // white list protect filter
        $white_list_filter = new \SensitiveWordFilter\WhiteListProtectFilter($filter);
        $white_list_filter->setWhiteListWords([]);
    }
}