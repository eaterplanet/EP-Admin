<?phpnamespace Home\Model;use Think\Model;/** * 圈子模型 * @author Albert.Z * */class CommissionModel {	public $table = 'pin';	/**		计算用户佣金	**/	function sum_member_commiss($where = "")	{		$total_commiss = M('eaterplanet_ecommerce_member_commiss_order')->where( " 1 {$where}" )->sum('money');		return $total_commiss;	}	public function get_share_name($member_id)	{		$info = M('eaterplanet_ecommerce_member')->where( array('member_id' => $member_id ) )->find();		if( empty($info) )		{			return array();		}else{			return $info;		}	}	//.....TODO...	public function get_order_goods_commission( $order_id, $order_goods_id)	{		$info = M('eaterplanet_ecommerce_member_commiss_order')->where( array('order_id' => $order_id, 'order_goods_id' => $order_goods_id) )->order('level asc')->select();		$result = array();		if( !empty($info) )		{			foreach( $info as $val )			{				$result[ $val['id'] ] = $val;			}		}		return $result;	}	public function send_order_commiss_money($order_id)	{		$member_commiss_order_list = M('eaterplanet_ecommerce_member_commiss_order')->where( array('order_id' => $order_id, 'state' => 0) )->select();		if(!empty($member_commiss_order_list))		{		    foreach($member_commiss_order_list as $member_commiss_order)		    {			   //分佣订单				M('eaterplanet_ecommerce_member_commiss_order')->where( array('id' => $member_commiss_order['id'] ) )->save( array('state' => 1) );				M('eaterplanet_ecommerce_member_commiss')->where( array('member_id' => $member_commiss_order['member_id'] ) )->setInc('money',$member_commiss_order['money'] );			}		}	}	/**		给上级客户分佣	**/	public function ins_member_commiss_order($member_id,$order_id,$store_id,$order_goods_id)	{		$member_info = M('eaterplanet_ecommerce_member')->where( array('member_id' => $member_id ) )->find();		$commiss_selfbuy = D('Home/Front')->get_config_by_name('commiss_selfbuy');		$parent_info = $this->get_member_parent_list($member_id);		if($commiss_selfbuy == 1)		{			//开启分销内购			if( $member_info['comsiss_state'] == 1 && $member_info['comsiss_flag'] == 1 )			{				$parent_info['self_go'] = array('member_id' =>$member_id, 'level_id' => $member_info['commission_level_id']);			}		}		$result = array();		if( isset($parent_info['self_go']) && !empty($parent_info['self_go']) )		{			$result['one'] = $parent_info['self_go'];			$result['two'] = $parent_info['one'];			$result['three'] = $parent_info['two'];		}else{			$result['one'] = $parent_info['one'];			$result['two'] = $parent_info['two'];			$result['three'] = $parent_info['three'];		}		$order_goods = M('eaterplanet_ecommerce_order_goods')->where( array('order_goods_id' => $order_goods_id) )->find();		 //判断是否拼团开始 goods_id		$commiss_one_money = 0;		$commiss_two_money = 0;		$commiss_three_money = 0;		$type = array('one' => 1,'two' => 1,'three' => 1);//默认是按照比例		$bili = array('one' => 0,'two' => 0,'three' => 0);//比例		$commission_info = D('Home/Pingoods')->get_goods_commission_info($order_goods['goods_id'],$member_id );		$commiss_level = D('Home/Front')->get_config_by_name('commiss_level');		if($commiss_level > 0)		{			if($commiss_level >= 1)			{				if( $commission_info['commiss_one']['type'] == 2 )				{					$commiss_one_money = $commission_info['commiss_one']['money'];					$type['one'] = 2;					$bili['one'] = $commiss_one_money;				}else{					$commiss_one_money = round( ($commission_info['commiss_one']['fen'] * $goods['total'])/100 , 2);					$bili['one'] = $commission_info['commiss_one']['fen'];				}			}			if($commiss_level >= 2)			{				if( $commission_info['commiss_two']['type'] == 2 )				{					$commiss_two_money = $commission_info['commiss_two']['money'];					$type['two'] = 2;					$bili['two'] = $commiss_two_money;				}else{					$commiss_two_money = round( ($commission_info['commiss_two']['fen'] * $goods['total'])/100 , 2);					$bili['two'] = $commission_info['commiss_two']['fen'];				}			}			if($commiss_level >= 3)			{				if( $commission_info['commiss_three']['type'] == 2 )				{					$commiss_three_money = $commission_info['commiss_three']['money'];					$type['three'] = 2;					$bili['three'] = $commiss_three_money;				}else{					$commiss_three_money = round( ($commission_info['commiss_three']['fen'] * $goods['total'])/100 , 2);					$bili['three'] = $commission_info['commiss_three']['fen'];				}			}		}		$is_commiss_order = 0;		if(!empty($order_goods))		{			$commiss_one_money = $order_goods['commiss_one_money'];			if($commiss_one_money > 0 && $result['one']['member_id'] > 0)			{				$is_commiss_order = 1;				$data = array();				$data['member_id'] = $result['one']['member_id'];				$data['child_member_id'] = $member_id;				$data['order_id'] = $order_id;				$data['uniacid'] = $uniacid;				$data['order_goods_id'] = $order_goods_id;				$data['store_id'] = $store_id;				$data['state'] = 0;				$data['level'] = 1;				$data['type'] = $type['one'];				$data['bili'] = $bili['one'];				$data['commission_level_id'] = $result['one']['level_id'];				$data['money'] = $commiss_one_money;				$data['addtime'] = time();				M('eaterplanet_ecommerce_member_commiss_order')->add($data);				$share_member = M('eaterplanet_ecommerce_member')->field('we_openid,openid')->where( array('member_id' => $result['one']['member_id'] ) )->find();				$member_formid_info = M('eaterplanet_ecommerce_member_formid')->where( "member_id=".$result['one']['member_id']." and formid != ''" )->order('id desc')->find();				//更新				/**				{{first.DATA}}				商品名称：{{keyword1.DATA}}				商品佣金：{{keyword2.DATA}}				订单状态：{{keyword3.DATA}}				{{remark.DATA}}				点击了解更多佣金详情				**/				$wx_template_data = array();				$wx_template_data['first'] = array('value' => '1级客户:'.$member_info['username'].'购买', 'color' => '#030303');				$wx_template_data['keyword1'] = array('value' => $order_goods['name'], 'color' => '#030303');				$wx_template_data['keyword2'] = array('value' => round($commiss_one_money,2).'元', 'color' => '#030303');				$wx_template_data['keyword3'] = array('value' => '支付成功', 'color' => '#030303');				$wx_template_data['remark'] = array('value' => '点击了解更多佣金详情', 'color' => '#030303');				if(!empty($share_member['openid']))				{					//$url = C('SITE_URL')."index.php?s=/tuanbonus/groupleaderindex.html";					//send_template_msg($wx_template_data,$url,$share_member['openid'],C('weixin_neworder_commiss'));				}				if(!empty($member_formid_info))				{					$template_data['keyword1'] = array('value' => 'FX'.$order_id, 'color' => '#030303');					$template_data['keyword2'] = array('value' => $order_goods['name'], 'color' => '#030303');					$template_data['keyword3'] = array('value' => round($order_goods['total'],2).'元', 'color' => '#030303');					$template_data['keyword4'] = array('value' => '1级客户购买，佣金'.$commiss_one_money.'元', 'color' => '#030303');					$template_id = D('Home/Front')->get_config_by_name('weprog_neworder_commiss');					$url = D('Home/Front')->get_config_by_name('shop_domain');					$pagepath = 'eaterplanet_ecommerce/pages/user/me';					D('Seller/User')->send_wxtemplate_msg($template_data,$url,$pagepath,$share_member['we_openid'],$template_id,$member_formid_info['formid']);					M('eaterplanet_ecommerce_member_formid')->where( array('id' => $member_formid_info['id'] ) )->save( array('state' => 1) );				}                M('eaterplanet_ecommerce_order')->where( array('order_id' => $order_id ) )->save( array('is_commission' => 1) );			}			$commiss_two_money = $order_goods['commiss_two_money'];			if($commiss_two_money > 0 && $result['two']['member_id'] > 0)			{				$is_commiss_order = 1;				$data = array();				$data['member_id'] = $result['two']['member_id'];				$data['child_member_id'] = $member_id;				$data['order_id'] = $order_id;				$data['uniacid'] = $uniacid;				$data['order_goods_id'] = $order_goods_id;				$data['store_id'] = $store_id;				$data['state'] = 0;				$data['level'] = 2;				$data['type'] = $type['two'];				$data['bili'] = $bili['two'];				$data['commission_level_id'] = $result['two']['level_id'];				$data['money'] = $commiss_two_money;				$data['addtime'] = time();				M('eaterplanet_ecommerce_member_commiss_order')->add( $data );				//TODO 发送模板消息2级下级购买，佣金多少				$share_member = M('eaterplanet_ecommerce_member')->field('we_openid,openid')->where( array('member_id' => $result['two']['member_id'] ) )->find();				$member_formid_info = M('eaterplanet_ecommerce_member_formid')->where("member_id=".$result['two']['member_id']." and formid != ''")->order('id desc')->find();				$wx_template_data = array();				$wx_template_data['first'] = array('value' => '2级客户购买', 'color' => '#030303');				$wx_template_data['keyword1'] = array('value' => $order_goods['name'], 'color' => '#030303');				$wx_template_data['keyword2'] = array('value' => round($commiss_two_money,2).'元', 'color' => '#030303');				$wx_template_data['keyword3'] = array('value' => '支付成功', 'color' => '#030303');				$wx_template_data['remark'] = array('value' => '点击了解更多佣金详情', 'color' => '#030303');				if(!empty($share_member['openid']))				{					//$url = C('SITE_URL')."index.php?s=/tuanbonus/groupleaderindex.html";					//send_template_msg($wx_template_data,$url,$share_member['openid'],C('weixin_neworder_commiss'));				}				//更新				if(!empty($member_formid_info))				{					$template_data['keyword1'] = array('value' => 'FX'.$order_id, 'color' => '#030303');					$template_data['keyword2'] = array('value' => $order_goods['name'], 'color' => '#030303');					$template_data['keyword3'] = array('value' => round($order_goods['total'],2).'元', 'color' => '#030303');					$template_data['keyword4'] = array('value' => '2级客户购买，佣金'.$commiss_two_money.'元', 'color' => '#030303');					$template_id = D('Home/Front')->get_config_by_name('weprog_neworder_commiss');					$url = D('Home/Front')->get_config_by_name('shop_domain');					$pagepath = 'eaterplanet_ecommerce/pages/user/me';					D('Seller/User')->send_wxtemplate_msg($template_data,$url,$pagepath,$share_member['we_openid'],$template_id,$member_formid_info['formid']);					M('eaterplanet_ecommerce_member_formid')->where( array('id' => $member_formid_info['id'] ) )->save( array('state' => 1) );				}                M('eaterplanet_ecommerce_order')->where( array('order_id' => $order_id ) )->save( array('is_commission' => 1) );			}			$commiss_three_money = $order_goods['commiss_three_money'];			if($commiss_three_money > 0 && $result['three']['member_id'] > 0)			{				$is_commiss_order = 1;				//TODO 发送模板消息2级下级购买，佣金多少				$data = array();				$data['member_id'] =$result['three']['member_id'];				$data['child_member_id'] = $member_id;				$data['order_id'] = $order_id;				$data['uniacid'] = $uniacid;				$data['order_goods_id'] = $order_goods_id;				$data['store_id'] = $store_id;				$data['state'] = 0;				$data['level'] = 3;				$data['type'] = $type['three'];				$data['bili'] = $bili['three'];				$data['commission_level_id'] = $result['three']['level_id'];				$data['money'] = $commiss_three_money;				$data['addtime'] = time();				M('eaterplanet_ecommerce_member_commiss_order')->add( $data );				//TODO 发送模板消息3级下级购买，佣金多少				$share_member = M('eaterplanet_ecommerce_member')->field('we_openid,openid')->where( array('member_id' =>  $result['three']['member_id'] ) )->find();				$member_formid_info = M('eaterplanet_ecommerce_member_formid')->where("member_id=".$result['three']['member_id']." and formid != ''")->order('id desc')->find();				$wx_template_data = array();				$wx_template_data['first'] = array('value' => '3级客户购买', 'color' => '#030303');				$wx_template_data['keyword1'] = array('value' => $order_goods['name'], 'color' => '#030303');				$wx_template_data['keyword2'] = array('value' => round($commiss_three_money,2).'元', 'color' => '#030303');				$wx_template_data['keyword3'] = array('value' => '支付成功', 'color' => '#030303');				$wx_template_data['remark'] = array('value' => '点击了解更多佣金详情', 'color' => '#030303');				if(!empty($share_member['openid']))				{					//$url = C('SITE_URL')."index.php?s=/tuanbonus/groupleaderindex.html";					//send_template_msg($wx_template_data,$url,$share_member['openid'],C('weixin_neworder_commiss'));				}				//更新				if(!empty($member_formid_info))				{					$template_data['keyword1'] = array('value' => 'FX'.$order_id, 'color' => '#030303');					$template_data['keyword2'] = array('value' => $order_goods['name'], 'color' => '#030303');					$template_data['keyword3'] = array('value' => round($order_goods['total'],2).'元', 'color' => '#030303');					$template_data['keyword4'] = array('value' => '3级客户购买，佣金'.$commiss_three_money.'元', 'color' => '#030303');					$template_id = D('Home/Front')->get_config_by_name('weprog_neworder_commiss');					$url = D('Home/Front')->get_config_by_name('shop_domain');					$pagepath = 'eaterplanet_ecommerce/pages/user/me';					D('Seller/User')->send_wxtemplate_msg($template_data,$url,$pagepath,$share_member['we_openid'],$template_id,$member_formid_info['formid']);					M('eaterplanet_ecommerce_member_formid')->where( array('id' => $member_formid_info['id'] ) )->save( array('state' => 1) );				}                M('eaterplanet_ecommerce_order')->where( array('order_id' => $order_id ) )->save( array('is_commission' => 1) );			}		}	}	public function get_parent_info($member_id)	{		$info = M('eaterplanet_ecommerce_member')->where( array('member_id' => $member_id ) )->find();		if( empty($info) )		{			return array();		}else{			return $info;		}	}	public function get_commission_info( $member_id )	{		$info = M('eaterplanet_ecommerce_member_commiss')->where( array('member_id' => $member_id ) )->find();		if( empty($info) )		{			$info = array();			$info['getmoney'] = 0;			$info['commission_total'] = 0;		}else{			$info['commission_total'] = $info['money'] + $info['dongmoney'] + $info['getmoney'];		}		return $info;	}	public function get_parent_member_info($member_id)	{		$member_info = M('eaterplanet_ecommerce_member')->field('agentid')->where( array('member_id' =>$member_id ) )->find();		$info = M('eaterplanet_ecommerce_member')->where( array('member_id' => $member_info['agentid'] ) )->find();		return $info;	}	public function get_member_parent_list($member_id)	{		$result = array();		$result['one'] = array('member_id' =>0,'level_id' => 0);		$result['two'] = array('member_id' =>0,'level_id' => 0);		$result['three'] = array('member_id' =>0,'level_id' => 0);		$one_info = $this->get_parent_member_info($member_id, $uniacid);		//member_id,commission_level_id		if( !empty($one_info) )		{			$result['one'] = array('member_id' => $one_info['member_id'], 'level_id' => $one_info['commission_level_id'] );			$two_info = $this->get_parent_member_info( $one_info['member_id'] , $uniacid);			if( !empty($two_info) )			{				$result['two'] = array('member_id' => $two_info['member_id'], 'level_id' => $two_info['commission_level_id'] );				if( !empty($two_info) )				{					$three_info = $this->get_parent_member_info( $two_info['member_id'] , $uniacid);					if( !empty($three_info) )					{						$result['three'] = array('member_id' => $three_info['member_id'], 'level_id' => $three_info['commission_level_id'] );					}				}			}		}		return $result;	}	/**		获取分销等级参数	**/	public function get_commission_level()	{		$level_info = array();		$default_name =  D('Home/Front')->get_config_by_name('commission_levelname');		$commiss_level = D('Home/Front')->get_config_by_name('commiss_level');		$commiss_level = empty($commiss_level) ? 0 : $commiss_level;		$default_commission =  D('Home/Front')->get_config_by_name('community_commiss1');		$default_commission2 = D('Home/Front')->get_config_by_name('community_commiss2');		$default_commission3 = D('Home/Front')->get_config_by_name('community_commiss3');		$default_name = empty($default_name) ? '默认等级': $default_name;		$default_commission = empty($default_commission) ? '0': $default_commission;		$default_commission2 = empty($default_commission2) ? '0': $default_commission2;		$default_commission3 = empty($default_commission3) ? '0': $default_commission3;		if($commiss_level < 1)		{			$default_commission = 0;			$default_commission2 = 0;			$default_commission3 = 0;		}else if($commiss_level < 2){			$default_commission2 = 0;			$default_commission3 = 0;		}else if($commiss_level < 3){			$default_commission3 = 0;		}		$level_info[0] = array('name' => $default_name, 'commission' => $default_commission,						'commission2' => $default_commission2,'commission3' => $default_commission3);		return $level_info;	}	public function get_member_commiss_order_list($member_id)	{		$list = M('eaterplanet_ecommerce_member_commiss_order')->where( array('member_id' => $member_id ) )->select();		return $list;	}	public function get_all_commiss_order_list()	{		$list = M('eaterplanet_ecommerce_member_commiss_order')->field('order_id')->group('order_id')->select();		return $list;	}	public function get_member_all_next_count($member_id)	{		$result = array('level_1_count' => 0, 'level_2_count' => 0, 'level_3_count' => 0,						'level_1_ids' => array(), 'level_2_ids' => array(),'level_3_ids' => array() );		$level_1_ids = array();		$level_2_ids = array();		$level_3_ids = array();		$level_1_list = M('eaterplanet_ecommerce_member')->field('member_id')->where( array('agentid' => $member_id) )->select();		if( !empty($level_1_list) )		{			$result['level_1_count'] = count($level_1_list);			$level_2_count =0;			$level_3_count =0;			foreach($level_1_list as $val)			{				$level_2_part = M('eaterplanet_ecommerce_member')->field('member_id')->where( array('agentid' => $val['member_id'] ) )->select();				$level_2_count += count($level_2_part);				if( !empty($level_2_part))				{					foreach($level_2_part as $vv)					{						$level_3_part = M('eaterplanet_ecommerce_member')->field('member_id')->where( array('agentid' => $vv['member_id']) )->select();						$level_3_count += count($level_3_part);						foreach($level_3_part as $vvv)						{							$level_3_ids[] = $vvv['member_id'];						}						$level_2_ids[] = $vv['member_id'];					}				}				$level_1_ids[] = $val['member_id'];			}			$result['level_2_count'] = $level_2_count;			$result['level_3_count'] = $level_3_count;		}		$total = $result['level_1_count'] + $result['level_2_count'] + $result['level_3_count'];		$result['total'] = $total;		$result['level_1_ids'] = $level_1_ids;		$result['level_2_ids'] = $level_2_ids;		$result['level_3_ids'] = $level_3_ids;		return $result;	}	public function member_next_count($member_id)	{		$buy_count = M('eaterplanet_ecommerce_member')->where( array('agentid' => $member_id ) )->count();		return $buy_count;	}	/**		成为待审核的分销客户	**/	public function become_wait_commiss_member( $member_id )	{		$commiss_sharemember_need = D('Home/Front')->get_config_by_name('commiss_sharemember_need');		if( empty($commiss_sharemember_need) )		{			$commiss_sharemember_need = 0;		}		M('eaterplanet_ecommerce_member')->where( array('member_id' => $member_id ) )->save( array('comsiss_flag' => 1,'comsiss_state' => 0,'is_share_tj' => $commiss_sharemember_need ) );		$this->commission_account($member_id);	}	/**		成为审核的分销客户	**/	public function become_commiss_member( $member_id )	{		$commiss_sharemember_need = D('Home/Front')->get_config_by_name('commiss_sharemember_need');		if( empty($commiss_sharemember_need) )		{			$commiss_sharemember_need = 0;		}		M('eaterplanet_ecommerce_member')->where( array('member_id' => $member_id ) )->save( array('comsiss_time' => time(),'comsiss_flag' => 1,'comsiss_state' => 1 ,'is_share_tj' => $commiss_sharemember_need,'is_comsiss_audit'=>1 ) );		//将未 挪动上级的客户归到当前客户的下级去		M('eaterplanet_ecommerce_member')->where( array( 'share_id' => $member_id ) )->save( array('agentid' => $member_id ) );		$this->commission_account($member_id);	}	public function commission_account($member_id)	{		$info = M('eaterplanet_ecommerce_member_commiss')->where( array('member_id' => $member_id ) )->find();		if( empty($info) )		{			$ins_data = array();			$ins_data['member_id'] = $member_id;			$ins_data['money'] = 0;			$ins_data['dongmoney'] = 0;			$ins_data['getmoney'] = 0;			$ins_data['bankname'] = '';			$ins_data['bankaccount'] = '';			$ins_data['bankusername'] = '';			M('eaterplanet_ecommerce_member_commiss')->add($ins_data);		}	}	/***		客户分销佣金申请，余额 审核流程	**/	public function send_apply_yuer( $id )	{		$info = M('eaterplanet_ecommerce_member_tixian_order')->where( array('id' => $id) )->find();		if( $info['type'] == 1 && $info['state'] == 0 )		{			$del_money = $info['money'] - $info['service_charge_money'];			if( $del_money >0 )			{				D('Admin/Member')->sendMemberMoneyChange($info['member_id'], $del_money, 9, '分销提现到余额,提现id:'.$id);			}		}		M('eaterplanet_ecommerce_member_tixian_order')->where( array('id' => $id ) )->save( array('state' => 1,'shentime' => time() ) );		$money = $info['money'];		//将冻结的钱划一部分到已提现的里面		M('eaterplanet_ecommerce_member_commiss')->where( array('member_id' => $info['member_id'] ) )->setInc('getmoney',$money );		M('eaterplanet_ecommerce_member_commiss')->where( array('member_id' => $info['member_id'] ) )->setInc('dongmoney',-$money );		return array('code' => 0,'msg' => '提现成功');	}	/**		提现到微信零钱	**/	public function send_apply_weixin_yuer($id)	{		$lib_path = dirname(dirname( dirname(__FILE__) )).'/Lib/';		require_once $lib_path."/Weixin/lib/WxPay.Api.php";		$open_weixin_qiye_pay = D('Home/Front')->get_config_by_name('open_weixin_qiye_pay');		$info = M('eaterplanet_ecommerce_member_tixian_order')->where( array('id' => $id) )->find();		if( empty($open_weixin_qiye_pay) || $open_weixin_qiye_pay ==0 )		{			return array('code' => 1,'msg' => '未开启企业付款');		}else{			if( $info['type'] == 2 && $info['state'] == 0 )			{				$del_money = $info['money'] - $info['service_charge_money'];				if( $del_money >0 )				{					$mb_info = M('eaterplanet_ecommerce_member')->field('we_openid')->where( array('member_id' =>$info['member_id'] ) )->find();					$partner_trade_no = build_order_no($info['id']);					$desc = date('Y-m-d H:i:s').'申请的提现已到账';					$username = $info['bankusername'];					$amount = $del_money * 100;					$openid = $mb_info['we_openid'];					$res = \WxPayApi::payToUser($openid,$amount,$username,$desc,$partner_trade_no,$_W['uniacid']);					if(empty($res) || $res['result_code'] =='FAIL')					{						//show_json(0, $res['err_code_des']);						return array('code' => 1,'msg' => $res['err_code_des'] );					}else{						M('eaterplanet_ecommerce_member_tixian_order')->where( array('id' => $id ) )->save( array('state' => 1,'shentime' => time() ) );						$money = $info['money'];						//将冻结的钱划一部分到已提现的里面						M('eaterplanet_ecommerce_member_commiss')->where( array('member_id' => $info['member_id'] ) )->setInc('getmoney',$money );						M('eaterplanet_ecommerce_member_commiss')->where( array('member_id' => $info['member_id'] ) )->setInc('dongmoney',-$money );						return array('code' => 0,'msg' => '提现成功');					}				}			}else{				return array('code' => 1,'msg' => '已提现');			}		}	}	public function send_apply_success_msg($apply_id)	{		$apply_info = M('eaterplanet_ecommerce_member_tixian_order')->where( array('id' => $apply_id) )->find();		$member_info = M('eaterplanet_ecommerce_member')->field('we_openid')->where( array('member_id' => $apply_info['member_id'] ) )->find();		switch($apply_info['type'])		{			case 1:				$bank_name = '余额';			break;			case 2:				$bank_name = '微信余额';			break;			case 3:				$bank_name = '支付宝';			break;			case 4:				$bank_name = '银行卡';			break;		}		$dao_zhang = floatval( $apply_info['money']-$apply_info['service_charge_money']);		$template_data = array();		$template_data['keyword1'] = array('value' => sprintf("%01.2f", $apply_info['money']), 'color' => '#030303');		$template_data['keyword2'] = array('value' => $apply_info['service_charge_money'], 'color' => '#030303');		$template_data['keyword3'] = array('value' => sprintf("%01.2f", $dao_zhang), 'color' => '#030303');		$template_data['keyword4'] = array('value' => $bank_name, 'color' => '#030303');		$template_data['keyword5'] = array('value' => '提现成功', 'color' => '#030303');		$template_data['keyword6'] = array('value' => date('Y-m-d H:i:s' , $apply_info['addtime']), 'color' => '#030303');		$template_data['keyword7'] = array('value' => date('Y-m-d H:i:s' , $apply_info['shentime']), 'color' => '#030303');		$template_id =  D('Home/Front')->get_config_by_name('weprogram_template_apply_tixian');		$url = D('Home/Front')->get_config_by_name('shop_domain');		$pagepath = 'eaterplanet_ecommerce/pages/user/me';			$mb_subscribe  = M('eaterplanet_ecommerce_subscribe')->where( array('member_id' =>$apply_info['member_id'], 'type' => 'apply_tixian' ) )->find();			//...todo			if( !empty($mb_subscribe) )			{				$template_id = D('Home/Front')->get_config_by_name('weprogram_subtemplate_apply_tixian');				$template_data = array();				$template_data['amount1'] = array('value' => sprintf("%01.2f", $apply_info['money']) );				$template_data['amount2'] = array('value' => sprintf("%01.2f", $apply_info['service_charge_money']) );				$template_data['thing3'] = array('value' => $bank_name );				$template_data['thing4'] = array('value' => '提现成功' );				D('Seller/User')->send_subscript_msg( $template_data,$url,$pagepath,$member_info['we_openid'],$template_id);				M('eaterplanet_ecommerce_subscribe')->where( array('id' => $mb_subscribe['id'] ) )->delete();			}			$wx_template_data = array();			$weixin_appid = D('Home/Front')->get_config_by_name('weixin_appid' );			$weixin_template_apply_tixian = D('Home/Front')->get_config_by_name('weixin_template_apply_tixian');			if( !empty($weixin_appid) && !empty($weixin_template_apply_tixian) )			{				$wx_template_data = array(									'appid' => $weixin_appid,									'template_id' => $weixin_template_apply_tixian,									'pagepath' => $pagepath,									'data' => array(													'first' => array('value' => '尊敬的用户，您的提现已到账','color' => '#030303'),													'keyword1' => array('value' => date('Y-m-d H:i:s' , $apply_info['addtime']),'color' => '#030303'),													'keyword2' => array('value' => $community_head_commiss_info['bankname'],'color' => '#030303'),													'keyword3' => array('value' => sprintf("%01.2f", $apply_info['money']),'color' => '#030303'),													'keyword4' => array('value' => $apply_info['service_charge'],'color' => '#030303'),													'keyword5' => array('value' => sprintf("%01.2f", $dao_zhang),'color' => '#030303'),													'remark' => array('value' => '请及时进行对账','color' => '#030303'),											)								);			}			D('Seller/User')->send_wxtemplate_msg($template_data,$url,$pagepath,$member_info['we_openid'],$template_id,$member_formid_info['formid'] , 0,$wx_template_data);	}	/***		提现到支付宝，提现到银行卡	**/	public function send_apply_alipay_bank($id)	{		$info = M('eaterplanet_ecommerce_member_tixian_order')->where( array('id' => $id ) )->find();		if( ( $info['type'] == 3 || $info['type'] == 4) && $info['state'] == 0 )		{			M('eaterplanet_ecommerce_member_tixian_order')->where( array('id' => $id ) )->save( array('state' => 1,'shentime' => time() ) );			$money = $info['money'];			//将冻结的钱划一部分到已提现的里面			M('eaterplanet_ecommerce_member_commiss')->where( array('member_id' => $info['member_id'] ) )->setInc('getmoney',$money );			M('eaterplanet_ecommerce_member_commiss')->where( array('member_id' => $info['member_id'] ) )->setInc('dongmoney',-$money );			return array('code' => 0,'msg' => '提现成功');		}else{			return array('code' => 1,'msg' => '已提现');		}	}}?>