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
     * 上传的字段名称
     *
     * @var string
     */
    private $upload_field_name;

    /**
     * 上传的文件
     *
     * @var string
     */
    private $file;

    /**
     * 初始化，设置上传字段名称与文件路径
     *
     * @author fdipzone
     * @DateTime 2023-06-11 22:17:54
     *
     * @param string $upload_field_name 上传的字段名称
     * @param string $file 上传的文件
     */
    public function __construct(string $upload_field_name, string $file)
    {
        if(empty($upload_field_name))
        {
            throw new \Exception('upload field name is empty');
        }

        if(!file_exists($file))
        {
            throw new \Exception('upload file not exists');
        }

        $this->upload_field_name = $upload_field_name;
        $this->file = $file;
    }

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

    /**
     * 获取上传的字段名称
     *
     * @author fdipzone
     * @DateTime 2023-06-11 22:08:24
     *
     * @return string
     */
    public function uploadFieldName():string
    {
        return $this->upload_field_name;
    }

    /**
     * 获取上传的文件
     *
     * @author fdipzone
     * @DateTime 2023-06-11 22:12:00
     *
     * @return string
     */
    public function file():string
    {
        return $this->file;
    }
}