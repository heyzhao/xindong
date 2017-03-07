<?php
use yii\myhelper\JSSDK;
$jssdk = new JSSDK(Yii::$app->params['appid'], Yii::$app->params['appsecret']);
$signPackage = $jssdk->GetSignPackage();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>幸运三十一</title>

  <link rel="stylesheet" href="<?=Yii::getAlias('@web')?>css/winner/demo.css" type="text/css" />
  <link rel="stylesheet" type="text/css" href="<?=Yii::getAlias('@web')?>css/winner/sweet-alert.css">


  <style type="text/css">
    body { margin: 0; padding: 0; position: relative;  background-position: center; /*background-repeat: no-repeat;*/ width: 100%; height: 100%; background-size: 100% 100%; }

  </style>

  <script type="text/javascript" src="<?=Yii::getAlias('@web')?>js/winner/jquery.min.js"></script>
  <script type="text/javascript" src="<?=Yii::getAlias('@web')?>js/winner/awardRotate.js"></script>
  <script src="<?=Yii::getAlias('@web')?>js/winner/sweet-alert.min.js"></script>
  <script type="text/javascript" src="<?=Yii::getAlias('@web')?>js/winner/ThreeCanvas.js"></script>
  <script type="text/javascript" src="<?=Yii::getAlias('@web')?>js/winner/Snow.js"></script>

  <script type="text/javascript">
    var SCREEN_WIDTH = window.innerWidth;//
    var SCREEN_HEIGHT = window.innerHeight;
    var container;
    var particle;//粒子

    var camera;
    var scene;
    var renderer;

    var starSnow = 1;

    var particles = [];

    var particleImage = new Image();
    //THREE.ImageUtils.loadTexture( "img/ParticleSmoke.png" );
    particleImage.src = '<?=Yii::getAlias('@web')?>images/winner/ParticleSmoke.png';



    function init() {
      //alert("message3");
      container = document.createElement('div');//container：画布实例;
      document.body.appendChild(container);

      camera = new THREE.PerspectiveCamera( 50, SCREEN_WIDTH / SCREEN_HEIGHT, 1, 10000 );
      camera.position.z = 1000;
      //camera.position.y = 50;

      scene = new THREE.Scene();
      scene.add(camera);

      renderer = new THREE.CanvasRenderer();
      renderer.setSize(SCREEN_WIDTH, SCREEN_HEIGHT);
      var material = new THREE.ParticleBasicMaterial( { map: new THREE.Texture(particleImage) } );
      //alert("message2");
      for (var i = 0; i < 260; i++) {
        //alert("message");
        particle = new Particle3D( material);
        particle.position.x = Math.random() * 2000-1000;

        particle.position.z = Math.random() * 2000-1000;
        particle.position.y = Math.random() * 2000-1000;
        //particle.position.y = Math.random() * (1600-particle.position.z)-1000;
        particle.scale.x = particle.scale.y = 0.5;
        scene.add( particle );

        particles.push(particle);
      }

      container.appendChild( renderer.domElement );


      //document.addEventListener( 'mousemove', onDocumentMouseMove, false );
      document.addEventListener( 'touchstart', onDocumentTouchStart, false );
      document.addEventListener( 'touchmove', onDocumentTouchMove, false );
      document.addEventListener( 'touchend', onDocumentTouchEnd, false );

      setInterval( loop, 1000 / 40 );

    }

    var touchStartX;
    var touchFlag = 0;//储存当前是否滑动的状态;
    var touchSensitive = 80;//检测滑动的灵敏度;
    //var touchStartY;
    //var touchEndX;
    //var touchEndY;
    function onDocumentTouchStart( event ) {

      if ( event.touches.length == 1 ) {

        //event.preventDefault();//取消默认关联动作;
        touchStartX = 0;
        touchStartX = event.touches[ 0 ].pageX ;
        //touchStartY = event.touches[ 0 ].pageY ;
      }
    }


    function onDocumentTouchMove( event ) {

      if ( event.touches.length == 1 ) {
        event.preventDefault();
        var direction = event.touches[ 0 ].pageX - touchStartX;
        if (Math.abs(direction) > touchSensitive) {
          if (direction>0) {touchFlag = 1;}
          else if (direction<0) {touchFlag = -1;};
          //changeAndBack(touchFlag);
        }
      }
    }

    function onDocumentTouchEnd (event) {
      // if ( event.touches.length == 0 ) {
      // 	event.preventDefault();
      // 	touchEndX = event.touches[ 0 ].pageX ;
      // 	touchEndY = event.touches[ 0 ].pageY ;

      // }这里存在问题
      var direction = event.changedTouches[ 0 ].pageX - touchStartX;

      changeAndBack(touchFlag);
    }


    function changeAndBack (touchFlag) {
      var speedX = 20*touchFlag;
      touchFlag = 0;
      for (var i = 0; i < particles.length; i++) {
        particles[i].velocity=new THREE.Vector3(speedX,-10,0);
      }
      var timeOut = setTimeout(";", 800);
      clearTimeout(timeOut);

      var clearI = setInterval(function () {
        if (touchFlag) {
          clearInterval(clearI);
          return;
        };
        speedX*=0.8;

        if (Math.abs(speedX)<=1.5) {
          speedX=0;
          clearInterval(clearI);
        };

        for (var i = 0; i < particles.length; i++) {
          particles[i].velocity=new THREE.Vector3(speedX,-10,0);
        }
      },100);


    }


    function loop() {
      for(var i = 0; i<particles.length; i++){
        var particle = particles[i];
        particle.updatePhysics();

        with(particle.position)
        {
          if((y<-1000)&&starSnow) {y+=2000;}

          if(x>1000) x-=2000;
          else if(x<-1000) x+=2000;
          if(z>1000) z-=2000;
          else if(z<-1000) z+=2000;
        }
      }

      camera.lookAt(scene.position);

      renderer.render( scene, camera );
    }
  </script>


  <script type="text/javascript">

    $(function (){

      var rotateTimeOut = function (){
        $('#rotate').rotate({
          angle:0,
          animateTo:2160,
          duration:8000,
          callback:function (){
            alert('网络超时，请检查您的网络设置！');
          }
        });
      };
      var bRotate = false;

      var rotateFn = function (awards, angles, txt){
        bRotate = !bRotate;
        $('#rotate').stopRotate();
        $('#rotate').rotate({
          angle:0,
          animateTo:angles+1800,
          duration:8000,
          callback:function (){
            /*alert(txt);*/
            swal({   title: "获得"+txt+"红包",   imageUrl: "<?=Yii::getAlias('@web')?>images/winner/gx.png" });

            bRotate = !bRotate;
          }
        })
      };
      function SetCookie(name, value) {
        var Days = 30;
        var exp = new Date();
        exp.setTime(exp.getTime() + 365 * 24 * 3600 * 1000);//过期时间 一年
        document.cookie = name + "=" + escape(value) + ";expires=" + exp.toGMTString();
      }
      $('.pointer').click(function (){

        if(document.cookie.indexOf("13loveme.com=")==-1){
          SetCookie('13loveme.com','shisan');
          if(bRotate)return;
          var item = rnd(1,10);

          switch (item) {
            case 1:
              //var angle = [26, 88, 137, 185, 235, 287, 337];
              rotateFn(1, 120, '13元');
              break;
            case 2:
              //var angle = [88, 137, 185, 235, 287];
              rotateFn(2, 190, '1.3元');
              break;
            case 3:
              //var angle = [137, 185, 235, 287];
              rotateFn(3, 200, '1.3元');
              break;
            case 4:
              //var angle = [137, 185, 235, 287];
              rotateFn(4, 250, '1.3元');
              break;
            case 5:
              //var angle = [185, 235, 287];
              rotateFn(5, 55, '0元');
              break;
            case 6:
              //var angle = [185, 235, 287];
              rotateFn(5, 90, '0元');
              break;
            case 7:
              //var angle = [185, 235, 287];
              rotateFn(5, 100, '0元');
              break;
            case 8:
              //var angle = [185, 235, 287];
              rotateFn(5, 105, '0元');
              break;
            case 9:
              //var angle = [185, 235, 287];
              rotateFn(5, 270, '0元');
              break;
            case 10:
              //var angle = [185, 235, 287];
              rotateFn(5, 310, '0元');
              break;

          }

          console.log(item);

        }else {

          SetCookie('13loveme.com','shisan');
          alert("您已经抽过一次奖了！！");

        }


      });

    });
    function rnd(n, m){
      return Math.floor(Math.random()*(m-n+1)+n)
    }
  </script>
