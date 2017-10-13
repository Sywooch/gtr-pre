<?php

use yii\helpers\Html;
use yii\widgets\Pjax;
use yii\helpers\ArrayHelper;
/* @var $this yii\web\View */
/* @var $searchModel common\models\TTripSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Trip List');
$this->params['breadcrumbs'][] = $this->title;
?>
<?php

$this->registerJs("
$(document).ready(function(){
       // alert('ready');
});
    ");
 ?>
<div class="ttrip-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('', ['create'], ['class' => 'btn btn-danger btn-lg glyphicon glyphicon-plus']) ?>
    </p>

<?php Pjax::begin(['id'=>'pjax-trip']); ?>   
<?php 
/*
kode hari php 
0 minggu
1 senin
2 selasa
3 rabu
4 kamis
5 jumat
6 sabtu
->orderBy(['date'=>SORT_ASC])->all()
*/

$bulan = '10';
$minggu1 =  ArrayHelper::map($model->where('MONTH(date) = :month',[':month'=>$bulan])->andWhere(['number_day'=>0])->andWhere(['number_week'=>1])->orderBy(['dept_time'=>SORT_ASC])->all(),'id','dept_time','date');
$minggu2 =  ArrayHelper::map($model->where('MONTH(date) = :month',[':month'=>$bulan])->andWhere(['number_day'=>0])->andWhere(['number_week'=>2])->orderBy(['dept_time'=>SORT_ASC])->all(),'id','dept_time','date');
$minggu3 =  ArrayHelper::map($model->where('MONTH(date) = :month',[':month'=>$bulan])->andWhere(['number_day'=>0])->andWhere(['number_week'=>3])->orderBy(['dept_time'=>SORT_ASC])->all(),'id','dept_time','date');
$minggu4 =  ArrayHelper::map($model->where('MONTH(date) = :month',[':month'=>$bulan])->andWhere(['number_day'=>0])->andWhere(['number_week'=>4])->orderBy(['dept_time'=>SORT_ASC])->all(),'id','dept_time','date');
$minggu5 =  ArrayHelper::map($model->where('MONTH(date) = :month',[':month'=>$bulan])->andWhere(['number_day'=>0])->andWhere(['number_week'=>5])->orderBy(['dept_time'=>SORT_ASC])->all(),'id','dept_time','date');
$minggu6 =  ArrayHelper::map($model->where('MONTH(date) = :month',[':month'=>$bulan])->andWhere(['number_day'=>0])->andWhere(['number_week'=>6])->orderBy(['dept_time'=>SORT_ASC])->all(),'id','dept_time','date');

$senin1 =  ArrayHelper::map($model->where('MONTH(date) = :month',[':month'=>$bulan])->andWhere(['number_day'=>1])->andWhere(['number_week'=>1])->orderBy(['dept_time'=>SORT_ASC])->all(),'id','dept_time','date');
$senin2 =  ArrayHelper::map($model->where('MONTH(date) = :month',[':month'=>$bulan])->andWhere(['number_day'=>1])->andWhere(['number_week'=>2])->orderBy(['dept_time'=>SORT_ASC])->all(),'id','dept_time','date');
$senin3 =  ArrayHelper::map($model->where('MONTH(date) = :month',[':month'=>$bulan])->andWhere(['number_day'=>1])->andWhere(['number_week'=>3])->orderBy(['dept_time'=>SORT_ASC])->all(),'id','dept_time','date');
$senin4 =  ArrayHelper::map($model->where('MONTH(date) = :month',[':month'=>$bulan])->andWhere(['number_day'=>1])->andWhere(['number_week'=>4])->orderBy(['dept_time'=>SORT_ASC])->all(),'id','dept_time','date');
$senin5 =  ArrayHelper::map($model->where('MONTH(date) = :month',[':month'=>$bulan])->andWhere(['number_day'=>1])->andWhere(['number_week'=>5])->orderBy(['dept_time'=>SORT_ASC])->all(),'id','dept_time','date');
$senin6 =  ArrayHelper::map($model->where('MONTH(date) = :month',[':month'=>$bulan])->andWhere(['number_day'=>1])->andWhere(['number_week'=>6])->orderBy(['dept_time'=>SORT_ASC])->all(),'id','dept_time','date');

