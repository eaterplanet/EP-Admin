// 顶部内容组件
var specialTopConHtml = '<div>';
	specialTopConHtml += 	'<template v-if="data.style == 1">';
	specialTopConHtml += 		'<div class="goods-head">';
	specialTopConHtml +=			'<div class="title-wrap">';
	// specialTopConHtml +=		'<div class="left-icon" v-if="list.imageUrl"><img v-bind:src="$parent.$parent.changeImgUrl(list.imageUrl)" /></div>';
	// specialTopConHtml +=		'<span class="name">{{list.title}}</span>';
	specialTopConHtml +=				'<template v-for="(item, index) in list" v-if="item.style == 1">';
	specialTopConHtml +=					'<div class="left-icon" v-if="item.imageUrl && item.imageUrl.split(\'/\')[0] == \'public\'"><img v-bind:src="imgUrl1" /></div>';
	specialTopConHtml +=					'<div class="left-icon" v-if="item.imageUrl && item.imageUrl.split(\'/\')[0] != \'public\'"><img v-bind:src="$parent.$parent.changeImgUrl(item.imageUrl)" /></div>';
	specialTopConHtml +=					'<span class="name">{{item.title}}</span>';
	specialTopConHtml +=				'</template>';
	specialTopConHtml +=			'</div>';
	
	specialTopConHtml +=			'<div class="more violet" v-if="data.bgSelect==\'violet\'">';
	specialTopConHtml +=				'<span>';
	specialTopConHtml +=					'<span style="color: #8662FD;">更多</span>';
	specialTopConHtml +=					'<span style="color: #627BFD;">拼团</span>';
	specialTopConHtml +=				'</span>';
	specialTopConHtml +=				'<i class="iconfont iconyoujiantou" style="color: #627BFD;"></i>';
	specialTopConHtml +=			'</div>';
	
	specialTopConHtml +=			'<div class="more red" v-if="data.bgSelect==\'red\'">';
	specialTopConHtml +=				'<span>';
	specialTopConHtml +=					'<span style="color: #FF7B91;">更多</span>';
	specialTopConHtml +=					'<span style="color: #FF5151;">拼团</span>';
	specialTopConHtml +=				'</span>';
	specialTopConHtml +=				'<i class="iconfont iconyoujiantou" style="color: #FF5151;"></i>';
	specialTopConHtml +=			'</div>';
	
	specialTopConHtml +=			'<div class="more blue" v-if="data.bgSelect==\'blue\'">';
	specialTopConHtml +=				'<span>';
	specialTopConHtml +=					'<span style="color: #12D0AE;">更多</span>';
	specialTopConHtml +=					'<span style="color: #0ECFD3;">拼团</span>';
	specialTopConHtml +=				'</span>';
	specialTopConHtml +=				'<i class="iconfont iconyoujiantou" style="color: #0ECFD3;"></i>';
	specialTopConHtml +=			'</div>';
	
	specialTopConHtml +=			'<div class="more yellow" v-if="data.bgSelect==\'yellow\'">';
	specialTopConHtml +=				'<span>';
	specialTopConHtml +=					'<span style="color: #FEB632;">更多</span>';
	specialTopConHtml +=					'<span style="color: #FE6232;">拼团</span>';
	specialTopConHtml +=				'</span>';
	specialTopConHtml +=				'<i class="iconfont iconyoujiantou" style="color: #FE6232;"></i>';
	specialTopConHtml +=			'</div>';
	specialTopConHtml +=		'</div>';
	specialTopConHtml +=	'</template>';
	
	specialTopConHtml +=	'<template v-if="data.style == 2">';
	specialTopConHtml +=		'<div class="title-wrap title-wrap-2">';
	specialTopConHtml +=			'<div class="title-left">';
	specialTopConHtml +=				'<template v-for="(item, index) in list" v-if="item.style == 2">';
	specialTopConHtml +=					'<img v-if="item.imageUrl && item.imageUrl.split(\'/\')[0] == \'public\'" :src="imgUrl2" />';
	specialTopConHtml +=					'<img v-if="item.imageUrl && item.imageUrl.split(\'/\')[0] != \'public\'" :src="$parent.$parent.changeImgUrl(item.imageUrl)" />';
	specialTopConHtml +=				'</template>';
	specialTopConHtml +=			'</div>';
	specialTopConHtml +=			'<div class="title-right"><span>更多拼团</span><i class="iconfont iconyoujiantou"></i>	</div>';
	specialTopConHtml +=		'</div>';
	specialTopConHtml +=	'</template>';
	
	specialTopConHtml +=	'<template v-if="data.style == 3">';
	specialTopConHtml +=		'<div class="title-wrap title-wrap-3">';
	specialTopConHtml +=			'<div class="title-left">';
	specialTopConHtml +=				'<template v-for="(item, index) in list" v-if="item.style == 3">';
	specialTopConHtml +=					'<img v-if="item.imageUrl && item.imageUrl.split(\'/\')[0] == \'public\'" :src="imgUrl3" />';
	specialTopConHtml +=					'<img v-if="item.imageUrl && item.imageUrl.split(\'/\')[0] != \'public\'" :src="$parent.$parent.changeImgUrl(item.imageUrl)" />';
	specialTopConHtml +=				'</template>';
	specialTopConHtml +=			'</div>';
	specialTopConHtml +=		'</div>';
	specialTopConHtml +=	'</template>';

	specialTopConHtml += 	'<template v-if="data.style == 4">';
	specialTopConHtml += 		'<div class="goods-head">';
	specialTopConHtml +=			'<div class="title-wrap">';
	specialTopConHtml +=				'<template v-for="(item, index) in list" v-if="item.style == 4">';
	specialTopConHtml +=					'<div class="left-icon" v-if="item.imageUrl && item.imageUrl.split(\'/\')[0] == \'public\'"><img v-bind:src="imgUrl1" /></div>';
	specialTopConHtml +=					'<div class="left-icon" v-if="item.imageUrl && item.imageUrl.split(\'/\')[0] != \'public\'"><img v-bind:src="$parent.$parent.changeImgUrl(item.imageUrl)" /></div>';
	specialTopConHtml +=					'<span class="name">{{item.title}}</span>';
	specialTopConHtml +=				'</template>';
	specialTopConHtml +=			'</div>';
	
	specialTopConHtml +=			'<div class="more violet" v-if="data.bgSelect==\'violet\'">';
	specialTopConHtml +=				'<span>';
	specialTopConHtml +=					'<span style="color: #8662FD;">更多</span>';
	specialTopConHtml +=					'<span style="color: #627BFD;">拼团</span>';
	specialTopConHtml +=				'</span>';
	specialTopConHtml +=				'<i class="iconfont iconyoujiantou" style="color: #627BFD;"></i>';
	specialTopConHtml +=			'</div>';
	
	specialTopConHtml +=			'<div class="more red" v-if="data.bgSelect==\'red\'">';
	specialTopConHtml +=				'<span>';
	specialTopConHtml +=					'<span style="color: #FF7B91;">更多</span>';
	specialTopConHtml +=					'<span style="color: #FF5151;">拼团</span>';
	specialTopConHtml +=				'</span>';
	specialTopConHtml +=				'<i class="iconfont iconyoujiantou" style="color: #FF5151;"></i>';
	specialTopConHtml +=			'</div>';
	
	specialTopConHtml +=			'<div class="more blue" v-if="data.bgSelect==\'blue\'">';
	specialTopConHtml +=				'<span>';
	specialTopConHtml +=					'<span style="color: #12D0AE;">更多</span>';
	specialTopConHtml +=					'<span style="color: #0ECFD3;">拼团</span>';
	specialTopConHtml +=				'</span>';
	specialTopConHtml +=				'<i class="iconfont iconyoujiantou" style="color: #0ECFD3;"></i>';
	specialTopConHtml +=			'</div>';
	
	specialTopConHtml +=			'<div class="more yellow" v-if="data.bgSelect==\'yellow\'">';
	specialTopConHtml +=				'<span>';
	specialTopConHtml +=					'<span style="color: #FEB632;">更多</span>';
	specialTopConHtml +=					'<span style="color: #FE6232;">拼团</span>';
	specialTopConHtml +=				'</span>';
	specialTopConHtml +=				'<i class="iconfont iconyoujiantou" style="color: #FE6232;"></i>';
	specialTopConHtml +=			'</div>';
	specialTopConHtml +=		'</div>';
	specialTopConHtml +=	'</template>';
	/* specialTopConHtml +=	'<div class="more ns-red-color" v-if="listMore.title">';
	specialTopConHtml +=		'<span v-bind:style="{color: data.moreTextColor?data.moreTextColor:\'rgba(0,0,0,0)\'}">{{listMore.title}}</span>';
	specialTopConHtml +=		'<div class="right-icon" v-if="listMore.imageUrl"><img v-bind:src="$parent.$parent.changeImgUrl(listMore.imageUrl)" /></div>';
	specialTopConHtml +=		'<i class="iconfont iconyoujiantou" v-else v-bind:style="{color: data.moreTextColor?data.moreTextColor:\'rgba(0,0,0,0)\'}"></i>';
	specialTopConHtml +=	'</div>'; */
	specialTopConHtml +='</div>';

