<?php
$proto = (isset($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] == 'on') ? 'https' : 'http';
$browsers = array(
    'ie' => 'msie',
    'ff' => 'firefox',
    'sf' => 'safari',
    'gc' => 'chrome',
    'op' => 'opera',
    );
$ua = strtolower($_SERVER["HTTP_USER_AGENT"]);
foreach($browsers as $bi => $bdat){
    $bsx = 'browser_'.$bi;
    if (strpos($ua, $bdat) !== false) {
        $browser = $bi;
        $$bsx = true;
    }
    else {
        $$bsx = false;
    }
}
?>
<html>
<head>
<script>
    prot = "<?= $proto ?>";
</script>
<script type="text/javascript" src="spu5.js"></script>
<style type="text/css">
    body {
        font-family             : Arial, Helvetica, sans-serif;
        -webkit-touch-callout   : none;
        -webkit-user-select     : none;
        -khtml-user-select      : none;
        -moz-user-select        : none;
        -ms-user-select         : none;
        user-select             : none;
    }
    table   { border: 2px solid #000; }
    .t0     {
                text-align: center;
                float: left;
                width: 48px;
                height: 48px;
                font-size:24px;
                font-weight: bold;
                z-index:-1;
                border-bottom: 1px solid #000;
                border-top:    1px solid #000;
                border-left:   1px solid #000;
                border-right:  1px solid #000;
                margin: 0px;
            }

    .r1     { border-bottom: 2px solid #000; }
    .r2     { border-right:  2px solid #000; }
    .e0     { border-top:    3px solid #000; }
    .e1     { border-bottom: 3px solid #000; }
    .e2     { border-right:  3px solid #000; }
    .e3     { border-left:   3px solid #000; }
    .dv     { border: none; width: 48px; height: 48px; margin-top:3px; font-size: 36px; font-weight: bold; z-index:1; cursor:pointer;}
    .b0     { text-align: center; float: left; width: 48px; height: 48px; }
    .n0     { background-color: #EEEEEE;}
    .n1     { background-color: #FFFFFF;}

.pupx {
  border: 1px solid #000000;
  display: none;
  height: 185px;
  position: absolute;
  width: 118px;
  z-index: 100;
}

.punx {
  border: 1px solid #555555;
  cursor: pointer;
  float: left;
  font-size: 36px;
  font-weight: bold;
  height: 44px;
  margin-left: 1px;
  margin-top: 1px;
  text-align: center;
  width: 36px;
}

.putx {
  border: 1px solid #555555;
  cursor: pointer;
  float: left;
  font-size: 22px;
  font-weight: bold;
  height: 33px;
  margin-left: 1px;
  margin-top: 1px;
  padding-top: 7px;
  text-align: center;
  width: 36px;
}

.pudx {
  border: 1px solid #555555;
  cursor: pointer;
  float: left;
  font-size: 22px;
  font-weight: bold;
  height: 33px;
  margin-left: 1px;
  margin-top: 1px;
  padding-top: 7px;
  text-align: center;
  width: 36px;
}

.puex {
  border: 1px solid #555555;
  cursor: pointer;
  float: left;
  font-size: 32px;
  font-weight: bold;
  height: 40px;
  margin-left: 1px;
  margin-top: 1px;
  text-align: center;
  width: 36px;
}

.rounded {
    -moz-border-radius: 25px;
    -webkit-border-radius: 25px;
    -khtml-border-radius: 25px;
    border-radius: 25px;
    behavior: url(/montana/border-radius.htc)\9;
    zoom: 1;
}

.rounded2 {
    -moz-border-radius: 50px;
    -webkit-border-radius: 50px;
    -khtml-border-radius: 50px;
    border-radius: 50px;
    behavior: url(/montana/border-radius.htc)\9;
}

    .p0     { border: none;           width: 12px; height: 12px; font-size: 10px; text-align: center; cursor: pointer; position: absolute; z-index: 20; background-color: #CCF; display: none; margin: 0px;}
    .p1     { border: 1px solid #000; width: 12px; height: 12px; font-size: 10px; text-align: center; cursor: pointer; position: absolute; z-index: 30; background-color: #FCC; display: none; margin: 0px;}
    .s-container { width: 457px; height: 456px; background-color: #00FF00; margin-bottom:4px; clear:both;}
    .btm    { position: absolute; left: 470px; top:130px; z-index:10; width: 260px; height: 460px; text-align: center;}
    .tmr    { text-align: center; font-size: 36px; font-weight: bold;}
    .tmx    { text-align: center; font-size: 36px; font-weight: bold;}
    .tmy    { text-align: center; font-size: 36px; font-weight: bold; margin-top: 5px;}
    .scr    { width:250px; height:60px; padding-top:2px; float:left; margin:1px; margin-left: 5px; background:#CCCC00; text-align:left;}
    .frt    { float:left; font-size:24px; text-align:left;}
    .pic    { float:left; margin: 3px; }
    h1 {margin-top: 3px; margin-bottom: 1px; text-align: center;}
</style>
</head>
<body onkeydown="puk(event)">
<div id="fb-root"></div>
<script type="text/javascript"><!--
google_ad_client = "pub-1135248087036728";
/* Master Sudoku Leaderboard */
google_ad_slot = "2200050702";
google_ad_width = 728;
google_ad_height = 90;
//-->
</script>
<div id="upperAd" style="width:728px;height:90px;">
<script type="text/javascript"
src="<?= $proto ?>://pagead2.googlesyndication.com/pagead/show_ads.js">
</script></div>
<h1>Master Sudoku</h1><div id='container' class='s-container'>
<div id='tr0c0' class='t0 e0 e3 n1'><div id='r0c0i0' class='p0' onclick='pu(0,0);'>&nbsp</div><div id='r0c0i1' class='p0' onclick='pu(0,0);'>&nbsp</div><div id='r0c0i2' class='p0' onclick='pu(0,0);'>&nbsp</div><div id='r0c0i3' class='p0' onclick='pu(0,0);'>&nbsp</div><div id='r0c0i4' class='p0' onclick='pu(0,0);'>&nbsp</div><div id='r0c0i5' class='p0' onclick='pu(0,0);'>&nbsp</div><div id='r0c0i6' class='p0' onclick='pu(0,0);'>&nbsp</div><div id='r0c0i7' class='p0' onclick='pu(0,0);'>&nbsp</div><div id='r0c0i8' class='p0' onclick='pu(0,0);'>&nbsp</div><div class='dv' id='r0c0'>&nbsp;</div></div>
<div id='tr0c1' class='t0 e0 n1'><div id='r0c1i0' class='p0' onclick='pu(1,0);'>&nbsp</div><div id='r0c1i1' class='p0' onclick='pu(1,0);'>&nbsp</div><div id='r0c1i2' class='p0' onclick='pu(1,0);'>&nbsp</div><div id='r0c1i3' class='p0' onclick='pu(1,0);'>&nbsp</div><div id='r0c1i4' class='p0' onclick='pu(1,0);'>&nbsp</div><div id='r0c1i5' class='p0' onclick='pu(1,0);'>&nbsp</div><div id='r0c1i6' class='p0' onclick='pu(1,0);'>&nbsp</div><div id='r0c1i7' class='p0' onclick='pu(1,0);'>&nbsp</div><div id='r0c1i8' class='p0' onclick='pu(1,0);'>&nbsp</div><div class='dv' id='r0c1'>&nbsp;</div></div>
<div id='tr0c2' class='t0 r2 e0 n1'><div id='r0c2i0' class='p0' onclick='pu(2,0);'>&nbsp</div><div id='r0c2i1' class='p0' onclick='pu(2,0);'>&nbsp</div><div id='r0c2i2' class='p0' onclick='pu(2,0);'>&nbsp</div><div id='r0c2i3' class='p0' onclick='pu(2,0);'>&nbsp</div><div id='r0c2i4' class='p0' onclick='pu(2,0);'>&nbsp</div><div id='r0c2i5' class='p0' onclick='pu(2,0);'>&nbsp</div><div id='r0c2i6' class='p0' onclick='pu(2,0);'>&nbsp</div><div id='r0c2i7' class='p0' onclick='pu(2,0);'>&nbsp</div><div id='r0c2i8' class='p0' onclick='pu(2,0);'>&nbsp</div><div class='dv' id='r0c2'>&nbsp;</div></div>
<div id='tr0c3' class='t0 e0 n1'><div id='r0c3i0' class='p0' onclick='pu(3,0);'>&nbsp</div><div id='r0c3i1' class='p0' onclick='pu(3,0);'>&nbsp</div><div id='r0c3i2' class='p0' onclick='pu(3,0);'>&nbsp</div><div id='r0c3i3' class='p0' onclick='pu(3,0);'>&nbsp</div><div id='r0c3i4' class='p0' onclick='pu(3,0);'>&nbsp</div><div id='r0c3i5' class='p0' onclick='pu(3,0);'>&nbsp</div><div id='r0c3i6' class='p0' onclick='pu(3,0);'>&nbsp</div><div id='r0c3i7' class='p0' onclick='pu(3,0);'>&nbsp</div><div id='r0c3i8' class='p0' onclick='pu(3,0);'>&nbsp</div><div class='dv' id='r0c3'>&nbsp;</div></div>
<div id='tr0c4' class='t0 e0 n1'><div id='r0c4i0' class='p0' onclick='pu(4,0);'>&nbsp</div><div id='r0c4i1' class='p0' onclick='pu(4,0);'>&nbsp</div><div id='r0c4i2' class='p0' onclick='pu(4,0);'>&nbsp</div><div id='r0c4i3' class='p0' onclick='pu(4,0);'>&nbsp</div><div id='r0c4i4' class='p0' onclick='pu(4,0);'>&nbsp</div><div id='r0c4i5' class='p0' onclick='pu(4,0);'>&nbsp</div><div id='r0c4i6' class='p0' onclick='pu(4,0);'>&nbsp</div><div id='r0c4i7' class='p0' onclick='pu(4,0);'>&nbsp</div><div id='r0c4i8' class='p0' onclick='pu(4,0);'>&nbsp</div><div class='dv' id='r0c4'>&nbsp;</div></div>
<div id='tr0c5' class='t0 r2 e0 n1'><div id='r0c5i0' class='p0' onclick='pu(5,0);'>&nbsp</div><div id='r0c5i1' class='p0' onclick='pu(5,0);'>&nbsp</div><div id='r0c5i2' class='p0' onclick='pu(5,0);'>&nbsp</div><div id='r0c5i3' class='p0' onclick='pu(5,0);'>&nbsp</div><div id='r0c5i4' class='p0' onclick='pu(5,0);'>&nbsp</div><div id='r0c5i5' class='p0' onclick='pu(5,0);'>&nbsp</div><div id='r0c5i6' class='p0' onclick='pu(5,0);'>&nbsp</div><div id='r0c5i7' class='p0' onclick='pu(5,0);'>&nbsp</div><div id='r0c5i8' class='p0' onclick='pu(5,0);'>&nbsp</div><div class='dv' id='r0c5'>&nbsp;</div></div>
<div id='tr0c6' class='t0 e0 n1'><div id='r0c6i0' class='p0' onclick='pu(6,0);'>&nbsp</div><div id='r0c6i1' class='p0' onclick='pu(6,0);'>&nbsp</div><div id='r0c6i2' class='p0' onclick='pu(6,0);'>&nbsp</div><div id='r0c6i3' class='p0' onclick='pu(6,0);'>&nbsp</div><div id='r0c6i4' class='p0' onclick='pu(6,0);'>&nbsp</div><div id='r0c6i5' class='p0' onclick='pu(6,0);'>&nbsp</div><div id='r0c6i6' class='p0' onclick='pu(6,0);'>&nbsp</div><div id='r0c6i7' class='p0' onclick='pu(6,0);'>&nbsp</div><div id='r0c6i8' class='p0' onclick='pu(6,0);'>&nbsp</div><div class='dv' id='r0c6'>&nbsp;</div></div>
<div id='tr0c7' class='t0 e0 n1'><div id='r0c7i0' class='p0' onclick='pu(7,0);'>&nbsp</div><div id='r0c7i1' class='p0' onclick='pu(7,0);'>&nbsp</div><div id='r0c7i2' class='p0' onclick='pu(7,0);'>&nbsp</div><div id='r0c7i3' class='p0' onclick='pu(7,0);'>&nbsp</div><div id='r0c7i4' class='p0' onclick='pu(7,0);'>&nbsp</div><div id='r0c7i5' class='p0' onclick='pu(7,0);'>&nbsp</div><div id='r0c7i6' class='p0' onclick='pu(7,0);'>&nbsp</div><div id='r0c7i7' class='p0' onclick='pu(7,0);'>&nbsp</div><div id='r0c7i8' class='p0' onclick='pu(7,0);'>&nbsp</div><div class='dv' id='r0c7'>&nbsp;</div></div>
<div id='tr0c8' class='t0 e0 e2 n1'><div id='r0c8i0' class='p0' onclick='pu(8,0);'>&nbsp</div><div id='r0c8i1' class='p0' onclick='pu(8,0);'>&nbsp</div><div id='r0c8i2' class='p0' onclick='pu(8,0);'>&nbsp</div><div id='r0c8i3' class='p0' onclick='pu(8,0);'>&nbsp</div><div id='r0c8i4' class='p0' onclick='pu(8,0);'>&nbsp</div><div id='r0c8i5' class='p0' onclick='pu(8,0);'>&nbsp</div><div id='r0c8i6' class='p0' onclick='pu(8,0);'>&nbsp</div><div id='r0c8i7' class='p0' onclick='pu(8,0);'>&nbsp</div><div id='r0c8i8' class='p0' onclick='pu(8,0);'>&nbsp</div><div class='dv' id='r0c8'>&nbsp;</div></div>
<div id='tr1c0' class='t0 e3 n1'><div id='r1c0i0' class='p0' onclick='pu(0,1);'>&nbsp</div><div id='r1c0i1' class='p0' onclick='pu(0,1);'>&nbsp</div><div id='r1c0i2' class='p0' onclick='pu(0,1);'>&nbsp</div><div id='r1c0i3' class='p0' onclick='pu(0,1);'>&nbsp</div><div id='r1c0i4' class='p0' onclick='pu(0,1);'>&nbsp</div><div id='r1c0i5' class='p0' onclick='pu(0,1);'>&nbsp</div><div id='r1c0i6' class='p0' onclick='pu(0,1);'>&nbsp</div><div id='r1c0i7' class='p0' onclick='pu(0,1);'>&nbsp</div><div id='r1c0i8' class='p0' onclick='pu(0,1);'>&nbsp</div><div class='dv' id='r1c0'>&nbsp;</div></div>
<div id='tr1c1' class='t0 n1'><div id='r1c1i0' class='p0' onclick='pu(1,1);'>&nbsp</div><div id='r1c1i1' class='p0' onclick='pu(1,1);'>&nbsp</div><div id='r1c1i2' class='p0' onclick='pu(1,1);'>&nbsp</div><div id='r1c1i3' class='p0' onclick='pu(1,1);'>&nbsp</div><div id='r1c1i4' class='p0' onclick='pu(1,1);'>&nbsp</div><div id='r1c1i5' class='p0' onclick='pu(1,1);'>&nbsp</div><div id='r1c1i6' class='p0' onclick='pu(1,1);'>&nbsp</div><div id='r1c1i7' class='p0' onclick='pu(1,1);'>&nbsp</div><div id='r1c1i8' class='p0' onclick='pu(1,1);'>&nbsp</div><div class='dv' id='r1c1'>&nbsp;</div></div>
<div id='tr1c2' class='t0 r2 n1'><div id='r1c2i0' class='p0' onclick='pu(2,1);'>&nbsp</div><div id='r1c2i1' class='p0' onclick='pu(2,1);'>&nbsp</div><div id='r1c2i2' class='p0' onclick='pu(2,1);'>&nbsp</div><div id='r1c2i3' class='p0' onclick='pu(2,1);'>&nbsp</div><div id='r1c2i4' class='p0' onclick='pu(2,1);'>&nbsp</div><div id='r1c2i5' class='p0' onclick='pu(2,1);'>&nbsp</div><div id='r1c2i6' class='p0' onclick='pu(2,1);'>&nbsp</div><div id='r1c2i7' class='p0' onclick='pu(2,1);'>&nbsp</div><div id='r1c2i8' class='p0' onclick='pu(2,1);'>&nbsp</div><div class='dv' id='r1c2'>&nbsp;</div></div>
<div id='tr1c3' class='t0 n1'><div id='r1c3i0' class='p0' onclick='pu(3,1);'>&nbsp</div><div id='r1c3i1' class='p0' onclick='pu(3,1);'>&nbsp</div><div id='r1c3i2' class='p0' onclick='pu(3,1);'>&nbsp</div><div id='r1c3i3' class='p0' onclick='pu(3,1);'>&nbsp</div><div id='r1c3i4' class='p0' onclick='pu(3,1);'>&nbsp</div><div id='r1c3i5' class='p0' onclick='pu(3,1);'>&nbsp</div><div id='r1c3i6' class='p0' onclick='pu(3,1);'>&nbsp</div><div id='r1c3i7' class='p0' onclick='pu(3,1);'>&nbsp</div><div id='r1c3i8' class='p0' onclick='pu(3,1);'>&nbsp</div><div class='dv' id='r1c3'>&nbsp;</div></div>
<div id='tr1c4' class='t0 n1'><div id='r1c4i0' class='p0' onclick='pu(4,1);'>&nbsp</div><div id='r1c4i1' class='p0' onclick='pu(4,1);'>&nbsp</div><div id='r1c4i2' class='p0' onclick='pu(4,1);'>&nbsp</div><div id='r1c4i3' class='p0' onclick='pu(4,1);'>&nbsp</div><div id='r1c4i4' class='p0' onclick='pu(4,1);'>&nbsp</div><div id='r1c4i5' class='p0' onclick='pu(4,1);'>&nbsp</div><div id='r1c4i6' class='p0' onclick='pu(4,1);'>&nbsp</div><div id='r1c4i7' class='p0' onclick='pu(4,1);'>&nbsp</div><div id='r1c4i8' class='p0' onclick='pu(4,1);'>&nbsp</div><div class='dv' id='r1c4'>&nbsp;</div></div>
<div id='tr1c5' class='t0 r2 n1'><div id='r1c5i0' class='p0' onclick='pu(5,1);'>&nbsp</div><div id='r1c5i1' class='p0' onclick='pu(5,1);'>&nbsp</div><div id='r1c5i2' class='p0' onclick='pu(5,1);'>&nbsp</div><div id='r1c5i3' class='p0' onclick='pu(5,1);'>&nbsp</div><div id='r1c5i4' class='p0' onclick='pu(5,1);'>&nbsp</div><div id='r1c5i5' class='p0' onclick='pu(5,1);'>&nbsp</div><div id='r1c5i6' class='p0' onclick='pu(5,1);'>&nbsp</div><div id='r1c5i7' class='p0' onclick='pu(5,1);'>&nbsp</div><div id='r1c5i8' class='p0' onclick='pu(5,1);'>&nbsp</div><div class='dv' id='r1c5'>&nbsp;</div></div>
<div id='tr1c6' class='t0 n1'><div id='r1c6i0' class='p0' onclick='pu(6,1);'>&nbsp</div><div id='r1c6i1' class='p0' onclick='pu(6,1);'>&nbsp</div><div id='r1c6i2' class='p0' onclick='pu(6,1);'>&nbsp</div><div id='r1c6i3' class='p0' onclick='pu(6,1);'>&nbsp</div><div id='r1c6i4' class='p0' onclick='pu(6,1);'>&nbsp</div><div id='r1c6i5' class='p0' onclick='pu(6,1);'>&nbsp</div><div id='r1c6i6' class='p0' onclick='pu(6,1);'>&nbsp</div><div id='r1c6i7' class='p0' onclick='pu(6,1);'>&nbsp</div><div id='r1c6i8' class='p0' onclick='pu(6,1);'>&nbsp</div><div class='dv' id='r1c6'>&nbsp;</div></div>
<div id='tr1c7' class='t0 n1'><div id='r1c7i0' class='p0' onclick='pu(7,1);'>&nbsp</div><div id='r1c7i1' class='p0' onclick='pu(7,1);'>&nbsp</div><div id='r1c7i2' class='p0' onclick='pu(7,1);'>&nbsp</div><div id='r1c7i3' class='p0' onclick='pu(7,1);'>&nbsp</div><div id='r1c7i4' class='p0' onclick='pu(7,1);'>&nbsp</div><div id='r1c7i5' class='p0' onclick='pu(7,1);'>&nbsp</div><div id='r1c7i6' class='p0' onclick='pu(7,1);'>&nbsp</div><div id='r1c7i7' class='p0' onclick='pu(7,1);'>&nbsp</div><div id='r1c7i8' class='p0' onclick='pu(7,1);'>&nbsp</div><div class='dv' id='r1c7'>&nbsp;</div></div>
<div id='tr1c8' class='t0 e2 n1'><div id='r1c8i0' class='p0' onclick='pu(8,1);'>&nbsp</div><div id='r1c8i1' class='p0' onclick='pu(8,1);'>&nbsp</div><div id='r1c8i2' class='p0' onclick='pu(8,1);'>&nbsp</div><div id='r1c8i3' class='p0' onclick='pu(8,1);'>&nbsp</div><div id='r1c8i4' class='p0' onclick='pu(8,1);'>&nbsp</div><div id='r1c8i5' class='p0' onclick='pu(8,1);'>&nbsp</div><div id='r1c8i6' class='p0' onclick='pu(8,1);'>&nbsp</div><div id='r1c8i7' class='p0' onclick='pu(8,1);'>&nbsp</div><div id='r1c8i8' class='p0' onclick='pu(8,1);'>&nbsp</div><div class='dv' id='r1c8'>&nbsp;</div></div>
<div id='tr2c0' class='t0 r1 e3 n1'><div id='r2c0i0' class='p0' onclick='pu(0,2);'>&nbsp</div><div id='r2c0i1' class='p0' onclick='pu(0,2);'>&nbsp</div><div id='r2c0i2' class='p0' onclick='pu(0,2);'>&nbsp</div><div id='r2c0i3' class='p0' onclick='pu(0,2);'>&nbsp</div><div id='r2c0i4' class='p0' onclick='pu(0,2);'>&nbsp</div><div id='r2c0i5' class='p0' onclick='pu(0,2);'>&nbsp</div><div id='r2c0i6' class='p0' onclick='pu(0,2);'>&nbsp</div><div id='r2c0i7' class='p0' onclick='pu(0,2);'>&nbsp</div><div id='r2c0i8' class='p0' onclick='pu(0,2);'>&nbsp</div><div class='dv' id='r2c0'>&nbsp;</div></div>
<div id='tr2c1' class='t0 r1 n1'><div id='r2c1i0' class='p0' onclick='pu(1,2);'>&nbsp</div><div id='r2c1i1' class='p0' onclick='pu(1,2);'>&nbsp</div><div id='r2c1i2' class='p0' onclick='pu(1,2);'>&nbsp</div><div id='r2c1i3' class='p0' onclick='pu(1,2);'>&nbsp</div><div id='r2c1i4' class='p0' onclick='pu(1,2);'>&nbsp</div><div id='r2c1i5' class='p0' onclick='pu(1,2);'>&nbsp</div><div id='r2c1i6' class='p0' onclick='pu(1,2);'>&nbsp</div><div id='r2c1i7' class='p0' onclick='pu(1,2);'>&nbsp</div><div id='r2c1i8' class='p0' onclick='pu(1,2);'>&nbsp</div><div class='dv' id='r2c1'>&nbsp;</div></div>
<div id='tr2c2' class='t0 r1 r2 n1'><div id='r2c2i0' class='p0' onclick='pu(2,2);'>&nbsp</div><div id='r2c2i1' class='p0' onclick='pu(2,2);'>&nbsp</div><div id='r2c2i2' class='p0' onclick='pu(2,2);'>&nbsp</div><div id='r2c2i3' class='p0' onclick='pu(2,2);'>&nbsp</div><div id='r2c2i4' class='p0' onclick='pu(2,2);'>&nbsp</div><div id='r2c2i5' class='p0' onclick='pu(2,2);'>&nbsp</div><div id='r2c2i6' class='p0' onclick='pu(2,2);'>&nbsp</div><div id='r2c2i7' class='p0' onclick='pu(2,2);'>&nbsp</div><div id='r2c2i8' class='p0' onclick='pu(2,2);'>&nbsp</div><div class='dv' id='r2c2'>&nbsp;</div></div>
<div id='tr2c3' class='t0 r1 n1'><div id='r2c3i0' class='p0' onclick='pu(3,2);'>&nbsp</div><div id='r2c3i1' class='p0' onclick='pu(3,2);'>&nbsp</div><div id='r2c3i2' class='p0' onclick='pu(3,2);'>&nbsp</div><div id='r2c3i3' class='p0' onclick='pu(3,2);'>&nbsp</div><div id='r2c3i4' class='p0' onclick='pu(3,2);'>&nbsp</div><div id='r2c3i5' class='p0' onclick='pu(3,2);'>&nbsp</div><div id='r2c3i6' class='p0' onclick='pu(3,2);'>&nbsp</div><div id='r2c3i7' class='p0' onclick='pu(3,2);'>&nbsp</div><div id='r2c3i8' class='p0' onclick='pu(3,2);'>&nbsp</div><div class='dv' id='r2c3'>&nbsp;</div></div>
<div id='tr2c4' class='t0 r1 n1'><div id='r2c4i0' class='p0' onclick='pu(4,2);'>&nbsp</div><div id='r2c4i1' class='p0' onclick='pu(4,2);'>&nbsp</div><div id='r2c4i2' class='p0' onclick='pu(4,2);'>&nbsp</div><div id='r2c4i3' class='p0' onclick='pu(4,2);'>&nbsp</div><div id='r2c4i4' class='p0' onclick='pu(4,2);'>&nbsp</div><div id='r2c4i5' class='p0' onclick='pu(4,2);'>&nbsp</div><div id='r2c4i6' class='p0' onclick='pu(4,2);'>&nbsp</div><div id='r2c4i7' class='p0' onclick='pu(4,2);'>&nbsp</div><div id='r2c4i8' class='p0' onclick='pu(4,2);'>&nbsp</div><div class='dv' id='r2c4'>&nbsp;</div></div>
<div id='tr2c5' class='t0 r1 r2 n1'><div id='r2c5i0' class='p0' onclick='pu(5,2);'>&nbsp</div><div id='r2c5i1' class='p0' onclick='pu(5,2);'>&nbsp</div><div id='r2c5i2' class='p0' onclick='pu(5,2);'>&nbsp</div><div id='r2c5i3' class='p0' onclick='pu(5,2);'>&nbsp</div><div id='r2c5i4' class='p0' onclick='pu(5,2);'>&nbsp</div><div id='r2c5i5' class='p0' onclick='pu(5,2);'>&nbsp</div><div id='r2c5i6' class='p0' onclick='pu(5,2);'>&nbsp</div><div id='r2c5i7' class='p0' onclick='pu(5,2);'>&nbsp</div><div id='r2c5i8' class='p0' onclick='pu(5,2);'>&nbsp</div><div class='dv' id='r2c5'>&nbsp;</div></div>
<div id='tr2c6' class='t0 r1 n1'><div id='r2c6i0' class='p0' onclick='pu(6,2);'>&nbsp</div><div id='r2c6i1' class='p0' onclick='pu(6,2);'>&nbsp</div><div id='r2c6i2' class='p0' onclick='pu(6,2);'>&nbsp</div><div id='r2c6i3' class='p0' onclick='pu(6,2);'>&nbsp</div><div id='r2c6i4' class='p0' onclick='pu(6,2);'>&nbsp</div><div id='r2c6i5' class='p0' onclick='pu(6,2);'>&nbsp</div><div id='r2c6i6' class='p0' onclick='pu(6,2);'>&nbsp</div><div id='r2c6i7' class='p0' onclick='pu(6,2);'>&nbsp</div><div id='r2c6i8' class='p0' onclick='pu(6,2);'>&nbsp</div><div class='dv' id='r2c6'>&nbsp;</div></div>
<div id='tr2c7' class='t0 r1 n1'><div id='r2c7i0' class='p0' onclick='pu(7,2);'>&nbsp</div><div id='r2c7i1' class='p0' onclick='pu(7,2);'>&nbsp</div><div id='r2c7i2' class='p0' onclick='pu(7,2);'>&nbsp</div><div id='r2c7i3' class='p0' onclick='pu(7,2);'>&nbsp</div><div id='r2c7i4' class='p0' onclick='pu(7,2);'>&nbsp</div><div id='r2c7i5' class='p0' onclick='pu(7,2);'>&nbsp</div><div id='r2c7i6' class='p0' onclick='pu(7,2);'>&nbsp</div><div id='r2c7i7' class='p0' onclick='pu(7,2);'>&nbsp</div><div id='r2c7i8' class='p0' onclick='pu(7,2);'>&nbsp</div><div class='dv' id='r2c7'>&nbsp;</div></div>
<div id='tr2c8' class='t0 r1 e2 n1'><div id='r2c8i0' class='p0' onclick='pu(8,2);'>&nbsp</div><div id='r2c8i1' class='p0' onclick='pu(8,2);'>&nbsp</div><div id='r2c8i2' class='p0' onclick='pu(8,2);'>&nbsp</div><div id='r2c8i3' class='p0' onclick='pu(8,2);'>&nbsp</div><div id='r2c8i4' class='p0' onclick='pu(8,2);'>&nbsp</div><div id='r2c8i5' class='p0' onclick='pu(8,2);'>&nbsp</div><div id='r2c8i6' class='p0' onclick='pu(8,2);'>&nbsp</div><div id='r2c8i7' class='p0' onclick='pu(8,2);'>&nbsp</div><div id='r2c8i8' class='p0' onclick='pu(8,2);'>&nbsp</div><div class='dv' id='r2c8'>&nbsp;</div></div>
<div id='tr3c0' class='t0 e3 n1'><div id='r3c0i0' class='p0' onclick='pu(0,3);'>&nbsp</div><div id='r3c0i1' class='p0' onclick='pu(0,3);'>&nbsp</div><div id='r3c0i2' class='p0' onclick='pu(0,3);'>&nbsp</div><div id='r3c0i3' class='p0' onclick='pu(0,3);'>&nbsp</div><div id='r3c0i4' class='p0' onclick='pu(0,3);'>&nbsp</div><div id='r3c0i5' class='p0' onclick='pu(0,3);'>&nbsp</div><div id='r3c0i6' class='p0' onclick='pu(0,3);'>&nbsp</div><div id='r3c0i7' class='p0' onclick='pu(0,3);'>&nbsp</div><div id='r3c0i8' class='p0' onclick='pu(0,3);'>&nbsp</div><div class='dv' id='r3c0'>&nbsp;</div></div>
<div id='tr3c1' class='t0 n1'><div id='r3c1i0' class='p0' onclick='pu(1,3);'>&nbsp</div><div id='r3c1i1' class='p0' onclick='pu(1,3);'>&nbsp</div><div id='r3c1i2' class='p0' onclick='pu(1,3);'>&nbsp</div><div id='r3c1i3' class='p0' onclick='pu(1,3);'>&nbsp</div><div id='r3c1i4' class='p0' onclick='pu(1,3);'>&nbsp</div><div id='r3c1i5' class='p0' onclick='pu(1,3);'>&nbsp</div><div id='r3c1i6' class='p0' onclick='pu(1,3);'>&nbsp</div><div id='r3c1i7' class='p0' onclick='pu(1,3);'>&nbsp</div><div id='r3c1i8' class='p0' onclick='pu(1,3);'>&nbsp</div><div class='dv' id='r3c1'>&nbsp;</div></div>
<div id='tr3c2' class='t0 r2 n1'><div id='r3c2i0' class='p0' onclick='pu(2,3);'>&nbsp</div><div id='r3c2i1' class='p0' onclick='pu(2,3);'>&nbsp</div><div id='r3c2i2' class='p0' onclick='pu(2,3);'>&nbsp</div><div id='r3c2i3' class='p0' onclick='pu(2,3);'>&nbsp</div><div id='r3c2i4' class='p0' onclick='pu(2,3);'>&nbsp</div><div id='r3c2i5' class='p0' onclick='pu(2,3);'>&nbsp</div><div id='r3c2i6' class='p0' onclick='pu(2,3);'>&nbsp</div><div id='r3c2i7' class='p0' onclick='pu(2,3);'>&nbsp</div><div id='r3c2i8' class='p0' onclick='pu(2,3);'>&nbsp</div><div class='dv' id='r3c2'>&nbsp;</div></div>
<div id='tr3c3' class='t0 n1'><div id='r3c3i0' class='p0' onclick='pu(3,3);'>&nbsp</div><div id='r3c3i1' class='p0' onclick='pu(3,3);'>&nbsp</div><div id='r3c3i2' class='p0' onclick='pu(3,3);'>&nbsp</div><div id='r3c3i3' class='p0' onclick='pu(3,3);'>&nbsp</div><div id='r3c3i4' class='p0' onclick='pu(3,3);'>&nbsp</div><div id='r3c3i5' class='p0' onclick='pu(3,3);'>&nbsp</div><div id='r3c3i6' class='p0' onclick='pu(3,3);'>&nbsp</div><div id='r3c3i7' class='p0' onclick='pu(3,3);'>&nbsp</div><div id='r3c3i8' class='p0' onclick='pu(3,3);'>&nbsp</div><div class='dv' id='r3c3'>&nbsp;</div></div>
<div id='tr3c4' class='t0 n1'><div id='r3c4i0' class='p0' onclick='pu(4,3);'>&nbsp</div><div id='r3c4i1' class='p0' onclick='pu(4,3);'>&nbsp</div><div id='r3c4i2' class='p0' onclick='pu(4,3);'>&nbsp</div><div id='r3c4i3' class='p0' onclick='pu(4,3);'>&nbsp</div><div id='r3c4i4' class='p0' onclick='pu(4,3);'>&nbsp</div><div id='r3c4i5' class='p0' onclick='pu(4,3);'>&nbsp</div><div id='r3c4i6' class='p0' onclick='pu(4,3);'>&nbsp</div><div id='r3c4i7' class='p0' onclick='pu(4,3);'>&nbsp</div><div id='r3c4i8' class='p0' onclick='pu(4,3);'>&nbsp</div><div class='dv' id='r3c4'>&nbsp;</div></div>
<div id='tr3c5' class='t0 r2 n1'><div id='r3c5i0' class='p0' onclick='pu(5,3);'>&nbsp</div><div id='r3c5i1' class='p0' onclick='pu(5,3);'>&nbsp</div><div id='r3c5i2' class='p0' onclick='pu(5,3);'>&nbsp</div><div id='r3c5i3' class='p0' onclick='pu(5,3);'>&nbsp</div><div id='r3c5i4' class='p0' onclick='pu(5,3);'>&nbsp</div><div id='r3c5i5' class='p0' onclick='pu(5,3);'>&nbsp</div><div id='r3c5i6' class='p0' onclick='pu(5,3);'>&nbsp</div><div id='r3c5i7' class='p0' onclick='pu(5,3);'>&nbsp</div><div id='r3c5i8' class='p0' onclick='pu(5,3);'>&nbsp</div><div class='dv' id='r3c5'>&nbsp;</div></div>
<div id='tr3c6' class='t0 n1'><div id='r3c6i0' class='p0' onclick='pu(6,3);'>&nbsp</div><div id='r3c6i1' class='p0' onclick='pu(6,3);'>&nbsp</div><div id='r3c6i2' class='p0' onclick='pu(6,3);'>&nbsp</div><div id='r3c6i3' class='p0' onclick='pu(6,3);'>&nbsp</div><div id='r3c6i4' class='p0' onclick='pu(6,3);'>&nbsp</div><div id='r3c6i5' class='p0' onclick='pu(6,3);'>&nbsp</div><div id='r3c6i6' class='p0' onclick='pu(6,3);'>&nbsp</div><div id='r3c6i7' class='p0' onclick='pu(6,3);'>&nbsp</div><div id='r3c6i8' class='p0' onclick='pu(6,3);'>&nbsp</div><div class='dv' id='r3c6'>&nbsp;</div></div>
<div id='tr3c7' class='t0 n1'><div id='r3c7i0' class='p0' onclick='pu(7,3);'>&nbsp</div><div id='r3c7i1' class='p0' onclick='pu(7,3);'>&nbsp</div><div id='r3c7i2' class='p0' onclick='pu(7,3);'>&nbsp</div><div id='r3c7i3' class='p0' onclick='pu(7,3);'>&nbsp</div><div id='r3c7i4' class='p0' onclick='pu(7,3);'>&nbsp</div><div id='r3c7i5' class='p0' onclick='pu(7,3);'>&nbsp</div><div id='r3c7i6' class='p0' onclick='pu(7,3);'>&nbsp</div><div id='r3c7i7' class='p0' onclick='pu(7,3);'>&nbsp</div><div id='r3c7i8' class='p0' onclick='pu(7,3);'>&nbsp</div><div class='dv' id='r3c7'>&nbsp;</div></div>
<div id='tr3c8' class='t0 e2 n1'><div id='r3c8i0' class='p0' onclick='pu(8,3);'>&nbsp</div><div id='r3c8i1' class='p0' onclick='pu(8,3);'>&nbsp</div><div id='r3c8i2' class='p0' onclick='pu(8,3);'>&nbsp</div><div id='r3c8i3' class='p0' onclick='pu(8,3);'>&nbsp</div><div id='r3c8i4' class='p0' onclick='pu(8,3);'>&nbsp</div><div id='r3c8i5' class='p0' onclick='pu(8,3);'>&nbsp</div><div id='r3c8i6' class='p0' onclick='pu(8,3);'>&nbsp</div><div id='r3c8i7' class='p0' onclick='pu(8,3);'>&nbsp</div><div id='r3c8i8' class='p0' onclick='pu(8,3);'>&nbsp</div><div class='dv' id='r3c8'>&nbsp;</div></div>
<div id='tr4c0' class='t0 e3 n1'><div id='r4c0i0' class='p0' onclick='pu(0,4);'>&nbsp</div><div id='r4c0i1' class='p0' onclick='pu(0,4);'>&nbsp</div><div id='r4c0i2' class='p0' onclick='pu(0,4);'>&nbsp</div><div id='r4c0i3' class='p0' onclick='pu(0,4);'>&nbsp</div><div id='r4c0i4' class='p0' onclick='pu(0,4);'>&nbsp</div><div id='r4c0i5' class='p0' onclick='pu(0,4);'>&nbsp</div><div id='r4c0i6' class='p0' onclick='pu(0,4);'>&nbsp</div><div id='r4c0i7' class='p0' onclick='pu(0,4);'>&nbsp</div><div id='r4c0i8' class='p0' onclick='pu(0,4);'>&nbsp</div><div class='dv' id='r4c0'>&nbsp;</div></div>
<div id='tr4c1' class='t0 n1'><div id='r4c1i0' class='p0' onclick='pu(1,4);'>&nbsp</div><div id='r4c1i1' class='p0' onclick='pu(1,4);'>&nbsp</div><div id='r4c1i2' class='p0' onclick='pu(1,4);'>&nbsp</div><div id='r4c1i3' class='p0' onclick='pu(1,4);'>&nbsp</div><div id='r4c1i4' class='p0' onclick='pu(1,4);'>&nbsp</div><div id='r4c1i5' class='p0' onclick='pu(1,4);'>&nbsp</div><div id='r4c1i6' class='p0' onclick='pu(1,4);'>&nbsp</div><div id='r4c1i7' class='p0' onclick='pu(1,4);'>&nbsp</div><div id='r4c1i8' class='p0' onclick='pu(1,4);'>&nbsp</div><div class='dv' id='r4c1'>&nbsp;</div></div>
<div id='tr4c2' class='t0 r2 n1'><div id='r4c2i0' class='p0' onclick='pu(2,4);'>&nbsp</div><div id='r4c2i1' class='p0' onclick='pu(2,4);'>&nbsp</div><div id='r4c2i2' class='p0' onclick='pu(2,4);'>&nbsp</div><div id='r4c2i3' class='p0' onclick='pu(2,4);'>&nbsp</div><div id='r4c2i4' class='p0' onclick='pu(2,4);'>&nbsp</div><div id='r4c2i5' class='p0' onclick='pu(2,4);'>&nbsp</div><div id='r4c2i6' class='p0' onclick='pu(2,4);'>&nbsp</div><div id='r4c2i7' class='p0' onclick='pu(2,4);'>&nbsp</div><div id='r4c2i8' class='p0' onclick='pu(2,4);'>&nbsp</div><div class='dv' id='r4c2'>&nbsp;</div></div>
<div id='tr4c3' class='t0 n1'><div id='r4c3i0' class='p0' onclick='pu(3,4);'>&nbsp</div><div id='r4c3i1' class='p0' onclick='pu(3,4);'>&nbsp</div><div id='r4c3i2' class='p0' onclick='pu(3,4);'>&nbsp</div><div id='r4c3i3' class='p0' onclick='pu(3,4);'>&nbsp</div><div id='r4c3i4' class='p0' onclick='pu(3,4);'>&nbsp</div><div id='r4c3i5' class='p0' onclick='pu(3,4);'>&nbsp</div><div id='r4c3i6' class='p0' onclick='pu(3,4);'>&nbsp</div><div id='r4c3i7' class='p0' onclick='pu(3,4);'>&nbsp</div><div id='r4c3i8' class='p0' onclick='pu(3,4);'>&nbsp</div><div class='dv' id='r4c3'>&nbsp;</div></div>
<div id='tr4c4' class='t0 n1'><div id='r4c4i0' class='p0' onclick='pu(4,4);'>&nbsp</div><div id='r4c4i1' class='p0' onclick='pu(4,4);'>&nbsp</div><div id='r4c4i2' class='p0' onclick='pu(4,4);'>&nbsp</div><div id='r4c4i3' class='p0' onclick='pu(4,4);'>&nbsp</div><div id='r4c4i4' class='p0' onclick='pu(4,4);'>&nbsp</div><div id='r4c4i5' class='p0' onclick='pu(4,4);'>&nbsp</div><div id='r4c4i6' class='p0' onclick='pu(4,4);'>&nbsp</div><div id='r4c4i7' class='p0' onclick='pu(4,4);'>&nbsp</div><div id='r4c4i8' class='p0' onclick='pu(4,4);'>&nbsp</div><div class='dv' id='r4c4'>&nbsp;</div></div>
<div id='tr4c5' class='t0 r2 n1'><div id='r4c5i0' class='p0' onclick='pu(5,4);'>&nbsp</div><div id='r4c5i1' class='p0' onclick='pu(5,4);'>&nbsp</div><div id='r4c5i2' class='p0' onclick='pu(5,4);'>&nbsp</div><div id='r4c5i3' class='p0' onclick='pu(5,4);'>&nbsp</div><div id='r4c5i4' class='p0' onclick='pu(5,4);'>&nbsp</div><div id='r4c5i5' class='p0' onclick='pu(5,4);'>&nbsp</div><div id='r4c5i6' class='p0' onclick='pu(5,4);'>&nbsp</div><div id='r4c5i7' class='p0' onclick='pu(5,4);'>&nbsp</div><div id='r4c5i8' class='p0' onclick='pu(5,4);'>&nbsp</div><div class='dv' id='r4c5'>&nbsp;</div></div>
<div id='tr4c6' class='t0 n1'><div id='r4c6i0' class='p0' onclick='pu(6,4);'>&nbsp</div><div id='r4c6i1' class='p0' onclick='pu(6,4);'>&nbsp</div><div id='r4c6i2' class='p0' onclick='pu(6,4);'>&nbsp</div><div id='r4c6i3' class='p0' onclick='pu(6,4);'>&nbsp</div><div id='r4c6i4' class='p0' onclick='pu(6,4);'>&nbsp</div><div id='r4c6i5' class='p0' onclick='pu(6,4);'>&nbsp</div><div id='r4c6i6' class='p0' onclick='pu(6,4);'>&nbsp</div><div id='r4c6i7' class='p0' onclick='pu(6,4);'>&nbsp</div><div id='r4c6i8' class='p0' onclick='pu(6,4);'>&nbsp</div><div class='dv' id='r4c6'>&nbsp;</div></div>
<div id='tr4c7' class='t0 n1'><div id='r4c7i0' class='p0' onclick='pu(7,4);'>&nbsp</div><div id='r4c7i1' class='p0' onclick='pu(7,4);'>&nbsp</div><div id='r4c7i2' class='p0' onclick='pu(7,4);'>&nbsp</div><div id='r4c7i3' class='p0' onclick='pu(7,4);'>&nbsp</div><div id='r4c7i4' class='p0' onclick='pu(7,4);'>&nbsp</div><div id='r4c7i5' class='p0' onclick='pu(7,4);'>&nbsp</div><div id='r4c7i6' class='p0' onclick='pu(7,4);'>&nbsp</div><div id='r4c7i7' class='p0' onclick='pu(7,4);'>&nbsp</div><div id='r4c7i8' class='p0' onclick='pu(7,4);'>&nbsp</div><div class='dv' id='r4c7'>&nbsp;</div></div>
<div id='tr4c8' class='t0 e2 n1'><div id='r4c8i0' class='p0' onclick='pu(8,4);'>&nbsp</div><div id='r4c8i1' class='p0' onclick='pu(8,4);'>&nbsp</div><div id='r4c8i2' class='p0' onclick='pu(8,4);'>&nbsp</div><div id='r4c8i3' class='p0' onclick='pu(8,4);'>&nbsp</div><div id='r4c8i4' class='p0' onclick='pu(8,4);'>&nbsp</div><div id='r4c8i5' class='p0' onclick='pu(8,4);'>&nbsp</div><div id='r4c8i6' class='p0' onclick='pu(8,4);'>&nbsp</div><div id='r4c8i7' class='p0' onclick='pu(8,4);'>&nbsp</div><div id='r4c8i8' class='p0' onclick='pu(8,4);'>&nbsp</div><div class='dv' id='r4c8'>&nbsp;</div></div>
<div id='tr5c0' class='t0 r1 e3 n1'><div id='r5c0i0' class='p0' onclick='pu(0,5);'>&nbsp</div><div id='r5c0i1' class='p0' onclick='pu(0,5);'>&nbsp</div><div id='r5c0i2' class='p0' onclick='pu(0,5);'>&nbsp</div><div id='r5c0i3' class='p0' onclick='pu(0,5);'>&nbsp</div><div id='r5c0i4' class='p0' onclick='pu(0,5);'>&nbsp</div><div id='r5c0i5' class='p0' onclick='pu(0,5);'>&nbsp</div><div id='r5c0i6' class='p0' onclick='pu(0,5);'>&nbsp</div><div id='r5c0i7' class='p0' onclick='pu(0,5);'>&nbsp</div><div id='r5c0i8' class='p0' onclick='pu(0,5);'>&nbsp</div><div class='dv' id='r5c0'>&nbsp;</div></div>
<div id='tr5c1' class='t0 r1 n1'><div id='r5c1i0' class='p0' onclick='pu(1,5);'>&nbsp</div><div id='r5c1i1' class='p0' onclick='pu(1,5);'>&nbsp</div><div id='r5c1i2' class='p0' onclick='pu(1,5);'>&nbsp</div><div id='r5c1i3' class='p0' onclick='pu(1,5);'>&nbsp</div><div id='r5c1i4' class='p0' onclick='pu(1,5);'>&nbsp</div><div id='r5c1i5' class='p0' onclick='pu(1,5);'>&nbsp</div><div id='r5c1i6' class='p0' onclick='pu(1,5);'>&nbsp</div><div id='r5c1i7' class='p0' onclick='pu(1,5);'>&nbsp</div><div id='r5c1i8' class='p0' onclick='pu(1,5);'>&nbsp</div><div class='dv' id='r5c1'>&nbsp;</div></div>
<div id='tr5c2' class='t0 r1 r2 n1'><div id='r5c2i0' class='p0' onclick='pu(2,5);'>&nbsp</div><div id='r5c2i1' class='p0' onclick='pu(2,5);'>&nbsp</div><div id='r5c2i2' class='p0' onclick='pu(2,5);'>&nbsp</div><div id='r5c2i3' class='p0' onclick='pu(2,5);'>&nbsp</div><div id='r5c2i4' class='p0' onclick='pu(2,5);'>&nbsp</div><div id='r5c2i5' class='p0' onclick='pu(2,5);'>&nbsp</div><div id='r5c2i6' class='p0' onclick='pu(2,5);'>&nbsp</div><div id='r5c2i7' class='p0' onclick='pu(2,5);'>&nbsp</div><div id='r5c2i8' class='p0' onclick='pu(2,5);'>&nbsp</div><div class='dv' id='r5c2'>&nbsp;</div></div>
<div id='tr5c3' class='t0 r1 n1'><div id='r5c3i0' class='p0' onclick='pu(3,5);'>&nbsp</div><div id='r5c3i1' class='p0' onclick='pu(3,5);'>&nbsp</div><div id='r5c3i2' class='p0' onclick='pu(3,5);'>&nbsp</div><div id='r5c3i3' class='p0' onclick='pu(3,5);'>&nbsp</div><div id='r5c3i4' class='p0' onclick='pu(3,5);'>&nbsp</div><div id='r5c3i5' class='p0' onclick='pu(3,5);'>&nbsp</div><div id='r5c3i6' class='p0' onclick='pu(3,5);'>&nbsp</div><div id='r5c3i7' class='p0' onclick='pu(3,5);'>&nbsp</div><div id='r5c3i8' class='p0' onclick='pu(3,5);'>&nbsp</div><div class='dv' id='r5c3'>&nbsp;</div></div>
<div id='tr5c4' class='t0 r1 n1'><div id='r5c4i0' class='p0' onclick='pu(4,5);'>&nbsp</div><div id='r5c4i1' class='p0' onclick='pu(4,5);'>&nbsp</div><div id='r5c4i2' class='p0' onclick='pu(4,5);'>&nbsp</div><div id='r5c4i3' class='p0' onclick='pu(4,5);'>&nbsp</div><div id='r5c4i4' class='p0' onclick='pu(4,5);'>&nbsp</div><div id='r5c4i5' class='p0' onclick='pu(4,5);'>&nbsp</div><div id='r5c4i6' class='p0' onclick='pu(4,5);'>&nbsp</div><div id='r5c4i7' class='p0' onclick='pu(4,5);'>&nbsp</div><div id='r5c4i8' class='p0' onclick='pu(4,5);'>&nbsp</div><div class='dv' id='r5c4'>&nbsp;</div></div>
<div id='tr5c5' class='t0 r1 r2 n1'><div id='r5c5i0' class='p0' onclick='pu(5,5);'>&nbsp</div><div id='r5c5i1' class='p0' onclick='pu(5,5);'>&nbsp</div><div id='r5c5i2' class='p0' onclick='pu(5,5);'>&nbsp</div><div id='r5c5i3' class='p0' onclick='pu(5,5);'>&nbsp</div><div id='r5c5i4' class='p0' onclick='pu(5,5);'>&nbsp</div><div id='r5c5i5' class='p0' onclick='pu(5,5);'>&nbsp</div><div id='r5c5i6' class='p0' onclick='pu(5,5);'>&nbsp</div><div id='r5c5i7' class='p0' onclick='pu(5,5);'>&nbsp</div><div id='r5c5i8' class='p0' onclick='pu(5,5);'>&nbsp</div><div class='dv' id='r5c5'>&nbsp;</div></div>
<div id='tr5c6' class='t0 r1 n1'><div id='r5c6i0' class='p0' onclick='pu(6,5);'>&nbsp</div><div id='r5c6i1' class='p0' onclick='pu(6,5);'>&nbsp</div><div id='r5c6i2' class='p0' onclick='pu(6,5);'>&nbsp</div><div id='r5c6i3' class='p0' onclick='pu(6,5);'>&nbsp</div><div id='r5c6i4' class='p0' onclick='pu(6,5);'>&nbsp</div><div id='r5c6i5' class='p0' onclick='pu(6,5);'>&nbsp</div><div id='r5c6i6' class='p0' onclick='pu(6,5);'>&nbsp</div><div id='r5c6i7' class='p0' onclick='pu(6,5);'>&nbsp</div><div id='r5c6i8' class='p0' onclick='pu(6,5);'>&nbsp</div><div class='dv' id='r5c6'>&nbsp;</div></div>
<div id='tr5c7' class='t0 r1 n1'><div id='r5c7i0' class='p0' onclick='pu(7,5);'>&nbsp</div><div id='r5c7i1' class='p0' onclick='pu(7,5);'>&nbsp</div><div id='r5c7i2' class='p0' onclick='pu(7,5);'>&nbsp</div><div id='r5c7i3' class='p0' onclick='pu(7,5);'>&nbsp</div><div id='r5c7i4' class='p0' onclick='pu(7,5);'>&nbsp</div><div id='r5c7i5' class='p0' onclick='pu(7,5);'>&nbsp</div><div id='r5c7i6' class='p0' onclick='pu(7,5);'>&nbsp</div><div id='r5c7i7' class='p0' onclick='pu(7,5);'>&nbsp</div><div id='r5c7i8' class='p0' onclick='pu(7,5);'>&nbsp</div><div class='dv' id='r5c7'>&nbsp;</div></div>
<div id='tr5c8' class='t0 r1 e2 n1'><div id='r5c8i0' class='p0' onclick='pu(8,5);'>&nbsp</div><div id='r5c8i1' class='p0' onclick='pu(8,5);'>&nbsp</div><div id='r5c8i2' class='p0' onclick='pu(8,5);'>&nbsp</div><div id='r5c8i3' class='p0' onclick='pu(8,5);'>&nbsp</div><div id='r5c8i4' class='p0' onclick='pu(8,5);'>&nbsp</div><div id='r5c8i5' class='p0' onclick='pu(8,5);'>&nbsp</div><div id='r5c8i6' class='p0' onclick='pu(8,5);'>&nbsp</div><div id='r5c8i7' class='p0' onclick='pu(8,5);'>&nbsp</div><div id='r5c8i8' class='p0' onclick='pu(8,5);'>&nbsp</div><div class='dv' id='r5c8'>&nbsp;</div></div>
<div id='tr6c0' class='t0 e3 n1'><div id='r6c0i0' class='p0' onclick='pu(0,6);'>&nbsp</div><div id='r6c0i1' class='p0' onclick='pu(0,6);'>&nbsp</div><div id='r6c0i2' class='p0' onclick='pu(0,6);'>&nbsp</div><div id='r6c0i3' class='p0' onclick='pu(0,6);'>&nbsp</div><div id='r6c0i4' class='p0' onclick='pu(0,6);'>&nbsp</div><div id='r6c0i5' class='p0' onclick='pu(0,6);'>&nbsp</div><div id='r6c0i6' class='p0' onclick='pu(0,6);'>&nbsp</div><div id='r6c0i7' class='p0' onclick='pu(0,6);'>&nbsp</div><div id='r6c0i8' class='p0' onclick='pu(0,6);'>&nbsp</div><div class='dv' id='r6c0'>&nbsp;</div></div>
<div id='tr6c1' class='t0 n1'><div id='r6c1i0' class='p0' onclick='pu(1,6);'>&nbsp</div><div id='r6c1i1' class='p0' onclick='pu(1,6);'>&nbsp</div><div id='r6c1i2' class='p0' onclick='pu(1,6);'>&nbsp</div><div id='r6c1i3' class='p0' onclick='pu(1,6);'>&nbsp</div><div id='r6c1i4' class='p0' onclick='pu(1,6);'>&nbsp</div><div id='r6c1i5' class='p0' onclick='pu(1,6);'>&nbsp</div><div id='r6c1i6' class='p0' onclick='pu(1,6);'>&nbsp</div><div id='r6c1i7' class='p0' onclick='pu(1,6);'>&nbsp</div><div id='r6c1i8' class='p0' onclick='pu(1,6);'>&nbsp</div><div class='dv' id='r6c1'>&nbsp;</div></div>
<div id='tr6c2' class='t0 r2 n1'><div id='r6c2i0' class='p0' onclick='pu(2,6);'>&nbsp</div><div id='r6c2i1' class='p0' onclick='pu(2,6);'>&nbsp</div><div id='r6c2i2' class='p0' onclick='pu(2,6);'>&nbsp</div><div id='r6c2i3' class='p0' onclick='pu(2,6);'>&nbsp</div><div id='r6c2i4' class='p0' onclick='pu(2,6);'>&nbsp</div><div id='r6c2i5' class='p0' onclick='pu(2,6);'>&nbsp</div><div id='r6c2i6' class='p0' onclick='pu(2,6);'>&nbsp</div><div id='r6c2i7' class='p0' onclick='pu(2,6);'>&nbsp</div><div id='r6c2i8' class='p0' onclick='pu(2,6);'>&nbsp</div><div class='dv' id='r6c2'>&nbsp;</div></div>
<div id='tr6c3' class='t0 n1'><div id='r6c3i0' class='p0' onclick='pu(3,6);'>&nbsp</div><div id='r6c3i1' class='p0' onclick='pu(3,6);'>&nbsp</div><div id='r6c3i2' class='p0' onclick='pu(3,6);'>&nbsp</div><div id='r6c3i3' class='p0' onclick='pu(3,6);'>&nbsp</div><div id='r6c3i4' class='p0' onclick='pu(3,6);'>&nbsp</div><div id='r6c3i5' class='p0' onclick='pu(3,6);'>&nbsp</div><div id='r6c3i6' class='p0' onclick='pu(3,6);'>&nbsp</div><div id='r6c3i7' class='p0' onclick='pu(3,6);'>&nbsp</div><div id='r6c3i8' class='p0' onclick='pu(3,6);'>&nbsp</div><div class='dv' id='r6c3'>&nbsp;</div></div>
<div id='tr6c4' class='t0 n1'><div id='r6c4i0' class='p0' onclick='pu(4,6);'>&nbsp</div><div id='r6c4i1' class='p0' onclick='pu(4,6);'>&nbsp</div><div id='r6c4i2' class='p0' onclick='pu(4,6);'>&nbsp</div><div id='r6c4i3' class='p0' onclick='pu(4,6);'>&nbsp</div><div id='r6c4i4' class='p0' onclick='pu(4,6);'>&nbsp</div><div id='r6c4i5' class='p0' onclick='pu(4,6);'>&nbsp</div><div id='r6c4i6' class='p0' onclick='pu(4,6);'>&nbsp</div><div id='r6c4i7' class='p0' onclick='pu(4,6);'>&nbsp</div><div id='r6c4i8' class='p0' onclick='pu(4,6);'>&nbsp</div><div class='dv' id='r6c4'>&nbsp;</div></div>
<div id='tr6c5' class='t0 r2 n1'><div id='r6c5i0' class='p0' onclick='pu(5,6);'>&nbsp</div><div id='r6c5i1' class='p0' onclick='pu(5,6);'>&nbsp</div><div id='r6c5i2' class='p0' onclick='pu(5,6);'>&nbsp</div><div id='r6c5i3' class='p0' onclick='pu(5,6);'>&nbsp</div><div id='r6c5i4' class='p0' onclick='pu(5,6);'>&nbsp</div><div id='r6c5i5' class='p0' onclick='pu(5,6);'>&nbsp</div><div id='r6c5i6' class='p0' onclick='pu(5,6);'>&nbsp</div><div id='r6c5i7' class='p0' onclick='pu(5,6);'>&nbsp</div><div id='r6c5i8' class='p0' onclick='pu(5,6);'>&nbsp</div><div class='dv' id='r6c5'>&nbsp;</div></div>
<div id='tr6c6' class='t0 n1'><div id='r6c6i0' class='p0' onclick='pu(6,6);'>&nbsp</div><div id='r6c6i1' class='p0' onclick='pu(6,6);'>&nbsp</div><div id='r6c6i2' class='p0' onclick='pu(6,6);'>&nbsp</div><div id='r6c6i3' class='p0' onclick='pu(6,6);'>&nbsp</div><div id='r6c6i4' class='p0' onclick='pu(6,6);'>&nbsp</div><div id='r6c6i5' class='p0' onclick='pu(6,6);'>&nbsp</div><div id='r6c6i6' class='p0' onclick='pu(6,6);'>&nbsp</div><div id='r6c6i7' class='p0' onclick='pu(6,6);'>&nbsp</div><div id='r6c6i8' class='p0' onclick='pu(6,6);'>&nbsp</div><div class='dv' id='r6c6'>&nbsp;</div></div>
<div id='tr6c7' class='t0 n1'><div id='r6c7i0' class='p0' onclick='pu(7,6);'>&nbsp</div><div id='r6c7i1' class='p0' onclick='pu(7,6);'>&nbsp</div><div id='r6c7i2' class='p0' onclick='pu(7,6);'>&nbsp</div><div id='r6c7i3' class='p0' onclick='pu(7,6);'>&nbsp</div><div id='r6c7i4' class='p0' onclick='pu(7,6);'>&nbsp</div><div id='r6c7i5' class='p0' onclick='pu(7,6);'>&nbsp</div><div id='r6c7i6' class='p0' onclick='pu(7,6);'>&nbsp</div><div id='r6c7i7' class='p0' onclick='pu(7,6);'>&nbsp</div><div id='r6c7i8' class='p0' onclick='pu(7,6);'>&nbsp</div><div class='dv' id='r6c7'>&nbsp;</div></div>
<div id='tr6c8' class='t0 e2 n1'><div id='r6c8i0' class='p0' onclick='pu(8,6);'>&nbsp</div><div id='r6c8i1' class='p0' onclick='pu(8,6);'>&nbsp</div><div id='r6c8i2' class='p0' onclick='pu(8,6);'>&nbsp</div><div id='r6c8i3' class='p0' onclick='pu(8,6);'>&nbsp</div><div id='r6c8i4' class='p0' onclick='pu(8,6);'>&nbsp</div><div id='r6c8i5' class='p0' onclick='pu(8,6);'>&nbsp</div><div id='r6c8i6' class='p0' onclick='pu(8,6);'>&nbsp</div><div id='r6c8i7' class='p0' onclick='pu(8,6);'>&nbsp</div><div id='r6c8i8' class='p0' onclick='pu(8,6);'>&nbsp</div><div class='dv' id='r6c8'>&nbsp;</div></div>
<div id='tr7c0' class='t0 e3 n1'><div id='r7c0i0' class='p0' onclick='pu(0,7);'>&nbsp</div><div id='r7c0i1' class='p0' onclick='pu(0,7);'>&nbsp</div><div id='r7c0i2' class='p0' onclick='pu(0,7);'>&nbsp</div><div id='r7c0i3' class='p0' onclick='pu(0,7);'>&nbsp</div><div id='r7c0i4' class='p0' onclick='pu(0,7);'>&nbsp</div><div id='r7c0i5' class='p0' onclick='pu(0,7);'>&nbsp</div><div id='r7c0i6' class='p0' onclick='pu(0,7);'>&nbsp</div><div id='r7c0i7' class='p0' onclick='pu(0,7);'>&nbsp</div><div id='r7c0i8' class='p0' onclick='pu(0,7);'>&nbsp</div><div class='dv' id='r7c0'>&nbsp;</div></div>
<div id='tr7c1' class='t0 n1'><div id='r7c1i0' class='p0' onclick='pu(1,7);'>&nbsp</div><div id='r7c1i1' class='p0' onclick='pu(1,7);'>&nbsp</div><div id='r7c1i2' class='p0' onclick='pu(1,7);'>&nbsp</div><div id='r7c1i3' class='p0' onclick='pu(1,7);'>&nbsp</div><div id='r7c1i4' class='p0' onclick='pu(1,7);'>&nbsp</div><div id='r7c1i5' class='p0' onclick='pu(1,7);'>&nbsp</div><div id='r7c1i6' class='p0' onclick='pu(1,7);'>&nbsp</div><div id='r7c1i7' class='p0' onclick='pu(1,7);'>&nbsp</div><div id='r7c1i8' class='p0' onclick='pu(1,7);'>&nbsp</div><div class='dv' id='r7c1'>&nbsp;</div></div>
<div id='tr7c2' class='t0 r2 n1'><div id='r7c2i0' class='p0' onclick='pu(2,7);'>&nbsp</div><div id='r7c2i1' class='p0' onclick='pu(2,7);'>&nbsp</div><div id='r7c2i2' class='p0' onclick='pu(2,7);'>&nbsp</div><div id='r7c2i3' class='p0' onclick='pu(2,7);'>&nbsp</div><div id='r7c2i4' class='p0' onclick='pu(2,7);'>&nbsp</div><div id='r7c2i5' class='p0' onclick='pu(2,7);'>&nbsp</div><div id='r7c2i6' class='p0' onclick='pu(2,7);'>&nbsp</div><div id='r7c2i7' class='p0' onclick='pu(2,7);'>&nbsp</div><div id='r7c2i8' class='p0' onclick='pu(2,7);'>&nbsp</div><div class='dv' id='r7c2'>&nbsp;</div></div>
<div id='tr7c3' class='t0 n1'><div id='r7c3i0' class='p0' onclick='pu(3,7);'>&nbsp</div><div id='r7c3i1' class='p0' onclick='pu(3,7);'>&nbsp</div><div id='r7c3i2' class='p0' onclick='pu(3,7);'>&nbsp</div><div id='r7c3i3' class='p0' onclick='pu(3,7);'>&nbsp</div><div id='r7c3i4' class='p0' onclick='pu(3,7);'>&nbsp</div><div id='r7c3i5' class='p0' onclick='pu(3,7);'>&nbsp</div><div id='r7c3i6' class='p0' onclick='pu(3,7);'>&nbsp</div><div id='r7c3i7' class='p0' onclick='pu(3,7);'>&nbsp</div><div id='r7c3i8' class='p0' onclick='pu(3,7);'>&nbsp</div><div class='dv' id='r7c3'>&nbsp;</div></div>
<div id='tr7c4' class='t0 n1'><div id='r7c4i0' class='p0' onclick='pu(4,7);'>&nbsp</div><div id='r7c4i1' class='p0' onclick='pu(4,7);'>&nbsp</div><div id='r7c4i2' class='p0' onclick='pu(4,7);'>&nbsp</div><div id='r7c4i3' class='p0' onclick='pu(4,7);'>&nbsp</div><div id='r7c4i4' class='p0' onclick='pu(4,7);'>&nbsp</div><div id='r7c4i5' class='p0' onclick='pu(4,7);'>&nbsp</div><div id='r7c4i6' class='p0' onclick='pu(4,7);'>&nbsp</div><div id='r7c4i7' class='p0' onclick='pu(4,7);'>&nbsp</div><div id='r7c4i8' class='p0' onclick='pu(4,7);'>&nbsp</div><div class='dv' id='r7c4'>&nbsp;</div></div>
<div id='tr7c5' class='t0 r2 n1'><div id='r7c5i0' class='p0' onclick='pu(5,7);'>&nbsp</div><div id='r7c5i1' class='p0' onclick='pu(5,7);'>&nbsp</div><div id='r7c5i2' class='p0' onclick='pu(5,7);'>&nbsp</div><div id='r7c5i3' class='p0' onclick='pu(5,7);'>&nbsp</div><div id='r7c5i4' class='p0' onclick='pu(5,7);'>&nbsp</div><div id='r7c5i5' class='p0' onclick='pu(5,7);'>&nbsp</div><div id='r7c5i6' class='p0' onclick='pu(5,7);'>&nbsp</div><div id='r7c5i7' class='p0' onclick='pu(5,7);'>&nbsp</div><div id='r7c5i8' class='p0' onclick='pu(5,7);'>&nbsp</div><div class='dv' id='r7c5'>&nbsp;</div></div>
<div id='tr7c6' class='t0 n1'><div id='r7c6i0' class='p0' onclick='pu(6,7);'>&nbsp</div><div id='r7c6i1' class='p0' onclick='pu(6,7);'>&nbsp</div><div id='r7c6i2' class='p0' onclick='pu(6,7);'>&nbsp</div><div id='r7c6i3' class='p0' onclick='pu(6,7);'>&nbsp</div><div id='r7c6i4' class='p0' onclick='pu(6,7);'>&nbsp</div><div id='r7c6i5' class='p0' onclick='pu(6,7);'>&nbsp</div><div id='r7c6i6' class='p0' onclick='pu(6,7);'>&nbsp</div><div id='r7c6i7' class='p0' onclick='pu(6,7);'>&nbsp</div><div id='r7c6i8' class='p0' onclick='pu(6,7);'>&nbsp</div><div class='dv' id='r7c6'>&nbsp;</div></div>
<div id='tr7c7' class='t0 n1'><div id='r7c7i0' class='p0' onclick='pu(7,7);'>&nbsp</div><div id='r7c7i1' class='p0' onclick='pu(7,7);'>&nbsp</div><div id='r7c7i2' class='p0' onclick='pu(7,7);'>&nbsp</div><div id='r7c7i3' class='p0' onclick='pu(7,7);'>&nbsp</div><div id='r7c7i4' class='p0' onclick='pu(7,7);'>&nbsp</div><div id='r7c7i5' class='p0' onclick='pu(7,7);'>&nbsp</div><div id='r7c7i6' class='p0' onclick='pu(7,7);'>&nbsp</div><div id='r7c7i7' class='p0' onclick='pu(7,7);'>&nbsp</div><div id='r7c7i8' class='p0' onclick='pu(7,7);'>&nbsp</div><div class='dv' id='r7c7'>&nbsp;</div></div>
<div id='tr7c8' class='t0 e2 n1'><div id='r7c8i0' class='p0' onclick='pu(8,7);'>&nbsp</div><div id='r7c8i1' class='p0' onclick='pu(8,7);'>&nbsp</div><div id='r7c8i2' class='p0' onclick='pu(8,7);'>&nbsp</div><div id='r7c8i3' class='p0' onclick='pu(8,7);'>&nbsp</div><div id='r7c8i4' class='p0' onclick='pu(8,7);'>&nbsp</div><div id='r7c8i5' class='p0' onclick='pu(8,7);'>&nbsp</div><div id='r7c8i6' class='p0' onclick='pu(8,7);'>&nbsp</div><div id='r7c8i7' class='p0' onclick='pu(8,7);'>&nbsp</div><div id='r7c8i8' class='p0' onclick='pu(8,7);'>&nbsp</div><div class='dv' id='r7c8'>&nbsp;</div></div>
<div id='tr8c0' class='t0 e3 e1 n1'><div id='r8c0i0' class='p0' onclick='pu(0,8);'>&nbsp</div><div id='r8c0i1' class='p0' onclick='pu(0,8);'>&nbsp</div><div id='r8c0i2' class='p0' onclick='pu(0,8);'>&nbsp</div><div id='r8c0i3' class='p0' onclick='pu(0,8);'>&nbsp</div><div id='r8c0i4' class='p0' onclick='pu(0,8);'>&nbsp</div><div id='r8c0i5' class='p0' onclick='pu(0,8);'>&nbsp</div><div id='r8c0i6' class='p0' onclick='pu(0,8);'>&nbsp</div><div id='r8c0i7' class='p0' onclick='pu(0,8);'>&nbsp</div><div id='r8c0i8' class='p0' onclick='pu(0,8);'>&nbsp</div><div class='dv' id='r8c0'>&nbsp;</div></div>
<div id='tr8c1' class='t0 e1 n1'><div id='r8c1i0' class='p0' onclick='pu(1,8);'>&nbsp</div><div id='r8c1i1' class='p0' onclick='pu(1,8);'>&nbsp</div><div id='r8c1i2' class='p0' onclick='pu(1,8);'>&nbsp</div><div id='r8c1i3' class='p0' onclick='pu(1,8);'>&nbsp</div><div id='r8c1i4' class='p0' onclick='pu(1,8);'>&nbsp</div><div id='r8c1i5' class='p0' onclick='pu(1,8);'>&nbsp</div><div id='r8c1i6' class='p0' onclick='pu(1,8);'>&nbsp</div><div id='r8c1i7' class='p0' onclick='pu(1,8);'>&nbsp</div><div id='r8c1i8' class='p0' onclick='pu(1,8);'>&nbsp</div><div class='dv' id='r8c1'>&nbsp;</div></div>
<div id='tr8c2' class='t0 r2 e1 n1'><div id='r8c2i0' class='p0' onclick='pu(2,8);'>&nbsp</div><div id='r8c2i1' class='p0' onclick='pu(2,8);'>&nbsp</div><div id='r8c2i2' class='p0' onclick='pu(2,8);'>&nbsp</div><div id='r8c2i3' class='p0' onclick='pu(2,8);'>&nbsp</div><div id='r8c2i4' class='p0' onclick='pu(2,8);'>&nbsp</div><div id='r8c2i5' class='p0' onclick='pu(2,8);'>&nbsp</div><div id='r8c2i6' class='p0' onclick='pu(2,8);'>&nbsp</div><div id='r8c2i7' class='p0' onclick='pu(2,8);'>&nbsp</div><div id='r8c2i8' class='p0' onclick='pu(2,8);'>&nbsp</div><div class='dv' id='r8c2'>&nbsp;</div></div>
<div id='tr8c3' class='t0 e1 n1'><div id='r8c3i0' class='p0' onclick='pu(3,8);'>&nbsp</div><div id='r8c3i1' class='p0' onclick='pu(3,8);'>&nbsp</div><div id='r8c3i2' class='p0' onclick='pu(3,8);'>&nbsp</div><div id='r8c3i3' class='p0' onclick='pu(3,8);'>&nbsp</div><div id='r8c3i4' class='p0' onclick='pu(3,8);'>&nbsp</div><div id='r8c3i5' class='p0' onclick='pu(3,8);'>&nbsp</div><div id='r8c3i6' class='p0' onclick='pu(3,8);'>&nbsp</div><div id='r8c3i7' class='p0' onclick='pu(3,8);'>&nbsp</div><div id='r8c3i8' class='p0' onclick='pu(3,8);'>&nbsp</div><div class='dv' id='r8c3'>&nbsp;</div></div>
<div id='tr8c4' class='t0 e1 n1'><div id='r8c4i0' class='p0' onclick='pu(4,8);'>&nbsp</div><div id='r8c4i1' class='p0' onclick='pu(4,8);'>&nbsp</div><div id='r8c4i2' class='p0' onclick='pu(4,8);'>&nbsp</div><div id='r8c4i3' class='p0' onclick='pu(4,8);'>&nbsp</div><div id='r8c4i4' class='p0' onclick='pu(4,8);'>&nbsp</div><div id='r8c4i5' class='p0' onclick='pu(4,8);'>&nbsp</div><div id='r8c4i6' class='p0' onclick='pu(4,8);'>&nbsp</div><div id='r8c4i7' class='p0' onclick='pu(4,8);'>&nbsp</div><div id='r8c4i8' class='p0' onclick='pu(4,8);'>&nbsp</div><div class='dv' id='r8c4'>&nbsp;</div></div>
<div id='tr8c5' class='t0 r2 e1 n1'><div id='r8c5i0' class='p0' onclick='pu(5,8);'>&nbsp</div><div id='r8c5i1' class='p0' onclick='pu(5,8);'>&nbsp</div><div id='r8c5i2' class='p0' onclick='pu(5,8);'>&nbsp</div><div id='r8c5i3' class='p0' onclick='pu(5,8);'>&nbsp</div><div id='r8c5i4' class='p0' onclick='pu(5,8);'>&nbsp</div><div id='r8c5i5' class='p0' onclick='pu(5,8);'>&nbsp</div><div id='r8c5i6' class='p0' onclick='pu(5,8);'>&nbsp</div><div id='r8c5i7' class='p0' onclick='pu(5,8);'>&nbsp</div><div id='r8c5i8' class='p0' onclick='pu(5,8);'>&nbsp</div><div class='dv' id='r8c5'>&nbsp;</div></div>
<div id='tr8c6' class='t0 e1 n1'><div id='r8c6i0' class='p0' onclick='pu(6,8);'>&nbsp</div><div id='r8c6i1' class='p0' onclick='pu(6,8);'>&nbsp</div><div id='r8c6i2' class='p0' onclick='pu(6,8);'>&nbsp</div><div id='r8c6i3' class='p0' onclick='pu(6,8);'>&nbsp</div><div id='r8c6i4' class='p0' onclick='pu(6,8);'>&nbsp</div><div id='r8c6i5' class='p0' onclick='pu(6,8);'>&nbsp</div><div id='r8c6i6' class='p0' onclick='pu(6,8);'>&nbsp</div><div id='r8c6i7' class='p0' onclick='pu(6,8);'>&nbsp</div><div id='r8c6i8' class='p0' onclick='pu(6,8);'>&nbsp</div><div class='dv' id='r8c6'>&nbsp;</div></div>
<div id='tr8c7' class='t0 e1 n1'><div id='r8c7i0' class='p0' onclick='pu(7,8);'>&nbsp</div><div id='r8c7i1' class='p0' onclick='pu(7,8);'>&nbsp</div><div id='r8c7i2' class='p0' onclick='pu(7,8);'>&nbsp</div><div id='r8c7i3' class='p0' onclick='pu(7,8);'>&nbsp</div><div id='r8c7i4' class='p0' onclick='pu(7,8);'>&nbsp</div><div id='r8c7i5' class='p0' onclick='pu(7,8);'>&nbsp</div><div id='r8c7i6' class='p0' onclick='pu(7,8);'>&nbsp</div><div id='r8c7i7' class='p0' onclick='pu(7,8);'>&nbsp</div><div id='r8c7i8' class='p0' onclick='pu(7,8);'>&nbsp</div><div class='dv' id='r8c7'>&nbsp;</div></div>
<div id='tr8c8' class='t0 e1 e2 n1'><div id='r8c8i0' class='p0' onclick='pu(8,8);'>&nbsp</div><div id='r8c8i1' class='p0' onclick='pu(8,8);'>&nbsp</div><div id='r8c8i2' class='p0' onclick='pu(8,8);'>&nbsp</div><div id='r8c8i3' class='p0' onclick='pu(8,8);'>&nbsp</div><div id='r8c8i4' class='p0' onclick='pu(8,8);'>&nbsp</div><div id='r8c8i5' class='p0' onclick='pu(8,8);'>&nbsp</div><div id='r8c8i6' class='p0' onclick='pu(8,8);'>&nbsp</div><div id='r8c8i7' class='p0' onclick='pu(8,8);'>&nbsp</div><div id='r8c8i8' class='p0' onclick='pu(8,8);'>&nbsp</div><div class='dv' id='r8c8'>&nbsp;</div></div>
</div>
<div class='btm'>
<div class='tmr' id='msudoku_timer'>&nbsp;</div>
<div class='tmr' id='msudoku_score_div'>&nbsp;</div>
<div class='tmr' id='msudoku_friend_div'>
<div class="scr"><img src="img/q_silhouette.gif" class="pic"></div>
<div class="scr"><img src="img/q_silhouette.gif" class="pic"></div>
<div class="scr"><img src="img/q_silhouette.gif" class="pic"></div>
<div class="scr"><img src="img/q_silhouette.gif" class="pic"></div>
<div class="scr"><img src="img/q_silhouette.gif" class="pic"></div>
</div>
<div class='tmx' id='msudoku_reset_div'><button onclick="msudoku_reset();" id="msudoku_btn_reset">New Game</button></div>
<div class='tmy' id='msudoku_bookmark_div'><button onclick="FB.Connect.showBookmarkDialog(msudoku_bookmark_callback); return false;" id="msudoku_btn_bookmark">Add Bookmark</button></div>
<!--<div><span id="msudoku_dflA">0</span><span id="msudoku_dflB">0</span><span id="msudoku_dflC">0</span></div>-->
</div>
<!--<br /><input type='text' size=100 id='tst'>-->
<div id="msudoku_results" style="position:absolute; top:0px; left:0px; height:100%; width:741px; display:none; z-index:1000;">
<div id="msudoku_r_text" class="rounded2" style="float:left; background: #CCCCCC; width:500px; height:300px; position:relative; margin-left:120px; margin-top: 155px;">
<div id="msudoku_r_container" class="rounded" style="position:absolute; top:25px; left:25px; width:450px; height:250px; background: #FFFFFF;"></div>
</div></div>
<script type="text/javascript"><!--
google_ad_client = "pub-1135248087036728";
/* Master Sudoku Leaderboard */
google_ad_slot = "2200050702";
google_ad_width = 728;
google_ad_height = 90;
//-->
</script>
<!--script type="text/javascript"
src="<?= $proto ?>://pagead2.googlesyndication.com/pagead/show_ads.js">
</script-->
<div class='pupx' id='puox'>
<div class='punx' onclick='puc(1);'>1</div>
<div class='punx' onclick='puc(2);'>2</div>
<div class='punx' onclick='puc(3);'>3</div>

<div class='punx' onclick='puc(4);'>4</div>
<div class='punx' onclick='puc(5);'>5</div>
<div class='punx' onclick='puc(6);'>6</div>
<div class='punx' onclick='puc(7);'>7</div>
<div class='punx' onclick='puc(8);'>8</div>
<div class='punx' onclick='puc(9);'>9</div>
<div class='putx' onclick='puc("p");'>P/p</div>
<div class='pudx' onclick='puc(0);'>Del</div>
<div class='puex' onclick='puc("e");'>X</div>
</div>
<script src="<?= $proto ?>://connect.facebook.net/en_US/all.js"></script>
</body>
</html>

