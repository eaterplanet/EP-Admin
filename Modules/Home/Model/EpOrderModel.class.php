<?phpnamespace Home\Model;use Think\Model;/** * 新订单模型服务类 * @author Albert.Z * */class EpOrderModel {	/**		@author yj 2020-06-16		@desc 根据订单id 获取订单商品列表信息	**/    public function getOrderGoodsByOrderId( $order_id )	{		$order_info = M('eaterplanet_ecommerce_order')->where( array('order_id' => $order_id) )->find();		//开启自动取消订单		$open_auto_delete = D('Home/Front')->get_config_by_name('open_auto_delete');	    //自动删除的时间	    $cancle_hour = D('Home/Front')->get_config_by_name('auto_cancle_order_time');		$cancle_hour_time = time() - 3600 * $cancle_hour;	    $url = D('Home/Front')->get_config_by_name('shop_domain');		//判断是否需要取消订单		//order_status_id 3 open_auto_delete		if($open_auto_delete == 1 && $order_info['order_status_id'] == 3 &&  $order_info['date_added'] < $cancle_hour_time )		{			D('Home/Frontorder')->cancel_order($order_info['order_id'],  true);			$order_info['order_status_id'] == 5;		}		$order_info['createTime'] = date('Y-m-d H:i:s', $order_info['date_added']);		if($order_info['shipping_fare']<=0.001 || $order_info['delivery'] == 'pickup')		{			$order_info['shipping_fare'] = '免运费';		}else{			$order_info['shipping_fare'] = ''.$order_info['shipping_fare'];		}		if($order_info['order_status_id'] == 10)		{			$order_info['status_name'] = '等待退款';		}		else if($order_info['order_status_id'] == 4 && $order_info['delivery'] =='pickup')		{			//delivery 6			$order_info['status_name'] = '待自提';			//已自提		}		else if($order_info['order_status_id'] == 6 && $order_info['delivery'] =='pickup')		{			//delivery 6			$order_info['status_name'] = '已自提';			//已自提		}		$quantity = 0;		$goods_list = M('eaterplanet_ecommerce_order_goods')->field('order_id,order_goods_id,head_disc,member_disc,level_name,goods_id,is_pin,shipping_fare,name,goods_images,quantity,price,total,fullreduction_money,voucher_credit,rela_goodsoption_valueid,is_refund_state,has_refund_money,has_refund_quantity')->where( array('order_id' => $order_info['order_id']) )->select();		$total_commision = 0;		if($order_info['delivery'] =='tuanz_send')		{			$total_commision += $order_info['shipping_fare'];		}		foreach($goods_list as $kk => $vv)		{			//commision			if($is_tuanz == 1){				$community_order_info = M('eaterplanet_community_head_commiss_order')->where( array('head_id' => $community_info['id'],'order_goods_id' => $vv['order_goods_id']) )->find();				if(!empty($community_order_info))				{					$vv['commision'] = $community_order_info['money']-$community_order_info['add_shipping_fare'];					$vv['commision'] = sprintf("%.2f",$vv['commision']);					if($community_order_info['state'] == 2){						$vv['commision'] = 0;					}					$total_commision += $vv['commision'];				}else{					$vv['commision'] = "0.00";				}				$vv['head_shipping_fare'] = $community_order_info['add_shipping_fare'];//团长配送费				$vv['old_commision'] = $vv['commision'];				$vv['del_commision'] = 0;				//fen_type				$vv['fen_type'] = $community_order_info['fen_type'];// 0 按照比例， 1按照金额				$vv['fen_bili'] = $community_order_info['bili'];//比例				$vv['fen_gumoney'] = $community_order_info['bili'];//按照金额				$order_jishu = $vv['total'] -$vv['fullreduction_money']-$vv['voucher_credit']-$vv['has_refund_money'];				$vv['order_jishu'] = $order_jishu;//有效金额：（基数）				//has_refund_commission = 0				$order_goods_refund_list = M('eaterplanet_ecommerce_order_goods_refund')->where( array('order_id' => $order_info['order_id'],'order_goods_id' => $vv['order_goods_id'] ) )->select();				if( !empty($order_goods_refund_list) )				{					$kvbal_total_back_head_orderbuycommiss = 0;//合计退掉佣金					foreach( $order_goods_refund_list as $kvval )					{						$kvbal_total_back_head_orderbuycommiss += $kvval['back_head_orderbuycommiss'];					}					$vv['del_commision'] = $kvbal_total_back_head_orderbuycommiss;					$vv['old_commision'] += $vv['del_commision'];				}			}			$order_option_list = M('eaterplanet_ecommerce_order_option')->where( array('order_goods_id' => $vv['order_goods_id']) )->select();			if( !empty($vv['goods_images']))			{				$goods_images = $url. '/'.resize($vv['goods_images'],400,400);				if(is_array($goods_images))				{					$vv['goods_images'] = $vv['goods_images'];				}else{					 $vv['goods_images']= $url.'/'.resize($vv['goods_images'],400,400) ;				}			}else{				 $vv['goods_images']= '';			}			$goods_filed = M('eaterplanet_ecommerce_goods')->field('productprice as price')->where( array('id' => $vv['goods_id']) )->find();			$vv['orign_price'] = $goods_filed['price'];			$quantity += $vv['quantity'];			foreach($order_option_list as $option)			{				$vv['option_str'][] = $option['value'];			}			if( !isset($vv['option_str']) )			{				$vv['option_str'] = '';			}else{				$vv['option_str'] = implode(',', $vv['option_str']);			}			 // $vv['price'] = round($vv['price'],2);			$vv['price'] = sprintf("%.2f",$vv['price']);			$vv['orign_price'] = sprintf("%.2f",$vv['orign_price']);			$vv['total'] = sprintf("%.2f",$vv['total']);			if( $vv['is_refund_state'] == 1 || ($vv['has_refund_money'] > 0 && $vv['has_refund_quantity'] > 0) )			{				$vv['is_refund_state'] = 1;				$where = " order_id = '".$vv['order_id']."' and order_goods_id = '".$vv['order_goods_id']."' and state in (0,2,3) ";				$refund_info = M('eaterplanet_ecommerce_order_refund')->field('ref_id,order_id,ref_money,real_refund_quantity,state')->where( $where )->find();				if(!empty($refund_info)){					$vv['refund_info'] = $refund_info;				}else{					$refund_info = array();					$refund_info['order_id'] = $order_info['order_id'];					$refund_info['ref_money'] = $vv['has_refund_money'];					$refund_info['real_refund_quantity'] = $vv['has_refund_quantity'];					$refund_info['state'] = 3;					$vv['refund_info'] = $refund_info;				}			}			$goods_list[$kk] = $vv;		}		$order_info['total_commision'] = $total_commision;		$order_info['quantity'] = $quantity;		if( empty($order_info['store_id']) )		{			$order_info['store_id'] = 1;		}		$store_info	= array('s_true_name' =>'','s_logo' => '');		$store_info['s_true_name'] = D('Home/Front')->get_config_by_name('shoname');		$store_info['s_logo'] = D('Home/Front')->get_config_by_name('shoplogo');		if( !empty($store_info['s_logo']))		{			$store_info['s_logo'] = tomedia($store_info['s_logo']);		}else{			$store_info['s_logo'] = '';		}		$order_goods['store_info'] = $store_info;		$order_info['store_info'] = $store_info;		$order_info['goods_list'] = $goods_list;		if($order_info['type'] == 'integral')		{			//暂时屏蔽积分			$order_info['score'] =  round($order_info['total'],2);		}		$order_info['total'] = $this->calOrderTotal( $order_info );		if($order_info['total'] < 0)		{			$order_info['total'] = 0;		}		$order_info['total'] = sprintf("%.2f",$order_info['total']);		return $order_info;	}	/**		计算订单的total 总计	**/	public function calOrderTotal( $order_info )	{		$total = $order_info['total'] + $order_info['packing_fare'] + $order_info['shipping_fare']-$order_info['voucher_credit']-$order_info['fullreduction_money']-$order_info['score_for_money'];		return $total;	}}?>