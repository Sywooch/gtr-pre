<?php
namespace console\controllers;


use yii\console\Controller;
use Yii;
use yii\helpers\FileHelper;
use common\models\TKurs;
Class KursController extends Controller
{
    public function actionKurs(){
               $modelKurs = TKurs::find()->all();
        $now = date('Y-m-d H:i:s');

      //  $update_at = date($modelKurs[0]->update_at);
      //  $expKurs = strtotime ( '+30 minute' , strtotime ( $update_at ) ) ;
        //$expKurs = date ('Y-m-d H:i:s' , $expKurs );
        //$update_at = strtotime('+1 minute',);

       // if ( $expKurs < $now) {
           
    foreach ($modelKurs as $value) {
                 $get              = file_get_contents("https://finance.google.com/finance/converter?a=1&from=".$value->currency."&to=IDR");
                 $get              = explode("<span class=bld>",$get);
                 $get              = explode("</span>",$get[1]);  
                 $kurs_asli        = preg_replace("/[^0-9\.]/", null, $get[0]);  
                 $kurs_round       = round($kurs_asli,0,PHP_ROUND_HALF_UP); // 0.4 ke bawah ... 0.5 ke atas 
                 $kurs_plus        = $kurs_round-round($kurs_round*5/100,0,PHP_ROUND_HALF_UP); //ditambah 5%
                 $value->kurs      = $kurs_plus;
                 $value->update_at = $now;
                 $value->save();
    }
            
            
        //}
    }
}