</head>
<body bgcolor="#eae0d9" id="body" onLoad="init()">
<div class="couten" style="position:fixed; width:100%;height: 100%; margin:0 auto; text-align:center;">
  <div class="turntable-bg">
    <!--<div class="mask"><img src="images/award_01.png"/></div>-->
    <div class="pointer"><img src="<?=Yii::getAlias('@web')?>images/winner/pointer.png" alt="pointer"/></div>
    <div class="rotate" ><img id="rotate" src="<?=Yii::getAlias('@web')?>images/winner/turntable.png" alt="turntable" /></div>
  </div>
</div>
</body>
<script src="http://13loveme.com/js/jweixin-1.0.0.js"></script>
<script>
  /*
   * 注意：
   * 1. 所有的JS接口只能在公众号绑定的域名下调用，公众号开发者需要先登录微信公众平台进入“公众号设置”的“功能设置”里填写“JS接口安全域名”。
   * 2. 如果发现在 Android 不能分享自定义内容，请到官网下载最新的包覆盖安装，Android 自定义分享接口需升级至 6.0.2.58 版本及以上。
   * 3. 常见问题及完整 JS-SDK 文档地址：http://mp.weixin.qq.com/wiki/7/aaa137b55fb2e0456bf8dd9148dd613f.html
   *
   * 开发中遇到问题详见文档“附录5-常见错误及解决办法”解决，如仍未能解决可通过以下渠道反馈：
   * 邮箱地址：weixin-open@qq.com
   * 邮件主题：【微信JS-SDK反馈】具体问题
   * 邮件内容说明：用简明的语言描述问题所在，并交代清楚遇到该问题的场景，可附上截屏图片，微信团队会尽快处理你的反馈。
   */
  wx.config({
    debug: true,
    appId: '<?= $signPackage["appId"];?>',
    timestamp: <?= $signPackage["timestamp"];?>,
    nonceStr: '<?= $signPackage["nonceStr"];?>',
    signature: '<?= $signPackage["signature"];?>',
    jsApiList: ['onMenuShareAppMessage'
      // 所有要调用的 API 都要加到这个列表中
    ]
  });
  wx.ready(function () {
    wx.onMenuShareAppMessage({
      title: '幸运三十一天大转盘', // 分享标题
      desc: '来幸运三十一天试试手气吧，分享朋友圈后可以再转一次哦', // 分享描述
      link: 'http://13loveme.com/wei-web/web', // 分享链接
      imgUrl: 'http://13loveme.com/images/winner/pointer.png', // 分享图标
      type: 'link', // 分享类型,music、video或link，不填默认为link
      dataUrl: '', // 如果type是music或video，则要提供数据链接，默认为空
      success: function () {
        // 用户确认分享后执行的回调函数
        alert('ddd');
      },
      cancel: function () {
        // 用户取消分享后执行的回调函数
        alert('ddccc');
      }
    });
  });
</script>
</html>