$selasa1 =  ArrayHelper::map($model->where('MONTH(date) = :month',[':month'=>$bulan])->andWhere(['number_day'=>2])->andWhere(['number_week'=>1])->orderBy(['dept_time'=>SORT_ASC])->all(),'id','dept_time','date');
$selasa2 =  ArrayHelper::map($model->where('MONTH(date) = :month',[':month'=>$bulan])->andWhere(['number_day'=>2])->andWhere(['number_week'=>2])->orderBy(['dept_time'=>SORT_ASC])->all(),'id','dept_time','date');
$selasa3 =  ArrayHelper::map($model->where('MONTH(date) = :month',[':month'=>$bulan])->andWhere(['number_day'=>2])->andWhere(['number_week'=>3])->orderBy(['dept_time'=>SORT_ASC])->all(),'id','dept_time','date');
$selasa4 =  ArrayHelper::map($model->where('MONTH(date) = :month',[':month'=>$bulan])->andWhere(['number_day'=>2])->andWhere(['number_week'=>4])->orderBy(['dept_time'=>SORT_ASC])->all(),'id','dept_time','date');
$selasa5 =  ArrayHelper::map($model->where('MONTH(date) = :month',[':month'=>$bulan])->andWhere(['number_day'=>2])->andWhere(['number_week'=>5])->orderBy(['dept_time'=>SORT_ASC])->all(),'id','dept_time','date');
$selasa6 =  ArrayHelper::map($model->where('MONTH(date) = :month',[':month'=>$bulan])->andWhere(['number_day'=>2])->andWhere(['number_week'=>6])->orderBy(['dept_time'=>SORT_ASC])->all(),'id','dept_time','date');

$rabu1 =  ArrayHelper::map($model->where('MONTH(date) = :month',[':month'=>$bulan])->andWhere(['number_day'=>3])->andWhere(['number_week'=>1])->orderBy(['dept_time'=>SORT_ASC])->all(),'id','dept_time','date');
$rabu2 =  ArrayHelper::map($model->where('MONTH(date) = :month',[':month'=>$bulan])->andWhere(['number_day'=>3])->andWhere(['number_week'=>2])->orderBy(['dept_time'=>SORT_ASC])->all(),'id','dept_time','date');
$rabu3 =  ArrayHelper::map($model->where('MONTH(date) = :month',[':month'=>$bulan])->andWhere(['number_day'=>3])->andWhere(['number_week'=>3])->orderBy(['dept_time'=>SORT_ASC])->all(),'id','dept_time','date');
$rabu4 =  ArrayHelper::map($model->where('MONTH(date) = :month',[':month'=>$bulan])->andWhere(['number_day'=>3])->andWhere(['number_week'=>4])->orderBy(['dept_time'=>SORT_ASC])->all(),'id','dept_time','date');
$rabu5 =  ArrayHelper::map($model->where('MONTH(date) = :month',[':month'=>$bulan])->andWhere(['number_day'=>3])->andWhere(['number_week'=>5])->orderBy(['dept_time'=>SORT_ASC])->all(),'id','dept_time','date');
$rabu6 =  ArrayHelper::map($model->where('MONTH(date) = :month',[':month'=>$bulan])->andWhere(['number_day'=>3])->andWhere(['number_week'=>6])->orderBy(['dept_time'=>SORT_ASC])->all(),'id','dept_time','date');

$kamis1 =  ArrayHelper::map($model->where('MONTH(date) = :month',[':month'=>$bulan])->andWhere(['number_day'=>4])->andWhere(['number_week'=>1])->orderBy(['dept_time'=>SORT_ASC])->all(),'id','dept_time','date');
$kamis2 =  ArrayHelper::map($model->where('MONTH(date) = :month',[':month'=>$bulan])->andWhere(['number_day'=>4])->andWhere(['number_week'=>2])->orderBy(['dept_time'=>SORT_ASC])->all(),'id','dept_time','date');
$kamis3 =  ArrayHelper::map($model->where('MONTH(date) = :month',[':month'=>$bulan])->andWhere(['number_day'=>4])->andWhere(['number_week'=>3])->orderBy(['dept_time'=>SORT_ASC])->all(),'id','dept_time','date');
$kamis4 =  ArrayHelper::map($model->where('MONTH(date) = :month',[':month'=>$bulan])->andWhere(['number_day'=>4])->andWhere(['number_week'=>4])->orderBy(['dept_time'=>SORT_ASC])->all(),'id','dept_time','date');
$kamis5 =  ArrayHelper::map($model->where('MONTH(date) = :month',[':month'=>$bulan])->andWhere(['number_day'=>4])->andWhere(['number_week'=>5])->orderBy(['dept_time'=>SORT_ASC])->all(),'id','dept_time','date');
$kamis6 =  ArrayHelper::map($model->where('MONTH(date) = :month',[':month'=>$bulan])->andWhere(['number_day'=>4])->andWhere(['number_week'=>6])->orderBy(['dept_time'=>SORT_ASC])->all(),'id','dept_time','date');

