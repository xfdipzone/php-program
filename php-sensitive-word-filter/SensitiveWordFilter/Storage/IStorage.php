<?php
namespace SensitiveWordFilter\Storage;

/**
 * 敏感词存储接口
 *
 * @author fdipzone
 * @DateTime 2024-08-07 20:11:32
 *
 */
interface IStorage
{
    /**
     * 获取敏感词集合
     *
     * @author fdipzone
     * @DateTime 2024-08-07 20:15:54
     *
     * @return array
     */
    public function sensitiveWords():array;
}