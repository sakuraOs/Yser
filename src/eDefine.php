<?php
namespace Yser;

use think\facade\Env;

define('SYS_PATH',Env::get('ROOT_PATH'));

/***
 * 常量定义
 * Class eDefine
 * @package Yser
 */
class eDefine
{
    //  系统内容模板
    const SYS_TEMPLATE   = SYS_PATH.'runtime'.DIRECTORY_SEPARATOR.'template'.DIRECTORY_SEPARATOR;
    //  系统临时缓存
    const SYS_TEMP_CACHE = SYS_PATH.'runtime'.DIRECTORY_SEPARATOR.'temp'.DIRECTORY_SEPARATOR;
    //  系统映射文件
    const SYS_MAP        = SYS_PATH.'runtime'.DIRECTORY_SEPARATOR.'map'.DIRECTORY_SEPARATOR;
    //  系统日志文件
    const SYS_LOG        = SYS_PATH.'runtime'.DIRECTORY_SEPARATOR.'slog'.DIRECTORY_SEPARATOR;
}