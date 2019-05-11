<?php
namespace Yser;

/***
 * 中间件下级负载器
 * Class eMiddleware
 * @package Yser
 */
class eMiddleware
{
    protected $MIDDLEWARE = '';

    public static function LoadFrame()
    {

    }

    /****
     * 路由忽略校验
     * @param $route
     * @return bool
     */
    public function RouteIgnoreAuth($route)
    {
        file_put_contents(eDefine::SYS_MAP.'route_ignore.map',json_encode(['\data\awscas\sdad']));
        $route_ignore = @file_get_contents(eDefine::SYS_MAP.'route_ignore.map');

        if(in_array($route,json_decode($route_ignore,true) ?: []))
            return true;
        else
            return false;
    }
}