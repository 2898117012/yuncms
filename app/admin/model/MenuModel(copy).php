<?php
// +----------------------------------------------------------------------
// | YunCMS
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://www.yunalading.com All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: chenqianhao <68527761@qq.com>
// +----------------------------------------------------------------------
namespace app\admin\model;
use app\common\model\BaseModel;
use think\Db;
use think\Config;
class MenuModel extends BaseModel
{
    protected $tableName='menu';
    /**
     * 根据条件获取指定的一个值
     * @param $where [array] 条件
     * @param $field 查查询的字段
     * @return string
     * @author [chenqianhao] <68527761@qq.com>
     */
    public function getOne($field,$where=array())
    {
        if(empty($where)){
          $value=Db::name($this->tableName)->value($field);
        }else{
          $value=Db::name($this->tableName)->where($where)->value($field);
        }
        return $value;
    }
    /**
     * 根据条件获取指定的一组数据
     * @param $where [array] 条件
     * @param $field [string] 查询的字段
     * @return array|null
     * @author [chenqianhao] <68527761@qq.com>
     */
    public function getRow($where,$field='*')
    {
        //$admin_user=Db::table('yc_admin_user')->where($where)->find();
        //助手函数需加入第三个参数才和Db::table或Db::name一样是单例模式，否则每次都要连接一下数据库
        $row = db($this->tableName,[],false)->field($field)->where($where)->find();
        return $row;
    }

    /**
     * 根据条件获更新数据数据
     * @param $data 要更新的字段和值组成的二元数组
     * @param $where [array] 条件
     * @return int 影响的条数
     * @author [chenqianhao] <68527761@qq.com>
     */
    public function autoupdate($data,$where)
    {
       $update=Db::table(Config::get('database.prefix').$this->tableName)->where($where)->update($data);
       return $update;
    }

    /**
     * 根据条件获取指定的所有数据
     * @param $where [array] 条件
     * @return array|null
     * @author [chenqianhao] <68527761@qq.com>
     */
    public function getAll($where=array(),$field='*')
    {
      if(empty($where)){
        $info = Db::name($this->tableName)->field($field)->select();
      }else{
        $info = Db::name($this->tableName)->field($field)->where($where)->select();
      }
      return $info;
    }


    /**
     * 根据条件获取指定的所有数据
     * @param $data [array] 要插入的数据数组
     * @return int 插入的主键id
     * @author [chenqianhao] <68527761@qq.com>
     */
    public function autoinsert($data)
    {
      Db::name($this->tableName)->insert($data);
      $id = Db::name($this->tableName)->getLastInsID();
      return $id;
    }

    /**
     * 获取菜单树
     * @param $where [array] 条件
     * @return array|null
     * @author [chenqianhao] <68527761@qq.com>
     */
    public function tree($where)
    {
        $menus = Db::name($this->tableName)->order('sort','asc')->where($where)->select();
        return $this->getTree($menus,'title','id','pid');
    }
    /**
     * 菜单树样式重新排列，目前只支持二级菜单
     * @return array|null
     * @author [chenqianhao] <68527761@qq.com>
     */
    public function getTree($data,$field_name,$field_id='id',$field_pid='pid',$pid=0)
    {
        $arr = array();
        foreach ($data as $k=>$v){
            if($v[$field_pid]==$pid){
                $data[$k]["_".$field_name] = $data[$k][$field_name];
                $arr[] = $data[$k];
                foreach ($data as $m=>$n){
                    if($n[$field_pid] == $v[$field_id]){
                        $data[$m]["_".$field_name] = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;├─ '.$data[$m][$field_name];
                        $arr[] = $data[$m];
                    }
                }
            }
        }
        return $arr;
    }

    /**
     * 过滤要操作的数据，返回操作的数组
     * @param $request [array] 请求过来的参数
     * @return array|null
     * @author [chenqianhao] <68527761@qq.com>
     */
     function getparaminfo($request){
       $info=array();
       $param=$request->param();
       $url=geturlbase();
       if(isset($param['id']) && $param['id']=='select'){//多选
         if(isset($param['ids']) && $param['ids']!=''){
           $info['info']=explode(',',$param['ids']);
           $info['status']=1;
          //  $info['hide']=intval($param['hide']);
           $info['url']=$url;
           return $info;
         }else{
            $info['info']='请选择要操作的数据！';
            $info['status']=0;
            $info['url']=$url;
            return $info;
         }
       }else{//单选中
         $ids=intval($param['id']);
         $info['info'][0]=$ids;
         $info['status']=1;
        //  $info['hide']=intval($param['hide']);
         $info['url']=$url;
         return $info;
       }
     }

     /**
      * 获取所有一级菜单
      * @return array|null
      * @author [chenqianhao] <68527761@qq.com>
      */
      function get_menu_shangji(){
        $where['pid']=0;
        $where['status']=0;
        $where['type']='admin';
        $field=['id','title'];
        $data=$this->getAll($where,$field);
        return $data;
      }
}