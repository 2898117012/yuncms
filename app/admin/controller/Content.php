<?php
// +----------------------------------------------------------------------
// | YunCMS
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://www.yunalading.com All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: jabber <2898117012@qq.com>
// +----------------------------------------------------------------------


namespace app\admin\controller;

use app\common\controller\AdminBaseController;
use app\core\Users;

/**
 * Class Content
 * @package app\admin\controller
 */
class Content extends AdminBaseController {
    /**
     * @return \think\response\View
     */
    public function index() {
        return view();
    }

    /**
     * @return \think\response\View
     */
    public function add() {
        return view();
    }

    /**
     * @return \think\response\View
     */
    public function edit() {
        return view();
    }

    /**
     * @return \think\response\View
     */
    public function del() {
        return view();
    }

    /**
     * @return \think\response\View
     */
    public function trash() {
        return view();
    }
}
