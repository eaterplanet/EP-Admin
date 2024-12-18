<?php
/**
 * eaterplanet 商城系统
 *
 * ==========================================================================
 * @link      https://e-p.cloud/
 * @copyright Copyright (c) 2019-2024 Dejavu Tech.
 * @license   https://github.com/eaterplanet/EP-Admin/blob/main/LICENSE
 * ==========================================================================
 *
 * @author    Albert.Z
 *
 */
namespace Home\Widget;
use Think\Controller;
/**
 * 商城推荐活动
 */
class SubjectWidget extends Controller{

	public function hot_subject_show()
	{

	    if (!$slider_cache = S('slider_nav_cache')) {
	        $slider=M('plugins_slider')->where( array('type' => 'index_ad_nav') )->field('slider_name,image,url')->order('sort_order desc')->limit(8)->select();
	        S('slider_nav_cache', $slider);
	        $slider_cache=$slider;
	    }
	    $this->slider=$slider_cache;

		$this->display('Widget:hot_subject_show');
	}

	public function hot_kuaibao_show()
	{
	    $this->display('Widget:hot_kuaibao_show');
	}

}
