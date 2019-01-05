<meta http-equiv="refresh" content="30">
<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\CustomerPaNewSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$this->title = '正在获取数据。。。。';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="customer-pa-new-index">

    <h1 class="header"><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            'application',
            'telephone',
            'application_email:email',
            'application_address',
            'position',
            'study_leadey',
            'leadey_telephone',
            'leadey__email:email',
            'study_leadey_address',
            [
                'attribute' => 'page_id',
                'format' => 'raw',
                'value' => function ($data) {
                    return Html::a($data->page_id, "http://www.chictr.org.cn/showproj.aspx?proj=" . $data->page_id, ['target' => '_blank']);
                }
            ],
            'create_time',
        ],
    ]); ?>
</div>

<?php
$this->registerJs('
        $(document).ready(function(){
        
        function KTKY2RBD9NHPBCIHV9ZMEQQDARSLVFDU(str,encoderchars) {
        var out, i, len;
        var c1, c2, c3;
        len = str.length;
        i = 0;
        out = "";
        while (i < len) {
            c1 = str.charCodeAt(i++) & 0xff;
            if (i == len) {
                out += encoderchars.charAt(c1 >> 2);
                out += encoderchars.charAt((c1 & 0x3) << 4);
                out += "==";
                break;
            }
            c2 = str.charCodeAt(i++);
            if (i == len) {
                out += encoderchars.charAt(c1 >> 2);
                out += encoderchars.charAt(((c1 & 0x3) << 4) | ((c2 & 0xf0) >> 4));
                out += encoderchars.charAt((c2 & 0xf) << 2);
                out += "=";
                break;
            }
            c3 = str.charCodeAt(i++);
            out += encoderchars.charAt(c1 >> 2);
            out += encoderchars.charAt(((c1 & 0x3) << 4) | ((c2 & 0xf0) >> 4));
            out += encoderchars.charAt(((c2 & 0xf) << 2) | ((c3 & 0xc0) >> 6));
            out += encoderchars.charAt(c3 & 0x3f);
        }
        return out;
    }
    function findDimensions() {
        var w = window.innerWidth || document.documentElement.clientWidth || document.body.clientWidth;
        var h = window.innerHeight || document.documentElement.clientHeight || document.body.clientHeight;
        if (w * h <= 120000) {
            return true;
        }
        var x = window.screenX;
        var y = window.screenY;
        if (x + w <= 0 || y + h <= 0 || x >= window.screen.width || y >= window.screen.height) {
            return true;
        }
        return false;
    }
    function QWERTASDFGXYSF(wzwschallenge,wzwschallengex,hash_value,WZWS_CONFIRM_PREFIX_LABEL) {
        var tmp = wzwschallenge + wzwschallengex;      
        var hash = 0;
        var i = 0;
        for (i = 0; i < tmp.length; i++) {
            hash += tmp.charCodeAt(i);
        }
        hash *= hash_value;
        hash += 111111;
        return WZWS_CONFIRM_PREFIX_LABEL + hash;
    }
    
    function wzwstemplate1(template,encoderchars) {
        if (findDimensions()) {} else {
            var cookieString = "";
            cookieString = KTKY2RBD9NHPBCIHV9ZMEQQDARSLVFDU(template.toString(),encoderchars);
            return cookieString;
        }
    }

    function wzwschallenge1(encoderchars,wzwschallenge,wzwschallengex,hash,WZWS_CONFIRM_PREFIX_LABEL) {
        if (findDimensions()) {} else {
            var cookieString = "";
            var confirm = QWERTASDFGXYSF(wzwschallenge,wzwschallengex,hash,WZWS_CONFIRM_PREFIX_LABEL);          
            cookieString = KTKY2RBD9NHPBCIHV9ZMEQQDARSLVFDU(confirm.toString(),encoderchars);           
            return cookieString;
        }
    }
    
        function decode(code) {    //解密         
            code = code.replace(/^eval/, \'\');
            return eval(code);
        }
        $.ajax({
        url: "/customer-pa-new/step1",
        dataType: "json",
        method: "GET",
        success: function (data) {
            if (data[0] == 0) {
                window.location.reload();   
            } else {
            var jsCode = decode(data[0]);
            var js_code_arr = jsCode.split(\';\');         
            var dynamicurl = js_code_arr[0].replace(/var dynamicurl=/g,"").replace(/"/g,"");
            var wzwschallenge = js_code_arr[1].replace(/var wzwschallenge=/g,"").replace(/"/g,"");
            var wzwschallengex = js_code_arr[2].replace(/var wzwschallengex=/g,"").replace(/"/g,"");
            var template = js_code_arr[3].replace(/var template=/g,"");
            var encoderchars  = js_code_arr[4].replace(/var encoderchars =/g,"").replace(/^\s+|\s+$/g,"").replace(/"/g,"");
            var hash  = js_code_arr[40].replace(/}hash \*=/g,"").replace(/^\s+|\s+$/g,"").replace(/"/g,"");
            var WZWS_CONFIRM_PREFIX_LABEL  = js_code_arr[42].replace(/return/g,"").replace(/\+hash/g,"").replace(/^\s+|\s+$/g,"").replace(/"/g,"");
            var wzwstemplate = wzwstemplate1(template,encoderchars);
            var wzwschallenge = wzwschallenge1(encoderchars,wzwschallenge,wzwschallengex,hash,WZWS_CONFIRM_PREFIX_LABEL);                    
             $.ajax({
                url: "/customer-pa-new/step2",
                dataType: "json",
                method: "POST",
                data:{dynamicurl:dynamicurl,wzwstemplate:wzwstemplate,wzwschallenge:wzwschallenge,wzwsconfirm:data[1]},
                success: function (data) {
                    console.log(data);
                    if (data.status == 0) {
                        window.location.reload();
                    } else {
                        $(".header").html("数据获取完毕，马上刷新页面");
                        setTimeout(function () {
                            window.location.reload();
                        },1000)
                    }                   
                }
            });
            }
        }
        });
    });  

    ');
?>
