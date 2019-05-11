<?php
namespace Yser;

use think\facade\Hook;

//  使用方式
//  $res = eHook::run(class,'函数名',[参数]);


/***
 * 行为下级负载器
 * Class eHook
 * @package Yser
 */
class eHook
{
    public static function run($class,$method = '',$params = [])
    {
        return Hook::exec([$class,$method ?: 'run'], $params);
    }
}