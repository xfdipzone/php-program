<?php declare(strict_types=1);
namespace Tests\AnnotationReader;

use PHPUnit\Framework\TestCase;

/**
 * 测试 php-annotation-reader\AnnotationReader\AnnotationTags
 *
 * @author fdipzone
 */
final class AnnotationTagsTest extends TestCase
{
    /**
     * @covers \AnnotationReader\AnnotationTags::__construct
     */
    public function testConstruct()
    {
        $tags = ['@Column', '@Json'];
        $annotation_tags = new \AnnotationReader\AnnotationTags($tags);
        $this->assertEquals('AnnotationReader\AnnotationTags', get_class($annotation_tags));
    }

    /**
     * @covers \AnnotationReader\AnnotationTags::__construct
     */
    public function testConstructEmptyAnnotationTagsException()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('annotation reader: annotation tags is empty');

        $tags = [];
        new \AnnotationReader\AnnotationTags($tags);
    }

    /**
     * @covers \AnnotationReader\AnnotationTags::__construct
     */
    public function testConstructInvalidAnnotationTagsException()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('annotation reader: annotation tags is invalid');

        $tags = ['abc'];
        new \AnnotationReader\AnnotationTags($tags);
    }

    /**
     * @covers \AnnotationReader\AnnotationTags::tags
     */
    public function testTags()
    {
        $tags = ['@Column', '@Json'];
        $annotation_tags = new \AnnotationReader\AnnotationTags($tags);
        $ret = $annotation_tags->tags();
        $this->assertSame(2, count($ret));
        $this->assertEquals($tags[0], $ret[0]);
        $this->assertEquals($tags[1], $ret[1]);

        // 测试唯一tags
        $tags = ['@Column', '@Json', '@Column'];
        $annotation_tags = new \AnnotationReader\AnnotationTags($tags);
        $ret = $annotation_tags->tags();
        $this->assertSame(2, count($ret));
        $this->assertEquals($tags[0], $ret[0]);
        $this->assertEquals($tags[1], $ret[1]);

        // 测试大小写敏感
        $tags = ['@Column', '@COLUMN'];
        $annotation_tags = new \AnnotationReader\AnnotationTags($tags);
        $ret = $annotation_tags->tags();
        $this->assertSame(2, count($ret));
        $this->assertEquals($tags[0], $ret[0]);
        $this->assertEquals($tags[1], $ret[1]);
    }

    /**
     * @covers \AnnotationReader\AnnotationTags::validateTags
     */
    public function testValidateTags()
    {
        $tags = ['@Column', '@Json'];
        $annotation_tags = new \AnnotationReader\AnnotationTags($tags);

        $cases = array(
            array(
                'tags' => ['@Column'],
                'want_ret' => true,
            ),
            array(
                'tags' => ['Column'],
                'want_ret' => false,
            ),
            array(
                'tags' => ['@@Column'],
                'want_ret' => false,
            ),
            array(
                'tags' => ['@Column123'],
                'want_ret' => true,
            ),
            array(
                'tags' => ['@Column_123'],
                'want_ret' => false,
            ),
            array(
                'tags' => ['@123Column'],
                'want_ret' => false,
            ),
            array(
                'tags' => ['@Column', '@Json'],
                'want_ret' => true,
            ),
            array(
                'tags' => ['@Column', '@_Json'],
                'want_ret' => false,
            ),
        );

        foreach($cases as $case)
        {
            $ret = \Tests\Utils\PHPUnitExtension::callMethod($annotation_tags, 'validateTags', [$case['tags']]);
            $this->assertSame($case['want_ret'], $ret);
        }
    }
}