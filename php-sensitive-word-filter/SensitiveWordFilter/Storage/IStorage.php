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
     * 设置敏感词数据源
     * 此方法可多次调用，追加敏感词列表
     *
     * @author fdipzone
     * @DateTime 2024-08-16 22:47:10
     *
     * @param \SensitiveWordFilter\Resource $resource 敏感词数据源
     * @return void
     */
    public function setResource(\SensitiveWordFilter\Resource $resource);

    /**
     * 获取敏感词集合
     *
     * @author fdipzone
     * @DateTime 2024-08-07 20:15:54
     *
     * @return array [敏感词1,敏感词2,敏感词3,...敏感词n]
     */
    public function sensitiveWords():array;
}