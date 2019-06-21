<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

use think\Route;

//api.test.com ============> www.test.com/index.php/moneys_api
Route::domain('api','moneys_api');

//配置易企秀列表请求路径
Route::get('eqx/:time/:token/[:isstate]/[:limit]', 'Moneys/eqx_list');

//配置文章列表请求路径
Route::get('article/:time/:token/[:isstate]/[:limit]', 'Moneys/article_list');

//配置视频列表请求路径
Route::get('video/:time/:token/[:isstate]/[:limit]', 'Moneys/video_list');

//配置音频列表请求路径
Route::get('dubbing/:time/:token/[:isstate]/[:limit]', 'Moneys/dubbing_list');