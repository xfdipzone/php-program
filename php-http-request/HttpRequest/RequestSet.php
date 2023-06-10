<?php
namespace HttpRequest;

/**
 * 请求数据对象集合
 *
 * @author fdipzone
 * @DateTime 2023-06-08 23:13:26
 *
 */
class RequestSet
{
    /**
     * 保存 \HttpRequest\Type::FORM_DATA 类型的请求对象集合
     *
     * @var array [] \HttpRequest\FormData
     */
    private $form_data_set = [];

    /**
     * 保存 \HttpRequest\Type::FILE_DATA 类型的请求对象集合
     *
     * @var array [] \HttpRequest\FileData
     */
    private $file_data_set = [];

    /**
     * 添加请求对象
     *
     * @author fdipzone
     * @DateTime 2023-06-10 23:15:10
     *
     * @param \HttpRequest\IRequestData $request_data
     * @return void
     */
    public function add(\HttpRequest\IRequestData $request_data):void
    {
        if($request_data->type()==\HttpRequest\Type::FORM_DATA)
        {
            array_push($this->form_data_set, $request_data);
        }
        elseif($request_data->type()==\HttpRequest\Type::FILE_DATA)
        {
            array_push($this->file_data_set, $request_data);
        }
        else
        {
            throw new \Exception('request data type not supported');
        }
    }

    /**
     * 获取  \HttpRequest\Type::FORM_DATA 类型的请求对象集合
     *
     * @author fdipzone
     * @DateTime 2023-06-10 23:39:47
     *
     * @return array
     */
    public function formDataSet():array
    {
        return $this->form_data_set;
    }

    /**
     * 获取  \HttpRequest\Type::FILE_DATA 类型的请求对象集合
     *
     * @author fdipzone
     * @DateTime 2023-06-10 23:40:11
     *
     * @return array
     */
    public function fileDataSet():array
    {
        return $this->file_data_set;
    }
}