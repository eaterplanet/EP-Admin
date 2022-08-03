<?phpnamespace Home\Model;use Think\Model;/** * 万能表单模型 * @author Albert.Z * */class AllformModel {	public $table = 'pin';	/**	 * @desc 获取万能表单信息	 * @param $id	 * @return mixed	 */	public function getFormsById( $id )	{		$forms_data = M('eaterplanet_ecommerce_forms')->where( array('id' => $id) )->find();		return $forms_data;	}	/**	 * @desc 获取下单表单信息	 * @return array	 */	public function getOrderForms(){		$need_data = [];		$form_list = [];		$is_open_allform = D('Home/Front')->get_config_by_name('is_open_allform');		$is_open_orderform = D('Home/Front')->get_config_by_name('is_open_orderform');		if($is_open_allform == 1 && $is_open_orderform == 1){			$is_open_orderform = 1;		}else{			$is_open_orderform = 0;		}		$order_allform_id = D('Home/Front')->get_config_by_name('order_allform_id');		if($is_open_allform == 1 && $is_open_orderform == 1 && !empty($order_allform_id)){			$form_list = $this->getFormsContentById($order_allform_id);		}		$need_data['is_open_orderform'] = $is_open_orderform;		$need_data['order_allform_id'] = $order_allform_id;		$need_data['form_list'] = $form_list;		return $need_data;	}	/**	 * @desc 获取表单项列表	 * @param $form_id	 * @return array|mixed	 */	public function getFormsContentById($form_id){		$forms_data = $this->getFormsById($form_id);		$form_list = [];		if(!empty($forms_data)){			$form_list = unserialize($forms_data['form_content']);		}		return $form_list;	}	/**	 * @desc 保存表单信息和表单项信息	 * @param $type 表单类型：goods 商品表单，order 订单表单，apply 申请表单	 * @param $data	 * @return mixed	 */	public function insertFormInfo($type, $data){		$allform_id = $data['allform_id'];		$allform_list = $data['allform_list'];		if(!empty($allform_id) && !empty($allform_list)){			$form_info = [];			$form_info['form_id'] = $allform_id;			$form_collect = $this->getFormsById($allform_id);			$form_info['form_name'] = $form_collect['form_name'];			$form_info['form_type'] = $type;			if($type == 'order'){//订单表单				$form_info['order_id'] = $data['order_id'];				$form_info['order_number'] = $data['order_number'];				$form_info['user_id'] = $data['member_id'];			}else if($type == 'goods'){//商品表单				$form_info['order_id'] = $data['order_id'];				$form_info['order_number'] = $data['order_number'];				$form_info['user_id'] = $data['member_id'];				$form_info['goods_id'] = $data['goods_id'];			}			$form_info['addtime'] = time();			$id = M('eaterplanet_ecommerce_form_info')->add($form_info);			if($id !== false){				$form_list = unserialize(json_decode($allform_list));				if(!empty($form_list)){					//保存表单项信息					foreach($form_list as $k=>$v){						$form_item = [];						$form_item['form_id'] = $id;						$form_item['type'] = $v['type'];						$form_item['random_code'] = $v['random_code'];						$form_item['item_name'] = $v['title'];						$form_item['item_val'] = $v['item_value'];						$form_item['addtime'] = time();						$item_id = M('eaterplanet_ecommerce_form_item')->add($form_item);					}				}			}			return $id;		}	}	/**	 * @desc 获取万能表单信息	 * @param $id	 * @return mixed	 */	public function getFormInfoByWhere( $condition )	{		$forms_data = M('eaterplanet_ecommerce_form_info')->where( $condition )->find();		return $forms_data;	}	public function getOrderFormInfo($order_id, $member_id){		$condition = [];		$condition['order_id'] = $order_id;		$condition['user_id'] = $member_id;		$condition['form_type'] = 'order';		$order_form_data = $this->getFormInfo($condition);		return $order_form_data;	}	/**	 * @desc 通过条件获取表单信息	 * @param $form_id	 * @return mixed	 */	public function getFormItemListByFormId($form_id){		$form_item_list = M('eaterplanet_ecommerce_form_item')->where( array('form_id'=>$form_id) )->order('id asc')->select();		return $form_item_list;	}	/**	 * @desc 通过条件获取表单信息及表单子项	 * @param $condition	 * @return array	 */	public function getFormInfo($condition){		$form_data = [];		$form_info = $this->getFormInfoByWhere($condition);		if(!empty($form_info)){			$form_id = $form_info['id'];			$form_list = $this->getFormItemListByFormId($form_id);			if(!empty($form_list)){				$item_list = [];				foreach($form_list as $k=>$v){					$item_list[$k]['item_name'] = $v['item_name'];					if($v['type'] == 'image'){						$item_list[$k]['item_val'] = explode(',', $v['item_val']);					}else{						$item_list[$k]['item_val'] = $v['item_val'];					}					$item_list[$k]['type'] = $v['type'];				}				$form_data['form_list'] = $item_list;				$form_data['form_name'] = $form_info['form_name'];				$form_data['form_type'] = $form_info['form_type'];			}		}		return $form_data;	}}