<?php
namespace Mail;

/**
 * 电子邮件附件结构体
 *
 * @author fdipzone
 * @DateTime 2024-10-27 11:14:31
 *
 */
class Attachment
{
    /**
     * 附件文件路径
     *
     * @var string
     */
    private $file;

    /**
     * 附件名称
     * 如附件名称为空，则使用附件真实文件名称
     *
     * @var string
     */
    private $name;

    /**
     * 初始化
     * 设置附件文件路径与附件名称
     *
     * @author fdipzone
     * @DateTime 2024-10-27 11:17:07
     *
     * @param string $file 附件文件路径
     * @param string $name 附件名称
     */
    public function __construct(string $file, string $name='')
    {
        if(empty($file))
        {
            throw new \Exception('mailer attachment: file is empty');
        }

        if(!file_exists($file))
        {
            throw new \Exception('mailer attachment: file not exists');
        }

        // 附件名称为空则使用附件文件名称
        if($name=='')
        {
            $name = basename($file);
        }

        $this->file = $file;
        $this->name = $name;
    }

    /**
     * 获取附件文件路径
     *
     * @author fdipzone
     * @DateTime 2024-10-27 11:22:50
     *
     * @return string
     */
    public function file():string
    {
        return $this->file;
    }

    /**
     * 获取附件名称
     *
     * @author fdipzone
     * @DateTime 2024-10-27 11:23:15
     *
     * @return string
     */
    public function name():string
    {
        return $this->name;
    }
}