$jumat1 =  ArrayHelper::map($model->where('MONTH(date) = :month',[':month'=>$bulan])->andWhere(['number_day'=>5])->andWhere(['number_week'=>1])->orderBy(['dept_time'=>SORT_ASC])->all(),'id','dept_time','date');
$jumat2 =  ArrayHelper::map($model->where('MONTH(date) = :month',[':month'=>$bulan])->andWhere(['number_day'=>5])->andWhere(['number_week'=>2])->orderBy(['dept_time'=>SORT_ASC])->all(),'id','dept_time','date');
$jumat3 =  ArrayHelper::map($model->where('MONTH(date) = :month',[':month'=>$bulan])->andWhere(['number_day'=>5])->andWhere(['number_week'=>3])->orderBy(['dept_time'=>SORT_ASC])->all(),'id','dept_time','date');
$jumat4 =  ArrayHelper::map($model->where('MONTH(date) = :month',[':month'=>$bulan])->andWhere(['number_day'=>5])->andWhere(['number_week'=>4])->orderBy(['dept_time'=>SORT_ASC])->all(),'id','dept_time','date');
$jumat5 =  ArrayHelper::map($model->where('MONTH(date) = :month',[':month'=>$bulan])->andWhere(['number_day'=>5])->andWhere(['number_week'=>5])->orderBy(['dept_time'=>SORT_ASC])->all(),'id','dept_time','date');
$jumat6 =  ArrayHelper::map($model->where('MONTH(date) = :month',[':month'=>$bulan])->andWhere(['number_day'=>5])->andWhere(['number_week'=>6])->orderBy(['dept_time'=>SORT_ASC])->all(),'id','dept_time','date');

$sabtu1 =  ArrayHelper::map($model->where('MONTH(date) = :month',[':month'=>$bulan])->andWhere(['number_day'=>6])->andWhere(['number_week'=>1])->orderBy(['dept_time'=>SORT_ASC])->all(),'id','dept_time','date');
$sabtu2 =  ArrayHelper::map($model->where('MONTH(date) = :month',[':month'=>$bulan])->andWhere(['number_day'=>6])->andWhere(['number_week'=>2])->orderBy(['dept_time'=>SORT_ASC])->all(),'id','dept_time','date');
$sabtu3 =  ArrayHelper::map($model->where('MONTH(date) = :month',[':month'=>$bulan])->andWhere(['number_day'=>6])->andWhere(['number_week'=>3])->orderBy(['dept_time'=>SORT_ASC])->all(),'id','dept_time','date');
$sabtu4 =  ArrayHelper::map($model->where('MONTH(date) = :month',[':month'=>$bulan])->andWhere(['number_day'=>6])->andWhere(['number_week'=>4])->orderBy(['dept_time'=>SORT_ASC])->all(),'id','dept_time','date');
$sabtu5 =  ArrayHelper::map($model->where('MONTH(date) = :month',[':month'=>$bulan])->andWhere(['number_day'=>6])->andWhere(['number_week'=>5])->orderBy(['dept_time'=>SORT_ASC])->all(),'id','dept_time','date');
$sabtu6 =  ArrayHelper::map($model->where('MONTH(date) = :month',[':month'=>$bulan])->andWhere(['number_day'=>6])->andWhere(['number_week'=>6])->orderBy(['dept_time'=>SORT_ASC])->all(),'id','dept_time','date');
//$senin1 = ArrayHelper::map($senin->andWhere(FLOOR((DAYOFMONTH(date) - 1) / 7) + 1 = :sn1,[':sn1'=>1])->orderBy(['dept_time'=>SORT_ASC])->all(), 'id','dept_time','date');
/*$selasa = ArrayHelper::map( $model->where('date_format(date,"%w") = :date',[':date'=>2])->orderBy(['date'=>SORT_ASC])->all(), 'id','dept_time','date');
$rabu = ArrayHelper::map( $model->where('date_format(date,"%w") = :date',[':date'=>3])->orderBy(['date'=>SORT_ASC])->all(), 'id','dept_time','date');
$kamis = ArrayHelper::map( $model->where('date_format(date,"%w") = :date',[':date'=>4])->orderBy(['date'=>SORT_ASC])->all(), 'id','dept_time','date');
$jumat = ArrayHelper::map( $model->where('date_format(date,"%w") = :date',[':date'=>5])->orderBy(['date'=>SORT_ASC])->all(), 'id','dept_time','date');
$sabtu = ArrayHelper::map( $model->where('date_format(date,"%w") = :date',[':date'=>6])->orderBy(['date'=>SORT_ASC])->all(), 'id','dept_time','date');
$minggu = ArrayHelper::map( $model->where('date_format(date,"%w") = :date',[':date'=>0])->orderBy(['date'=>SORT_ASC])->all(), 'id','dept_time','date');
*/
//var_dump($senin);

