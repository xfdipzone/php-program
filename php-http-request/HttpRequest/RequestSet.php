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
     * @var array(\HttpRequest\FormData)
     */
    private $form_data_set = [];

    /**
     * 保存 \HttpRequest\Type::FILE_DATA 类型的请求对象集合
     *
     * @var array(\HttpRequest\FileData)
     */
    private $file_data_set = [];

    /**
     * 添加请求对象
     *
     * @author fdipzone
     * @DateTime 2023-06-10 23:15:10
     *
     * @param \HttpRequest\IRequestData $request_data 请求对象
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

    /**
     * 将form-data请求对象集合数据转为数组格式
     *
     * @author fdipzone
     * @DateTime 2023-06-11 22:44:54
     *
     * @return array
     */
    public function convertFormDataSet():array
    {
        $result = [];

        // 合并form-data对象数据
        foreach($this->form_data_set as $form_data_request)
        {
            $result = array_merge($result, $form_data_request->data());
        }

        return $result;
    }

    /**
     * 将file-data请求对象集合数据转为数组格式
     *
     * @author fdipzone
     * @DateTime 2023-06-11 22:46:43
     *
     * @return array
     */
    public function convertFileDataSet():array
    {
        $result = [];

        // 合并file-data对象数据
        foreach($this->file_data_set as $file_data_request)
        {
            $tmp = array(
                'upload_field_name' => $file_data_request->uploadFieldName(),
                'file_path' => $file_data_request->file(),
                'file_name' => basename($file_data_request->file())
            );
            $result = array_push($result, $tmp);
        }

        return $result;
    }
}