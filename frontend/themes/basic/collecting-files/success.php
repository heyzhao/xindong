<?php

$this->registerCss('

    .navbar.navbar-custom ,footer,#izl_rmenu{display:none;}
');
?>
<link rel="stylesheet" href="/weui/dist/style/weui.min.css"/>
<div class="weui_msg">
    <div class="weui_icon_area"><i class="weui_icon_success weui_icon_msg"></i></div>
    <div class="weui_text_area">
        <h2 class="weui_msg_title">操作成功</h2>
        <p class="weui_msg_desc">内容详情，可根据实际需要安排</p>
    </div>
    <div class="weui_opr_area">
        <p class="weui_btn_area">
            <a href="javascript:;" class="weui_btn weui_btn_primary">确定</a>
            <a href="javascript:;" class="weui_btn weui_btn_default">取消</a>
        </p>
    </div>
    <div class="weui_extra_area">
        <a href="<?=Yii::$app->request->referrer?>">查看个人档案详情</a>
    </div>
</div>