Vue.component("special-top-content", {
	data: function () {
		return {
			data: this.$parent.data,
			list: this.$parent.data.list,
			listMore: this.$parent.data.listMore,
			imgUrl1: "",
			imgUrl2: "",
			imgUrl3: "",
			imgUrl4: ""
		}
	},
	created: function () {
		this.imgUrl1 = this.list[0].imageUrl;
		this.imgUrl2 = this.list[1].imageUrl;
		this.imgUrl3 = this.list[2].imageUrl;
		this.imgUrl4 = this.list[3].imageUrl;
		
		if(!this.$parent.data.verify) this.$parent.data.verify = [];
		this.$parent.data.verify.push(this.verify);//加载验证方法
	},
	methods: {
		verify : function () {
			var res = { code : true, message : "" };
			return res;
		},
	},
	template: specialTopConHtml
});

/**
 * 空的验证组件，后续如果增加业务，则更改组件
 */
var specialListHtml = '<div class="goods-list-edit layui-form">';

		specialListHtml += '<div class="layui-form-item ns-icon-radio">';
			specialListHtml += '<label class="layui-form-label sm">商品来源</label>';
			specialListHtml += '<div class="layui-input-block">';
				specialListHtml += '<template v-for="(item, index) in goodsSources" v-bind:k="index">';
					specialListHtml += '<span :class="[item.value == data.sources ? \'\' : \'layui-hide\']">{{item.text}}</span>';
				specialListHtml += '</template>';
				specialListHtml += '<ul class="ns-icon">';
					specialListHtml += '<li v-for="(item, index) in goodsSources" v-bind:k="index" :class="[item.value == data.sources ? \'ns-text-color ns-border-color ns-bg-color-diaphaneity\' : \'\']" @click="data.sources=item.value">';
						specialListHtml += '<img v-if="item.value == data.sources" :src="item.selectedSrc" />'
						specialListHtml += '<img v-else :src="item.src" />'
					specialListHtml += '</li>';
				specialListHtml += '</ul>';
			
				/* specialListHtml += '<template v-for="(item,index) in goodsSources" v-bind:k="index">';
					specialListHtml += '<div v-on:click="data.sources=item.value" v-bind:class="{ \'layui-unselect layui-form-radio\' : true,\'layui-form-radioed\' : (data.sources==item.value) }"><i class="layui-anim layui-icon">&#xe63f;</i><div>{{item.text}}</div></div>';
				specialListHtml += '</template>'; */
			specialListHtml += '</div>';
		specialListHtml += '</div>';
		
		specialListHtml += '<div class="layui-form-item" v-if="data.sources == \'diy\'">';
			specialListHtml += '<label class="layui-form-label sm">手动选择</label>';
			specialListHtml += '<div class="layui-input-block">';
				specialListHtml += '<a href="#" class="ns-input-text selected-style" v-on:click="addGoods">选择<i class="layui-icon layui-icon-right"></i></a>';
			specialListHtml += '</div>';
		specialListHtml += '</div>';
		
		/* specialListHtml += '<div class="layui-form-item" v-show="data.sources == \'default\'">';
			specialListHtml += '<label class="layui-form-label sm">商品数量</label>';
			specialListHtml += '<div class="layui-input-block">';
				specialListHtml += '<input type="number" class="layui-input goods-account" v-on:keyup="shopNum" v-model="data.goodsCount"/>';
			specialListHtml += '</div>';
		specialListHtml += '</div>';
		
		specialListHtml += '<div class="layui-form-item" v-show="data.sources == \'default\'">';
			specialListHtml += '<label class="layui-form-label sm"></label>';
			specialListHtml += '<div class="layui-input-block">';
				specialListHtml += '<template v-for="(item,index) in goodsCount" v-bind:k="index">';
					specialListHtml += '<div v-on:click="data.goodsCount=item" v-bind:class="{ \'layui-unselect layui-form-radio\' : true,\'layui-form-radioed\' : (data.goodsCount==item) }"><i class="layui-anim layui-icon">&#xe63f;</i><div>{{item}}</div></div>';
				specialListHtml += '</template>';
			specialListHtml += '</div>';
		specialListHtml += '</div>'; */
		
		specialListHtml += '<slide v-bind:data="{ field : \'goodsCount\', label: \'商品数量\', max: 9, min: 1}" v-show="data.sources == \'default\'"></slide>';

		// specialListHtml += '<p class="hint">商品数量选择 0 时，前台会自动上拉加载更多</p>';
		
	specialListHtml += '</div>';