//$month= date ("11");
$year=date("Y");
$day=date("d");
$firstday = date ("d", mktime (0,0,0,$bulan,01,$year));



?>
<div class="table-responsive">
<table class="table table-striped">
  <thead>
    <tr class="info">
       <th>Minggu</th>
       <th>Senin</th>
       <th>Selasa</th>
       <th>Rabu</th>
       <th>Kamis</th>
       <th>Jumat</th>
       <th>Sabtu</th>
       
    </tr>
  </thead>
  <tbody>
   <tr>
      <?php
      /*$ming1 =  key($minggu1);

      if(date('d',strtotime($ming1)) == $firstday):*/
        ?>
        <td>
          <?php 

            foreach ($minggu1 as $key => $value) {
              echo "<strong>".date('d',strtotime($key))."</strong><br>";
              foreach ($value as $x => $val) {
                echo " <a href='update?id=".$x."' style='text-color: red;'>".date('H:i',strtotime($val))."</a></br>";
              }
            }
          ?>
        </td>
      <?php //else: ?>
<!--<td><strong>Bukan</strong></td>-->
      <?php //endif;?>
    
        
        <td> 
          <?php 
            foreach ($senin1 as $key => $value) {
              echo "<strong>".date('d',strtotime($key))."</strong><br>";
              foreach ($value as $x => $val) {
                echo " <a href='update?id=".$x."' style='text-color: red;'>".date('H:i',strtotime($val))."</a></br>";
              }
            }
          ?>
        </td>
        <td> 
          <?php 
            foreach ($selasa1 as $key => $value) {
              echo "<strong>".date('d',strtotime($key))."</strong><br>";
              foreach ($value as $x => $val) {
                echo " <a href='update?id=".$x."' style='text-color: red;'>".date('H:i',strtotime($val))."</a></br>";
              }
            }
          ?>
        </td>
        <td> 
          <?php 
            foreach ($rabu1 as $key => $value) {
              echo "<strong>".date('d',strtotime($key))."</strong><br>";
              foreach ($value as $x => $val) {
                echo " <a href='update?id=".$x."' style='text-color: red;'>".date('H:i',strtotime($val))."</a></br>";
              }
            }
          ?>
        </td>
        <td> 
          <?php 
            foreach ($kamis1 as $key => $value) {
              echo "<strong>".date('d',strtotime($key))."</strong><br>";
              foreach ($value as $x => $val) {
                echo " <a href='update?id=".$x."' style='text-color: red;'>".date('H:i',strtotime($val))."</a></br>";
              }
            }
          ?>
        </td>
        <td> 
          <?php 
            foreach ($jumat1 as $key => $value) {
              echo "<strong>".date('d',strtotime($key))."</strong><br>";
              foreach ($value as $x => $val) {
                echo " <a href='update?id=".$x."' style='text-color: red;'>".date('H:i',strtotime($val))."</a></br>";
              }
            }
          ?>
        </td>
        <td> 
          <?php 
            foreach ($sabtu1 as $key => $value) {
              echo "<strong>".date('d',strtotime($key))."</strong><br>";
              foreach ($value as $x => $val) {
                echo " <a href='update?id=".$x."' style='text-color: red;'>".date('H:i',strtotime($val))."</a></br>";
              }
            }
          ?>
        </td>
        

    </tr>
    <!-- minggu ke 2 -->
    <tr>
        <td> 
          <?php 
            foreach ($minggu2 as $key => $value) {
              echo "<strong>".date('d',strtotime($key))."</strong><br>";
              foreach ($value as $x => $val) {
                echo " <a href='update?id=".$x."' style='text-color: red;'>".date('H:i',strtotime($val))."</a></br>";
              }
            }
          ?>
        </td>
        <td> <?php 
        foreach ($senin2 as $key => $value) {
          echo "<strong>".date('d',strtotime($key))."</strong><br>";
          foreach ($value as $x => $val) {
            echo " <a href='update?id=".$x."' style='text-color: red;'>".date('H:i',strtotime($val))."</a></br>";
          }
           
        
            }
        ?></td>
        <td> 
          <?php 
            foreach ($selasa2 as $key => $value) {
              echo "<strong>".date('d',strtotime($key))."</strong><br>";
              foreach ($value as $x => $val) {
                echo " <a href='update?id=".$x."' style='text-color: red;'>".date('H:i',strtotime($val))."</a></br>";
              }
            }
          ?>
        </td>
        <td> 
          <?php 
            foreach ($rabu2 as $key => $value) {
              echo "<strong>".date('d',strtotime($key))."</strong><br>";
              foreach ($value as $x => $val) {
                echo " <a href='update?id=".$x."' style='text-color: red;'>".date('H:i',strtotime($val))."</a></br>";
              }
            }
          ?>
        </td>
        <td> 
          <?php 
            foreach ($kamis2 as $key => $value) {
              echo "<strong>".date('d',strtotime($key))."</strong><br>";
              foreach ($value as $x => $val) {
                echo " <a href='update?id=".$x."' style='text-color: red;'>".date('H:i',strtotime($val))."</a></br>";
              }
            }
          ?>
        </td>
        <td> 
          <?php 
            foreach ($jumat2 as $key => $value) {
              echo "<strong>".date('d',strtotime($key))."</strong><br>";
              foreach ($value as $x => $val) {
                echo " <a href='update?id=".$x."' style='text-color: red;'>".date('H:i',strtotime($val))."</a></br>";
              }
            }
          ?>
        </td>
        <td> 
          <?php 
            foreach ($sabtu2 as $key => $value) {
              echo "<strong>".date('d',strtotime($key))."</strong><br>";
              foreach ($value as $x => $val) {
                echo " <a href='update?id=".$x."' style='text-color: red;'>".date('H:i',strtotime($val))."</a></br>";
              }
            }
          ?>
        </td>
        
    </tr>
    <!-- Minggu ke 3 -->
    <tr>
        <td> 
          <?php 
            foreach ($minggu3 as $key => $value) {
              echo "<strong>".date('d',strtotime($key))."</strong><br>";
              foreach ($value as $x => $val) {
                echo " <a href='update?id=".$x."' style='text-color: red;'>".date('H:i',strtotime($val))."</a></br>";
              }
            }
          ?>
        </td>
        <td> <?php 
        foreach ($senin3 as $key => $value) {
          echo "<strong>".date('d',strtotime($key))."</strong><br>";
          foreach ($value as $x => $val) {
            echo " <a href='update?id=".$x."' style='text-color: red;'>".date('H:i',strtotime($val))."</a></br>";
          }
           
        
            }
        ?></td>
        <td> 
          <?php 
            foreach ($selasa3 as $key => $value) {
              echo "<strong>".date('d',strtotime($key))."</strong><br>";
              foreach ($value as $x => $val) {
                echo " <a href='update?id=".$x."' style='text-color: red;'>".date('H:i',strtotime($val))."</a></br>";
              }
            }
          ?>
        </td>
        <td> 
          <?php 
            foreach ($rabu3 as $key => $value) {
              echo "<strong>".date('d',strtotime($key))."</strong><br>";
              foreach ($value as $x => $val) {
                echo " <a href='update?id=".$x."' style='text-color: red;'>".date('H:i',strtotime($val))."</a></br>";
              }
            }
          ?>
        </td>
        <td> 
          <?php 
            foreach ($kamis3 as $key => $value) {
              echo "<strong>".date('d',strtotime($key))."</strong><br>";
              foreach ($value as $x => $val) {
                echo " <a href='update?id=".$x."' style='text-color: red;'>".date('H:i',strtotime($val))."</a></br>";
              }
            }
          ?>
        </td>
        <td> 
          <?php 
            foreach ($jumat3 as $key => $value) {
              echo "<strong>".date('d',strtotime($key))."</strong><br>";
              foreach ($value as $x => $val) {
                echo " <a href='update?id=".$x."' style='text-color: red;'>".date('H:i',strtotime($val))."</a></br>";
              }
            }
          ?>
        </td>
        <td> 
          <?php 
            foreach ($sabtu3 as $key => $value) {
              echo "<strong>".date('d',strtotime($key))."</strong><br>";
              foreach ($value as $x => $val) {
                echo " <a href='update?id=".$x."' style='text-color: red;'>".date('H:i',strtotime($val))."</a></br>";
              }
            }
          ?>
        </td>
        
    </tr> 

    <!--  Minggu 4 -->
    <tr>
        <td> 
          <?php 
            foreach ($minggu4 as $key => $value) {
              echo "<strong>".date('d',strtotime($key))."</strong><br>";
              foreach ($value as $x => $val) {
                echo " <a href='update?id=".$x."' style='text-color: red;'>".date('H:i',strtotime($val))."</a></br>";
              }
            }
          ?>
        </td>
        <td> <?php 
        foreach ($senin4 as $key => $value) {
          echo "<strong>".date('d',strtotime($key))."</strong><br>";
          foreach ($value as $x => $val) {
            echo " <a href='update?id=".$x."' style='text-color: red;'>".date('H:i',strtotime($val))."</a></br>";
          }
           
        
            }
        ?></td>
        <td> 
          <?php 
            foreach ($selasa4 as $key => $value) {
              echo "<strong>".date('d',strtotime($key))."</strong><br>";
              foreach ($value as $x => $val) {
                echo " <a href='update?id=".$x."' style='text-color: red;'>".date('H:i',strtotime($val))."</a></br>";
              }
            }
          ?>
        </td>
        <td> 
          <?php 
            foreach ($rabu4 as $key => $value) {
              echo "<strong>".date('d',strtotime($key))."</strong><br>";
              foreach ($value as $x => $val) {
                echo " <a href='update?id=".$x."' style='text-color: red;'>".date('H:i',strtotime($val))."</a></br>";
              }
            }
          ?>
        </td>
        <td> 
          <?php 
            foreach ($kamis4 as $key => $value) {
              echo "<strong>".date('d',strtotime($key))."</strong><br>";
              foreach ($value as $x => $val) {
                echo " <a href='update?id=".$x."' style='text-color: red;'>".date('H:i',strtotime($val))."</a></br>";
              }
            }
          ?>
        </td>
        <td> 
          <?php 
            foreach ($jumat4 as $key => $value) {
              echo "<strong>".date('d',strtotime($key))."</strong><br>";
              foreach ($value as $x => $val) {
                echo " <a href='update?id=".$x."' style='text-color: red;'>".date('H:i',strtotime($val))."</a></br>";
              }
            }
          ?>
        </td>
        <td> 
          <?php 
            foreach ($sabtu4 as $key => $value) {
              echo "<strong>".date('d',strtotime($key))."</strong><br>";
              foreach ($value as $x => $val) {
                echo " <a href='update?id=".$x."' style='text-color: red;'>".date('H:i',strtotime($val))."</a></br>";
              }
            }
          ?>
        </td>
        
    </tr>

    <!-- Minggu 5 -->
    <tr>
        <td> 
          <?php 
            foreach ($minggu5 as $key => $value) {
              echo "<strong>".date('d',strtotime($key))."</strong><br>";
              foreach ($value as $x => $val) {
                echo " <a href='update?id=".$x."' style='text-color: red;'>".date('H:i',strtotime($val))."</a></br>";
              }
            }
          ?>
        </td>
        <td> <?php 
        foreach ($senin5 as $key => $value) {
          echo "<strong>".date('d',strtotime($key))."</strong><br>";
          foreach ($value as $x => $val) {
            echo " <a href='update?id=".$x."' style='text-color: red;'>".date('H:i',strtotime($val))."</a></br>";
          }
           
        
            }
        ?></td>
        <td> 
          <?php 
            foreach ($selasa5 as $key => $value) {
              echo "<strong>".date('d',strtotime($key))."</strong><br>";
              foreach ($value as $x => $val) {
                echo " <a href='update?id=".$x."' style='text-color: red;'>".date('H:i',strtotime($val))."</a></br>";
              }
            }
          ?>
        </td>
        <td> 
          <?php 
            foreach ($rabu5 as $key => $value) {
              echo "<strong>".date('d',strtotime($key))."</strong><br>";
              foreach ($value as $x => $val) {
                echo " <a href='update?id=".$x."' style='text-color: red;'>".date('H:i',strtotime($val))."</a></br>";
              }
            }
          ?>
        </td>
        <td> 
          <?php 
            foreach ($kamis5 as $key => $value) {
              echo "<strong>".date('d',strtotime($key))."</strong><br>";
              foreach ($value as $x => $val) {
                echo " <a href='update?id=".$x."' style='text-color: red;'>".date('H:i',strtotime($val))."</a></br>";
              }
            }
          ?>
        </td>
        <td> 
          <?php 
            foreach ($jumat5 as $key => $value) {
              echo "<strong>".date('d',strtotime($key))."</strong><br>";
              foreach ($value as $x => $val) {
                echo " <a href='update?id=".$x."' style='text-color: red;'>".date('H:i',strtotime($val))."</a></br>";
              }
            }
          ?>
        </td>
        <td> 
          <?php 
            foreach ($sabtu5 as $key => $value) {
              echo "<strong>".date('d',strtotime($key))."</strong><br>";
              foreach ($value as $x => $val) {
                echo " <a href='update?id=".$x."' style='text-color: red;'>".date('H:i',strtotime($val))."</a></br>";
              }
            }
          ?>
        </td>
        
    </tr>

    <!-- Minggu 6 -->
    <tr>
        <td> 
          <?php 
            foreach ($minggu6 as $key => $value) {
              echo "<strong>".date('d',strtotime($key))."</strong><br>";
              foreach ($value as $x => $val) {
                echo " <a href='update?id=".$x."' style='text-color: red;'>".date('H:i',strtotime($val))."</a></br>";
              }
            }
          ?>
        </td>
        <td> <?php 
        foreach ($senin6 as $key => $value) {
          echo "<strong>".date('d',strtotime($key))."</strong><br>";
          foreach ($value as $x => $val) {
            echo " <a href='update?id=".$x."' style='text-color: red;'>".date('H:i',strtotime($val))."</a></br>";
          }
           
        
            }
        ?></td>
        <td> 
          <?php 
            foreach ($selasa6 as $key => $value) {
              echo "<strong>".date('d',strtotime($key))."</strong><br>";
              foreach ($value as $x => $val) {
                echo " <a href='update?id=".$x."' style='text-color: red;'>".date('H:i',strtotime($val))."</a></br>";
              }
            }
          ?>
        </td>
        <td> 
          <?php 
            foreach ($rabu6 as $key => $value) {
              echo "<strong>".date('d',strtotime($key))."</strong><br>";
              foreach ($value as $x => $val) {
                echo " <a href='update?id=".$x."' style='text-color: red;'>".date('H:i',strtotime($val))."</a></br>";
              }
            }
          ?>
        </td>
        <td> 
          <?php 
            foreach ($kamis6 as $key => $value) {
              echo "<strong>".date('d',strtotime($key))."</strong><br>";
              foreach ($value as $x => $val) {
                echo " <a href='update?id=".$x."' style='text-color: red;'>".date('H:i',strtotime($val))."</a></br>";
              }
            }
          ?>
        </td>
        <td> 
          <?php 
            foreach ($jumat6 as $key => $value) {
              echo "<strong>".date('d',strtotime($key))."</strong><br>";
              foreach ($value as $x => $val) {
                echo " <a href='update?id=".$x."' style='text-color: red;'>".date('H:i',strtotime($val))."</a></br>";
              }
            }
          ?>
        </td>
        <td> 
          <?php 
            foreach ($sabtu6 as $key => $value) {
              echo "<strong>".date('d',strtotime($key))."</strong><br>";
              foreach ($value as $x => $val) {
                echo " <a href='update?id=".$x."' style='text-color: red;'>".date('H:i',strtotime($val))."</a></br>";
              }
            }
          ?>
        </td>
        
    </tr>  
  </tbody> </table>
