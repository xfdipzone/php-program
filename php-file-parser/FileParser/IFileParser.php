<?php
namespace FileParser;

/**
 * 文件解析器接口
 * 定义文件解析器必须实现的方法
 *
 * @author fdipzone
 * @DateTime 2024-08-31 18:43:28
 *
 */
interface IFileParser
{
    /**
     * 解析文件
     *
     * @author fdipzone
     * @DateTime 2024-08-31 18:55:56
     *
     * @param string $file 文件路径
     * @return \FileParser\Response
     */
    public function parseFromFile(string $file):\FileParser\Response;

    /**
     * 解析文件内容字符串
     *
     * @author fdipzone
     * @DateTime 2024-08-31 18:56:13
     *
     * @param string $str 文件内容字符串
     * @return \FileParser\Response
     */
    public function parseFromString(string $str):\FileParser\Response;
}