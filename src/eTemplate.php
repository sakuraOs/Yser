<?php
namespace Yser;

use calm\eTools;
use think\facade\Env;

/***
 * 内容模板
 * Class eTemplate
 * @package Yser
 */
class eTemplate
{
    /***
     * 查询
     * @param int $page
     * @param int $page_size
     * @return array
     */
    public static function select($page = 1,$page_size = 20)
    {
        $myDir = dir(Env::get('runtime_path').'template'.DIRECTORY_SEPARATOR);
        $files = [];
        while ($file = $myDir->read()) {
            if($file == '.' || $file == '..') continue;
            $file_path = $myDir->path.$file;
            if(is_file($file_path))
                $files[] = $file_path;
        }
        $myDir->close();

        foreach ($files = array_slice($files,($page-1)*$page_size,$page_size) as $i=>$path)
        {
            $file_body = file_get_contents($path);
            $file_title = self::preg_match_all('title',$file_body);
            $file_mtime = date('Y-m-d H:i:s', filemtime($path));
            $files[$i] = [
                //  'path'    => $path,
                'title'   => $file_title,
                'mtime'   => $file_mtime,
                'content' => self::getBody($file_body),
            ];
        }
        return $files;

    }

    /***
     * 写入
     * @param $name
     * @param $body
     * @param array $tag
     * @return bool|int
     */
    public static function write($name,$body,array $tag = [])
    {
        $path = Env::get('runtime_path').'template'.DIRECTORY_SEPARATOR.(md5($name)).'.template';
        //  设置标题
        $file = "(title:$name),";
        //  设置参数群
        foreach ($tag as $key=>$val)
            $file.='('.$key.':'.$val.')';
        //  拼接尾巴
        $file .= " \r\n".$body;
        //  写入
        return file_put_contents($path,$file);
    }

    /**
     * 获取内容
     * @param $name
     * @param array $params
     * @return int|string|string[]|null
     */
    public static function getContent($name,array $params = [])
    {
        $path = Env::get('runtime_path').'template'.DIRECTORY_SEPARATOR.(md5($name)).'.template';
        $body = self::getBody(file_get_contents($path));
        return empty($params) ? $body : eTools::FormatTemplate($body,$params);
    }
    private static function preg_match_all($name,$file_body)
    {
        preg_match_all("/(?<=\(".$name.":)[^\)]+/", $file_body, $file_match);
        return empty($file_match[0][0]) ? null : $file_match[0][0];
    }
    private static function getBody($file_body)
    {
        $file_body = explode("\r\n", $file_body);
        unset($file_body[0]);
        return implode("\r\n", $file_body);
    }
}