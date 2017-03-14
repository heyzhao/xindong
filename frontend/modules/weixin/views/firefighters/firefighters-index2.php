<?php
$this->title = '十三救我';
$this->registerCss('
        a:hover{text-decoration: none;color:black;}
       @font-face {font-family: YGY20070701xinde52;src: url("../../fonts/YGY20070701xinde52.ttf");}
        .date-today{padding:0 5px;font-size:12px;}
        .date-today .row{margin:0;}
        .date-today spant{color:#636363;}
        .date-number span{font-size:14px;}
        .date-mark,.date-friend {line-height:26px;}
        .date-mark span,.date-friend span{padding:1px 3px;color:white;border-radius:3px;white-space:nowrap;}
        .date-mark span{background-color:#ef4450;}
        .date-friend span{background-color:#3e4b8d;}
        .img-main a{min-height:100px;width: 100%;display: block;}
        .row1-n1{background-color: white;box-shadow: 0 0 5px #dbdbdb;padding:20px;height: inherit;margin-bottom: 5px;}
        .dating__signup{cursor: pointer;}
        .jiuhuo-img{padding:10px 10px;}
        
        @media (min-width:768px){
            .date-today .col-md-6{width:49%;margin-right:1%;}
            }

        @media (max-width:768px){
            footer{display:none;}
            .img-main a{min-height:200px;display: block;}
            .date-today{padding:10px 5px;}
            .row1-n1{width:100%;padding:10px 10px;}
            .jiuhuo-img{padding:10px 5px;}
        }
');

if(isset($_GET['top'])&&$_GET['top']=='bottoms'){
    $this->registerCss('
        nav,footer,.suo-xia{display:none;}
    ');
}
$user_id = Yii::$app->user->id;
$pre_url = Yii::$app->params['threadimg'];
?>
<?php if(Yii::$app->session->hasFlash('success')):?>
    <div class="alert alert-success">
        <a href="#" class="close" data-dismiss="alert">
            &times;
        </a>
        <strong>通知！</strong>
        <?=Yii::$app->session->getFlash('success')?>
    </div>
<?php endif;?>

<?php if(Yii::$app->session->hasFlash('fail')):?>
    <div class="alert alert-danger">
        <a href="#" class="close" data-dismiss="alert">
            &times;
        </a>
        <strong>通知！</strong>
        <?=Yii::$app->session->getFlash('fail')?>
    </div>
<?php endif;?>

<div class="container">
    <div class="row" style="padding-bottom: 40px;">
        <div class="col-md-3 suo-xia">
            <?= $this->render('@frontend/themes/basic/layouts/dating_left')?>
        </div>
        <div class="col-md-9 date-today" style="min-height: 400px;">
            <?php foreach($model as $key=>$val):
                    $is_expire = (time()-$val['created_at'])<$val['expire']*3600; ?>
                <div class="col-xs-12 col-md-6" style="padding:0;">
                    <div class="row" style="background-color: #fff;margin-bottom: 8px;position: relative;">
                        <div class="col-xs-4 jiuhuo-img">
                            <div style="border-radius: 3px;width: 100%;height: 120px;background: url('<?=$pre_url.$val['pic_path']?>') no-repeat center;background-size: 100% auto;"></div>
                        </div>
                        <div class="col-xs-8" style="padding:10px 5px 0 5px;">
                            <div style="color:gray;margin-bottom: 5px;"><small>编号：<span class="pid-number"><?=$val['pid']?></span></small>&nbsp;&nbsp;&nbsp;<small>需节操币：<?=$val['coin']?></small></div>
                            <div class="" style="font-size: 14px;"><span style="font-weight: bold;"><?=$val['name']?></span><?php if($val['expire']<24000):?> &nbsp;l &nbsp;<small><?=date('Y年m月d日',$val['created_at']+$val['expire']*3600)?>截止</small><?php endif;?></div>
                            <div style="font-size: 12px;margin-top: 5px;"><p><span style="color:red;"><?=$val['city']?></span>&nbsp;&nbsp;<?=$val['content']?></p></div>
                            <div>
                                <?php if($val['type']==3):?>
                                    <?php if(!$is_expire):?>
                                        <a onclick="alert('对不起！报名截止！');" style="cursor: pointer;"><span><img style="width: 110px;" src="/images/dating/baoming.png"></span></a>
                                    <?php else:?>
                                        <?php if(Yii::$app->user->isGuest):?>
                                            <a href="/login" style="cursor: pointer;"><span><img style="width: 110px;" src="/images/dating/baoming.png"></span></a>
                                        <?php else:?>
                                            <a onclick="ajaxBaoming(<?=$val['pid']?>)" style="cursor: pointer;"><span><img style="width: 110px;" src="/images/dating/baoming.png"></span></a>
                                        <?php endif;?>
                                    <?php endif;?>
                                <?php elseif($val['type']==4):?>
                                    <?php if(!$is_expire):?>
                                        <a onclick="alert('对不起！报名截止！');" style="cursor: pointer;"><span><img style="width: 110px;" src="/images/dating/baoming2.png"></span></a>
                                    <?php else:?>
                                        <?php if(Yii::$app->user->isGuest):?>
                                            <a href="/login" style="cursor: pointer;"><span><img style="width: 110px;" src="/images/dating/baoming2.png"></span></a>
                                        <?php else:?>
                                            <a onclick="ajaxBaoming(<?=$val['pid']?>)" style="cursor: pointer;"><span><img style="width: 110px;" src="/images/dating/baoming2.png"></span></a>
                                        <?php endif;?>
                                    <?php endif;?>
                                <?php endif;?>
                                <a onclick="ajaxQuery(<?=$val['pid']?>)" style="cursor: pointer;"><span><img style="width: 72px;" src="/images/dating/chaxun.png"></span></a>
                            </div>
                        </div>

                            <?php if($val['type']==3):?>
                                <?php if($is_expire):?>
                                    <img class="firefighters-sign" style="position: absolute;width: 60px;top:0;right:0;" src="/images/dating/jiuhuo.png">
                                <?php else:?>
                                    <img class="firefighters-sign" style="position: absolute;width: 60px;top:0;right:0;" src="/images/dating/jiuhuo2.png">
                                <?php endif;?>
                            <?php elseif($val['type']==4):?>
                                <?php if($is_expire):?>
                                    <img style="position: absolute;width: 60px;top:0;right:0;" src="/images/dating/fuli.png">
                                <?php else:?>
                                    <img class="firefighters-sign" style="position: absolute;width: 60px;top:0;right:0;" src="/images/dating/fuli2.png">
                                <?php endif;?>
                            <?php endif;?>
                    </div>
                </div>
            <?php endforeach;?>
        </div>
    </div>
    <?=$this->render('@frontend/themes/basic/layouts/bottom')?>
</div>
<script>

    function ajaxBaoming(id) {

        $.get("/weixin/firefighters/firefighters-sign?id="+id,function (result) {
            var parsedJson = $.parseJSON(result);
            alert(parsedJson);

        });
    }
    function ajaxQuery(id) {

        $.get("/weixin/firefighters/firefighters-query?id="+id,function (result) {
            var parsedJson = $.parseJSON(result);
            alert(parsedJson);

        });
    }
</script>