var select_goods_list = []; //配合商品选择器使用
Vue.component("special-list", {
	template: specialListHtml,
	data: function () {
		return {
			data: this.$parent.data,
			goodsSources: [
				{
					text: "默认",
					value: "default",
					src: specialResourcePath + "/special/img/goods.png",
					selectedSrc: specialResourcePath + "/special/img/goods_1.png"
				},
				{
					text : "手动选择",
					value : "diy",
					src: specialResourcePath + "/special/img/manual.png",
					selectedSrc: specialResourcePath + "/special/img/manual_1.png"
				}
			],
			categoryList: [],
			isLoad: false,
			isShow: false,
			selectIndex: 0,//当前选中的下标
			goodsCount: [6, 12, 18, 24, 30],
		}
	},
	created:function() {
		if(!this.$parent.data.verify) this.$parent.data.verify = [];
		this.$parent.data.verify.push(this.verify);//加载验证方法
	},
	methods: {
		shopNum: function () {
			if (this.$parent.data.goodsCount > 50) {
				layer.msg("商品数量最多为50");
				this.$parent.data.goodsCount = 50;
			}
			if (this.$parent.data.goodsCount.length > 0 && this.$parent.data.goodsCount < 1) {
				layer.msg("商品数量不能小于0");
				this.$parent.data.goodsCount = 1;
			}
		},
		verify: function () {
			var res = {code: true, message: ""};
			if (this.data.goodsCount.length === 0) {
				res.code = false;
				res.message = "请输入商品数量";
			}
			if (this.data.goodsCount < 0) {
				res.code = false;
				res.message = "商品数量不能小于0";
			}
			if (this.data.goodsCount > 50) {
				res.message = "商品数量最多为50";
			}
			return res;
		},
		addGoods: function () {
			var self = this;

			goodsSelect(function (res) {

				// if (!res.length) return false;
				// self.$parent.data.goodsId = [];
				// for (var i = 0; i < res.length; i++) {
				// 	self.$parent.data.goodsId.push(res[i]);
				// }
				self.$parent.data.goodsId = res;

			}, self.$parent.data.goodsId, {mode: "spu", promotion: "special", disabled: 0, post: post});
		}
	}
});

