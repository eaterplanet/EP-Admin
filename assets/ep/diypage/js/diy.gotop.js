define(['jquery.ui'], function (ui) {
    var modal = {};
    modal.init = function (params) {
        window.tpl = params.tpl;
        modal.attachurl = params.attachurl;
        modal.gotop = params.gotop;
        modal.merch = params.merch;

        if (!modal.gotop) {
            modal.gotop = {
                params: {
                    'isopen': '0',
                    'gotoptype': '0',
                    'gotopclick': '0',
                    'imgurl': '../addons/ewei_shopv2/plugin/diypage/assets/ep/images/gotop.png',
                    'linkurl': '',
                    'iconposition': 'right bottom',
                    'iconclass': 'icon-top1',
                    'gotopheight': '300'
                },
                style: {
                    'iconcolor': '#ffffff',
                    'background': '#000000',
                    'opacity': '0.5',
                    'width': '30',
                    'top': '20',
                    'left': '10'
                }
            }
        }
        tpl.helper("imgsrc", function (src) {
            if (typeof src != 'string') {
                return ''
            }
            if (src.indexOf('http://') == 0 || src.indexOf('https://') == 0 || src.indexOf('../addons') == 0) {
                return src
            } else if (src.indexOf('images/') == 0) {
                return modal.attachurl + src
            }
        });
        modal.initItems();
        modal.initEditor();
        $(".btn-save").unbind('click').click(function () {
            var status = $(this).data('status');
            if (status) {
                tip.msgbox.err("正在保存，请稍候。。。");
                return
            }
            modal.save()
        })
    };
    modal.initItems = function () {
        var gotop = modal.gotop;
        gotop.merch = modal.merch;
        var html = tpl("tpl_show_gotop", modal.gotop);
        $("#phone").html(html).show()
    };
    modal.initEditor = function () {
        var html = tpl("tpl_edit_gotop", modal.gotop);
        $("#diy-editor .inner").html(html);
        $("#diy-editor .slider").each(function () {
            var decimal = $(this).data('decimal');
            var multiply = $(this).data('multiply');
            var defaultValue = $(this).data("value");
            if (decimal) {
                defaultValue = defaultValue * decimal
            }
            $(this).slider({
                slide: function (event, ui) {
                    var sliderValue = ui.value;
                    if (decimal) {
                        sliderValue = sliderValue / decimal
                    }
                    $(this).siblings(".input").val(sliderValue).trigger("propertychange");
                    $(this).siblings(".count").find("span").text(sliderValue)
                }, value: defaultValue, min: $(this).data("min"), max: $(this).data("max")
            })
        });
        $("#diy-editor").find(".diy-bind").bind('input propertychange change', function () {
            var _this = $(this);
            var bind = _this.data("bind");
            var bindchild = _this.data('bind-child');
            var bindparent = _this.data('bind-parent');
            var bindthree = _this.data('bind-three');
            var initEditor = _this.data('bind-init');
            var value = '';
            var tag = this.tagName;
            if (tag == 'INPUT') {
                var placeholder = _this.data('placeholder');
                value = _this.val();
                value = value == '' ? placeholder : value
            } else if (tag == 'SELECT') {
                value = _this.find('option:selected').val()
            } else if (tag == 'TEXTAREA') {
                value = _this.val()
            }
            value = $.trim(value);
            if (bindchild) {
                if (bindparent) {
                    if (bindthree) {
                        modal.gotop[bindchild][bindparent].child[bindthree][bind] = value
                    } else {
                        modal.gotop[bindchild][bindparent][bind] = value
                    }
                } else {
                    modal.gotop[bindchild][bind] = value
                }
            } else {
                modal.gotop[bind] = value
            }
            modal.initItems();
            if (initEditor) {
                modal.initEditor()
            }
        });
        $("#phone").mouseenter(function () {
            $("#diy-editor").find('.diy-bind').blur()
        });
        $("#diy-editor").show()
    };
    modal.save = function () {
        if (!modal.gotop) {
            tip.msgbox.err("数据错误，请刷新页面重试！");
            return
        }
        $(".btn-save").data('status', 1).text("保存中...");
        var posturl = biz.url("diypage/shop/gotop", null, modal.merch);
        $.post(posturl, {data: modal.gotop}, function (ret) {
            if (ret.status == 0) {
                tip.msgbox.err(ret.result.message);
                $(".btn-save").text("保存并设置").data("status", 0);
                return
            }
            tip.msgbox.suc("操作成功！");
            $(".btn-save").text("保存并设置").data("status", 0)
        }, 'json')
    };
    return modal
});
