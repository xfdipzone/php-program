<?php
namespace Csrf;

/**
 * 定义 csrf token 组件验证返回数据结构
 *
 * @author fdipzone
 * @DateTime 2025-01-04 11:20:36
 *
 */
class VerifyResponse
{
    /**
     * 是否验证成功 false:失败 true:成功
     *
     * @var boolean
     */
    private $success = true;

    /**
     * 错误信息集合
     *
     * @var array
     */
    private $errors = [];

    /**
     * 设置是否成功状态
     *
     * @author fdipzone
     * @DateTime 2025-01-04 11:21:50
     *
     * @param boolean $success 成功状态 false:失败 true:成功
     * @return void
     */
    public function setSuccess(bool $success):void
    {
        $this->success = $success;
    }

    /**
     * 获取是否成功状态
     *
     * @author fdipzone
     * @DateTime 2025-01-04 11:22:11
     *
     * @return boolean
     */
    public function success():bool
    {
        return $this->success;
    }

    /**
     * 设置错误信息集合
     *
     * @author fdipzone
     * @DateTime 2025-01-04 11:22:26
     *
     * @param array $errors 错误信息集合
     * @return void
     */
    public function setErrors(array $errors):void
    {
        $this->errors = $errors;
    }

    /**
     * 获取错误信息集合
     *
     * @author fdipzone
     * @DateTime 2025-01-04 11:22:43
     *
     * @return array
     */
    public function errors():array
    {
        return $this->errors;
    }
}