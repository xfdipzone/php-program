<?php
namespace HttpRequest;

/**
 * 文件数据
 *
 * @author fdipzone
 * @DateTime 2023-06-08 22:57:12
 *
 */
class FileData implements \HttpRequest\IRequestData
{
    /**
     * 数据类型，在 \HttpRequest\Type 中定义
     *
     * @var string
     */
    private $type = \HttpRequest\Type::FILE_DATA;

    /**
     * 返回数据类型
     *
     * @author fdipzone
     * @DateTime 2023-06-08 23:01:05
     *
     * @return string
     */
    public function type():string
    {
        return $this->type;
    }
}