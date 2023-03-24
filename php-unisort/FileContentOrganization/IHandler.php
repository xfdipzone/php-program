<?php
namespace FileContentOrganization;

/**
 * 定义处理器类接口
 *
 * @author fdipzone
 * @DateTime 2023-03-23 22:41:38
 *
 */
interface IHandler{

    /**
     * 执行处理
     *
     * @author fdipzone
     * @DateTime 2023-03-23 22:43:25
     *
     * @param string $data 文件内容
     * @return string
     */
    public function handle(string $data):string;

}