</div>

<?php 

$month= "10";
$year=date("Y");
$day=date("d");
// t digunakan untuk menghitung jumlah seluruh hari pada bulan ini
//ini digunakan untuk menampilkan semua tanggal pada bulan ini
$endDate=date("t",mktime(0,0,0,$month,$day,$year));


//membuat tabel kalender
//echo '<font face="arial" size="5">';
//echo '<table align="center" border="0" cellpadding=5 cellspacing=5 style=""><tr><td align=center>';
//menampilkan hari ini
//echo "Hari ini tanggal : ".date("d F Y ",mktime(0,0,0,$month,$day,$year));
//echo '</td></tr></table>';
//membuat tebel baris nama-nama hari
echo '<table align="center" class="table table-striped">
<thead>
  <tr class="info">
  <td align=center><font color=red>Minggu</font></td>
  <td align=center>Senin</td>
  <td align=center>Selasa</td>
  <td align=center>Rabu</td>
  <td align=center>Kamis</td>
  <td align=center>Jumat</td>
  <td align=center>Sabtu</td>
  </tr>
</thead>
  <tbody>';
//cek tanggal 1 hari sekarang
$s=date ("w", mktime (0,0,0,$month,1,$year));
for ($ds=1;$ds<=$s;$ds++) {
echo "<td style=\"font-family:arial;color:#B3D9FF\" align=center valign=middle bgcolor=\"#FFFFFF\">
</td>";
}
for ($d=1;$d<=$endDate;$d++) {
    //jika variabel w= 0 disini 0 adalah hari minggu akan membuat baris baru dengan </tr>
    if (date("w",mktime (0,0,0,$month,$d,$year)) == 0) {

        echo "<tr>"; 
    }
   // $fontColor="#000000";
    //menentukan warna pada tanggal hari biasa
    if (date("d",mktime (0,0,0,$month,$d,$year)) == "Sun") {  }
      $today = date("Y-m-d",mktime (0,0,0,$month,$d,$year));
      $trips = $model2->where(['date'=>$today])->all();

    echo "<td style=\"font-family:arial;color:#333333\" align=center valign=middle> <span><strong>".date("d",mktime (0,0,0,$month,$d,$year))."</strong><br>";
    if (!empty($trips)) {
        foreach ($trips as $key => $value) {
        echo $value->dept_time."<br>";
      }
    }else{
      echo "Not Trip TOday";
    }
    
    echo "</span></td>";

    //jika variabel w= 6 disini 6 adalah hari sabtu maka akan pindah baris dengan menutup baris </tr>
    if (date("w",mktime (0,0,0,$month,$d,$year)) == 6) { echo "</tr>"; }
}
echo '</table></tbody>';