var specialStyleHtml = '<div class="layui-form-item">';
		specialStyleHtml += '<label class="layui-form-label sm">选择风格</label>';
		specialStyleHtml += '<div class="layui-input-block">';
			// specialStyleHtml += '<span>{{data.styleName}}</span>';
			specialStyleHtml += '<div v-if="data.styleName" class="ns-input-text ns-text-color selected-style" v-on:click="selectGroupbuyStyle">{{data.styleName}} <i class="layui-icon layui-icon-right"></i></div>';
			specialStyleHtml += '<div v-else class="ns-input-text selected-style" v-on:click="selectGroupbuyStyle">选择 <i class="layui-icon layui-icon-right"></i></div>';
		specialStyleHtml += '</div>';
	specialStyleHtml += '</div>';

Vue.component("special-style", {
	template: specialStyleHtml,
	data: function() {
		return {
			data: this.$parent.data,
		}
	},
	created:function() {
		if(!this.$parent.data.verify) this.$parent.data.verify = [];
		this.$parent.data.verify.push(this.verify);//加载验证方法
	},
	methods: {
		verify: function () {
			var res = { code: true, message: "" };
			return res;
		},
		selectGroupbuyStyle: function() {
			var self = this;
			layer.open({
				type: 1,
				title: '风格选择',
				area:['930px','630px'],
				btn: ['确定', '返回'],
				content: $(".draggable-element[data-index='" + self.data.index + "'] .edit-attribute .pintuan-list-style").html(),
				success: function(layero, index) {
					$(".layui-layer-content input[name='style']").val(self.data.style);
					$(".layui-layer-content input[name='style_name']").val(self.data.styleName);
					$("body").on("click", ".layui-layer-content .style-list-con-pintuan .style-li-pintuan", function () {
						$(this).addClass("selected ns-border-color").siblings().removeClass("selected ns-border-color");
						$(".layui-layer-content input[name='style']").val($(this).index() + 1);
						$(".layui-layer-content input[name='style_name']").val($(this).find("span").text());
					});
				},
				yes: function (index, layero) {
					self.data.style = $(".layui-layer-content input[name='style']").val();
					self.data.styleName = $(".layui-layer-content input[name='style_name']").val();
					layer.closeAll()
				}
			});
		},
	}
})

