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

namespace app\common\controller;
use think\Controller;

/**
 * Class BaseController
 * @package app\common\controller
 */
abstract class BaseController extends Controller {
    /**
     * BaseController constructor.
     */
    public function __construct() {
        parent::__construct();

    }
}
