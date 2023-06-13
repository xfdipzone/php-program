<?php
namespace HttpRequest;

/**
 * form-data格式数据
 *
 * @author fdipzone
 * @DateTime 2023-06-08 22:56:55
 *
 */
class FormData implements \HttpRequest\IRequestData
{
    /**
     * 数据类型，在 \HttpRequest\Type 中定义
     *
     * @var string
     */
    private $type = \HttpRequest\Type::FORM_DATA;

    /**
     * 请求的数据 key=>value 格式
     * 例如 array(name=>'fdipzone','age'=>18,'gender'=>'male')
     *
     * @var array
     */
    private $data = [];

    /**
     * 初始化，设置请求的数据
     *
     * @author fdipzone
     * @DateTime 2023-06-11 22:18:26
     *
     * @param array $data 请求的数据
     */
    public function __construct(array $data)
    {
        if(!$data || !is_array($data))
        {
            throw new \Exception('data is empty or error');
        }

        $this->data = $data;
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
     * 获取请求的数据
     *
     * @author fdipzone
     * @DateTime 2023-06-11 22:17:06
     *
     * @return array
     */
    public function data():array
    {
        return $this->data;
    }
}