// 图片上传
var specialTopHtml = '<ul class="fenxiao-addon-title">';
		specialTopHtml += '<li>';
			// specialTopHtml += '<template v-if="data.style == 1">';
			// 	specialTopHtml += '<div class="layui-form-item">';
			// 		specialTopHtml += '<label class="layui-form-label sm">顶部图片</label>';
			// 		specialTopHtml += '<template v-for="(item, index) in list" v-if="item.style == data.style">';
			// 			specialTopHtml += '<div class="layui-input-block ns-img-upload">';
			// 				specialTopHtml += '<img-sec-upload v-bind:data="{ data : item, text: \'\' }"></img-sec-upload>';
			// 			specialTopHtml += '</div>';
			// 		specialTopHtml += '</template>';
			// 		specialTopHtml += '<div class="ns-word-aux ns-diy-word-aux">建议上传顶部图片大小：710px * 300px</div>';
			// 	specialTopHtml += '</div>';
			// specialTopHtml += '</template>';
			specialTopHtml += '<template v-if="data.style == 1">';
				specialTopHtml += '<div class="layui-form-item">';
					specialTopHtml += '<label class="layui-form-label sm">选择专题</label>';
					specialTopHtml += '<div class="layui-input-block">';
						specialTopHtml += '<a href="#" class="ns-input-text ns-text-color selected-style" v-on:click="addSpecial">{{data.specialName?data.specialName:"选择"}}<i class="layui-icon layui-icon-right"></i></a>';
					specialTopHtml += '</div>';
				specialTopHtml += '</div>';
			specialTopHtml += '</template>';
			
			specialTopHtml += '<template v-if="data.style == 2">';
				specialTopHtml += '<div class="layui-form-item">';
					specialTopHtml += '<label class="layui-form-label sm">左侧图标</label>';
					specialTopHtml += '<template v-for="(item, index) in list" v-if="item.style == data.style">';
						specialTopHtml += '<div class="layui-input-block ns-img-upload">';
							specialTopHtml += '<img-sec-upload v-bind:data="{ data : item, text: \'\' }"></img-sec-upload>';
						specialTopHtml += '</div>';
					specialTopHtml += '</template>';
					specialTopHtml += '<div class="ns-word-aux ns-diy-word-aux">建议上传图片大小：131px * 37px</div>';
				specialTopHtml += '</div>';
			specialTopHtml += '</template>';
			
			specialTopHtml += '<template v-if="data.style == 3">';
				specialTopHtml += '<div class="layui-form-item">';
					specialTopHtml += '<label class="layui-form-label sm">顶部图标</label>';
					specialTopHtml += '<template v-for="(item, index) in list" v-if="item.style == data.style">';
						specialTopHtml += '<div class="layui-input-block ns-img-upload">';
							specialTopHtml += '<img-sec-upload v-bind:data="{ data : item, text: \'\' }"></img-sec-upload>';
						specialTopHtml += '</div>';
					specialTopHtml += '</template>';
					specialTopHtml += '<div class="ns-word-aux ns-diy-word-aux">建议上传图片大小：174px * 37px</div>';
				specialTopHtml += '</div>';
			specialTopHtml += '</template>';

			specialTopHtml += '<template v-if="data.style == 4">';
				specialTopHtml += '<div class="layui-form-item">';
					specialTopHtml += '<label class="layui-form-label sm">左侧图标</label>';
					specialTopHtml += '<template v-for="(item, index) in list" v-if="item.style == data.style">';
						specialTopHtml += '<div class="layui-input-block ns-img-upload">';
							specialTopHtml += '<img-sec-upload v-bind:data="{ data : item, text: \'\' }"></img-sec-upload>';
						specialTopHtml += '</div>';
					specialTopHtml += '</template>';
					specialTopHtml += '<div class="ns-word-aux ns-diy-word-aux">建议上传图标大小：125px * 30px</div>';
				specialTopHtml += '</div>';
				
				specialTopHtml += '<div class="content-block">';
					specialTopHtml += '<div class="layui-form-item">';
						specialTopHtml += '<label class="layui-form-label sm">标题内容</label>';
						specialTopHtml += '<template v-for="(item, index) in list" v-if="item.style == data.style">';
							specialTopHtml += '<div class="layui-input-block">';
								specialTopHtml += '<input type="text" name=\'title\' v-model="item.title" class="layui-input" />';
							specialTopHtml += '</div>';
						specialTopHtml += '</template>';
					specialTopHtml += '</div>';
				specialTopHtml += '</div>';
			specialTopHtml += '</template>';
			// specialTopHtml += '<color v-bind:data="{ field : \'titleTextColor\', label : \'标题颜色\', defaultcolor: \'#000\' }"></color>';
		specialTopHtml += '</li>';
		
		/* specialTopHtml += '<li>';
			specialTopHtml += '<div class="content-block">';
				specialTopHtml += '<div class="layui-form-item">';
					specialTopHtml += '<label class="layui-form-label sm">文本内容</label>';
					specialTopHtml += '<div class="layui-input-block">';
						specialTopHtml += '<input type="text" name=\'title\' v-model="listMore.title" class="layui-input" />';
					specialTopHtml += '</div>';
				specialTopHtml += '</div>';
				specialTopHtml += '<color v-bind:data="{ field : \'moreTextColor\', defaultcolor: \'#858585\' }"></color>';
				
			specialTopHtml += '</div>';
		specialTopHtml += '</li>'; */
	specialTopHtml += '</ul>';

