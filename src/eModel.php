<?php
namespace Yser;

use think\db\Query;
use think\facade\Request;
use think\Model;

/***
 * 模型下级负载器
 * Class eModel
 * @package Yser
 */
class eModel extends Model
{
    /***
     * 数据表字段信息
     *  - 严格按照文档规范
     * @var array
     */
    protected $TableField = [];

    /***
     * 数据表备注信息
     *  - 格式规范定义
     *  - 负责人
     *  - 处理记录备注
     * @var array
     */
    protected $TableInfo  = [];

    /***
     * 设置多个参数
     * @param $data
     * @param string $name
     * @return $this|Model
     */
    public function set($data, $name = '')
    {
        foreach (is_string($data) ? [$data => $name] : $data as $key => $name)
            $this->setAttr($key, $name);
        return $this;
    }

    /***
     * 数据唯一性校验
     * @param $field
     * @param $value
     * @return bool
     */
    public static function dataUniqueCheck($field,$value)
    {
        return self::where($field,$value)->value($field) ? true : false;
    }

    /***
     * 分页查询数据,
     * @param Query $model
     * @param bool $toArray
     * @param callable $fun
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public static function ePageSelect(Query $model,$toArray = false,$fun = null)
    {
        $list = $model->page(Request::get('page',1),Request::get('page_size',20))->select();
        $data = [
            'count' =>$model->count($model->getPk()),
            'list'  =>$toArray ? $list->toArray() : $list
        ];
        if(is_callable($fun))
            foreach ($data['list'] as $i=>$item)
                $data['list'][$i] = $fun($item);
        return $data;
    }
}