$date = '2017-09-14';
$dayofweek = date('w', strtotime($date));
$result    = date('Y-m-d', strtotime(($day - $dayofweek).' day', strtotime($date)));

echo $dayofweek."<br>".$result;
?>
<?php Pjax::end(); ?></div>

    <style type="text/css">
   .table {
    display: table;
    text-align: justify;
    width: 100%;
    
    border-collapse: separate;
    font-family: 'Roboto', sans-serif;
    font-weight: 400;
    font-size: 15px;
  }
  
  .table_row {
    display: table-row;
  }
  
  .theader {
    display: table-row;

  }
  
  .table_header {
    display: table-cell;
    border-bottom: #ccc 1px solid;
    border-top: #ccc 1px solid;
    background: #bdbdbd;
    color: #e5e5e5;
    padding-top: 10px;
    padding-bottom: 10px;
    font-weight: 700;
    
  }
  
  .table_header:first-child {
    border-left: #ccc 1px solid;
    border-top-left-radius: 5px;
  }
  
  .table_header:last-child {
    border-right: #ccc 1px solid;
    border-top-right-radius: 5px;
  }
  
  .table_small {
    display: table-cell;
  }
  
  .table_row > .table_small > .table_cell:nth-child(odd) {
    display: none;
    background: #bdbdbd;
    color: #e5e5e5;
   padding-top: 0px;
    padding-bottom: 0px;
  }
  
  .table_row > .table_small > .table_cell {
    padding-top: 3px;
    padding-bottom: 3px;
    color: #5b5b5b;
    border-bottom: #ccc 1px solid;
  }
  
  .table_row > .table_small:first-child > .table_cell {
    border-left: #ccc 1px solid;
  }
  
  .table_row > .table_small:last-child > .table_cell {
    border-right: #ccc 1px solid;
  }
  
  .table_row:last-child > .table_small:last-child > .table_cell:last-child {
    border-bottom-right-radius: 5px;
  }
  
  .table_row:last-child > .table_small:first-child > .table_cell:last-child {
    border-bottom-left-radius: 5px;
  }
  
  .table_row:nth-child(2n+3) {
    background: #e9e9e9;
  }
  
  @media screen and (max-width: 900px) {
    .table {
      width: 100%
    }
  }
  
  @media screen and (max-width: 650px) {
    .table {
      display: block;
    }
    .table_row:nth-child(2n+3) {
      background: none;
    }
    .theader {
      display: none;
    }
    .table_row > .table_small > .table_cell:nth-child(odd) {
      display: table-cell;
      width: 50%;
    }
    .table_cell {
      display: table-cell;
      width: 50%;
    }
    .table_row {
      display: table;
      width: 100%;
      border-collapse: separate;
      padding-bottom: 20px;
      margin: 5% auto 0;
      text-align: left;
      vertical-align: middle;
    }
    .table_small {
      display: table-row;
    }
    .table_row > .table_small:first-child > .table_cell:last-child {
      border-left: none;
    }
    .table_row > .table_small > .table_cell:first-child {
      border-left: #ccc 1px solid;
    }
    .table_row > .table_small:first-child > .table_cell:first-child {
      border-top-left-radius: 5px;
      border-top: #ccc 1px solid;
    }
    .table_row > .table_small:first-child > .table_cell:last-child {
      border-top-right-radius: 5px;
      border-top: #ccc 1px solid;
    }
    .table_row > .table_small:last-child > .table_cell:first-child {
      border-right: none;
    }
    .table_row > .table_small > .table_cell:last-child {
      border-right: #ccc 1px solid;
    }
    .table_row > .table_small:last-child > .table_cell:first-child {
      border-bottom-left-radius: 5px;
    }
    .table_row > .table_small:last-child > .table_cell:last-child {
      border-bottom-right-radius: 5px;
    }
  }
</style>