Vue.component("special-top-list",{
	template : specialTopHtml,
	data : function(){
		return {
            data : this.$parent.data,
			list : this.$parent.data.list,
			listMore: this.$parent.data.listMore
		};
	},
	created : function(){
		if(!this.$parent.data.verify) this.$parent.data.verify = [];
		this.$parent.data.verify.push(this.verify);//加载验证方法
	},
	watch : {

	},
	methods : {
		verify:function () {
			var res = { code : true, message : "" };
			var _self = this;

			if(_self.data.specialId == ""){
				res.code = false;
				res.message = "请选择专题";
				$(this).find(".error-msg").text("请选择专题").show();
				return res;
			}else{
				$(this).find(".error-msg").text("").hide();
			}
			
			return res;
		},
		addSpecial() {
			var self = this;
			specialSelect(function (res) {
				console.log(res)
				self.$parent.data.specialId = res.id;
				self.$parent.data.specialName = res.name;
				let style = self.$parent.data.style || 1;
				self.$parent.data.list[style-1].imageUrl = res.image;
				
			}, self.$parent.data.specialId, {disabled:0});
		}
	}
});


// 背景颜色可选
var specialColorHtml = '<div class="layui-form-item ns-bg-select">';
	specialColorHtml +=	 '<label class="layui-form-label sm">背景颜色</label>';
	specialColorHtml +=	 '<div class="layui-input-block">';
	specialColorHtml +=		 '<ul class="ns-bg-select-ul">';
	specialColorHtml +=			 '<li v-for="(item, index) in colorList" v-bind:k="index" :class="[item.className == data.bgSelect ? \'ns-text-color ns-border-color\' : \'\']" @click="data.bgSelect = item.className">';
	specialColorHtml +=				 '<div :style="{background: item.color}"></div>';
	specialColorHtml +=			 '</li>';
	specialColorHtml +=		 '</ul>';
	specialColorHtml +=	 '</div>';
	specialColorHtml += '</div>';

Vue.component("special-color", {
	template: specialColorHtml,
	data: function () {
		return {
			data: this.$parent.data,
			colorList: [
				{name: "红", className: "red", color: "#FFD7D7"},
				{name: "蓝", className: "blue", color: "#D7FAFF"},
				{name: "黄", className: "yellow", color: "#FFF4E0"},
				{name: "紫", className: "violet", color: "#F9E5FF"}
			]
		};
	},
	created: function () {
		if(!this.$parent.data.verify) this.$parent.data.verify = [];
		this.$parent.data.verify.push(this.verify);//加载验证方法
	},
	methods: {
		verify : function () {
			var res = { code : true, message : "" };
			return res;
		}
	},
});	


// 切换方式
var changeType = '<div class="layui-form-item ns-icon-radio">';
		changeType += '<label class="layui-form-label sm">滑动方式</label>';
		changeType += '<div class="layui-input-block align-right">';
			changeType += '<template v-for="(item,index) in changeTypeList" v-bind:k="index">';
				changeType += '<div v-on:click="data.changeType=item.value" v-bind:class="{ \'layui-unselect layui-form-radio\' : true,\'layui-form-radioed\' : (data.changeType==item.value) }"><i class="layui-anim layui-icon">&#xe63f;</i><div>{{item.name}}</div></div>';
			changeType += '</template>';
		changeType += '</div>';
	/* changeType +=	 '<label class="layui-form-label sm">滑动方式</label>';
	changeType +=	 '<div class="layui-input-block">';
	changeType +=		 '<template v-for="(item, index) in changeTypeList" v-bind:k="index">';
	changeType +=			 '<span :class="[item.value == data.changeType ? \'\' : \'layui-hide\']">{{item.name}}</span>';
	changeType +=		 '</template>';
	changeType +=		 '<ul class="ns-icon">';
	changeType +=			 '<li v-for="(item, index) in changeTypeList" v-bind:k="index" :class="[item.value == data.changeType ? \'ns-text-color ns-border-color\' : \'\']" @click="data.changeType = item.value">';
	changeType +=				 '<img v-if="item.value == data.changeType" :src="item.selectedSrc" />'
	changeType +=				 '<img v-else :src="item.src" />'
	changeType +=			 '</li>';
	changeType +=		 '</ul>';
	changeType +=	 '</div>'; */
	changeType += '</div>';

Vue.component("change-type", {
	template: changeType,
	data: function () {
		return {
			data: this.$parent.data,
			changeTypeList: [
				{name: "平移滑动", value: 1, src: specialResourcePath + "/special/img/manual.png", selectedSrc: specialResourcePath + "/special/img/manual_1.png"},
				{name: "切屏滑动", value: 2, src: specialResourcePath + "/special/img/manual.png", selectedSrc: specialResourcePath + "/special/img/manual_1.png"},
			]
		};
	},
	created: function () {
		if(!this.$parent.data.verify) this.$parent.data.verify = [];
		this.$parent.data.verify.push(this.verify);//加载验证方法
	},
	methods: {
		verify : function () {
			var res = { code : true, message : "" };
			return res;
		}
	},
});