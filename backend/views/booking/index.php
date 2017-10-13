<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use common\models\TPassenger;
use yii\helpers\Url;
use mdm\admin\components\Helper;
/* @var $this yii\web\View */
/* @var $searchModel app\models\TBookingSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Booking Data';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tbooking-index">
<div class="col-md-12">
    <?php  echo $this->render('_search', [
                'model' => $searchModel,
                'bookingList' => $bookingList,
                'listDept' => $listDept,

                ]); ?>
    

</div>
<div class="col-md-12">
<?php Pjax::begin(); ?>
<?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel'  => $searchModel,
        'panel'=>['type'=>'primary', 'heading'=>'Booking Data'],
        'striped'      =>true,
        'bordered'  => true,
        'hover'        =>true,
        'pjax'         =>true,
        'pjaxSettings' =>[
            'neverTimeout' =>true,
        ],
        'columns' => [
            ['class' => 'kartik\grid\SerialColumn'],
            [
                'attribute'=>'id_payment',
                'width'=>'auto',
                'value'=>function ($model, $key, $index, $widget) { 
                     if(Helper::checkRoute('/*')){
                        return "Customer <b>".$model->idPayment->name." - ".$model->idPayment->email." - ".$model->idPayment->phone."<b> <span class='label material-label material-label_xs material-label_success main-container__column'>".$model->idStatus->status."</span>";
                     }else{
                        return "Customer <b>".$model->idPayment->name." - ".$model->idPayment->email." - ".$model->idPayment->phone."";
                     }
                
                },
                'format'=>'raw',
                'group'             =>true,  // enable grouping,
                'groupedRow'        =>true,                    // move grouped column to a single grouped row
                'groupOddCssClass'  =>'kv-grouped-row',  // configure odd group cell css class
                'groupEvenCssClass' =>'kv-grouped-row', // configure even group cell css class
                'groupFooter'       =>function ($model, $key, $index, $widget) { // Closure method
                    return [
                        'mergeColumns'=>[[0,2]], // columns to merge in summary
                        'content'=>[             // content to show in each summary cell
                           // 0=> $model->idPayment->name." - ".$model->idPayment->phone,
                           // 4=>GridView::F_AVG,
                           // 5=>GridView::F_SUM,
                           // 6=>GridView::F_SUM,
                        ],
                        'contentFormats'=>[      // content reformatting for each summary cell
                          //  4=>['format'=>'number', 'decimals'=>2],
                           // 5=>['format'=>'number', 'decimals'=>0],
                           // 6=>['format'=>'number', 'decimals'=>2],
                        ],
                        'contentOptions'=>[      // content html attributes for each summary cell
                           // 0=>['style'=>'font-variant:small-caps'],
                           // 4=>['style'=>'text-align:right'],
                            //5=>['style'=>'text-align:right'],
                            //6=>['style'=>'text-align:right'],
                        ],
                        // html attributes for group summary row
                        'options'=>['class'=>'success','style'=>'font-weight:bold;']
                    ];
            }
            ],
            [
            'header'=>'Code',
            'value'=>'id',
            'width'=>'50px',
            ],
            [
                'header'=>'Trip Description',
                'format'=>'raw',
                'value'=>function($model){
                    if (!empty($model->shuttleTmp->id_booking)) {
                        return "<b>".$model->idTrip->idBoat->idCompany->name."</b> ( <span class='text-primary'>".$model->idTrip->idRoute->departureHarbor->name."</span> -> <span class='text-warning'>".$model->idTrip->idRoute->arrivalHarbor->name."</span> ) On <b>".date('d-m-Y',strtotime($model->idTrip->date))."</b> At <b>". date('H:i',strtotime($model->idTrip->dept_time))."</b><br> Required ".$model->shuttleTmp->type." in ".$model->shuttleTmp->idArea->area."-".$model->shuttleTmp->location_name."-".$model->shuttleTmp->address."-".$model->shuttleTmp->phone;
                    }else{
                    return "<b>".$model->idTrip->idBoat->idCompany->name."</b> ( <span class='text-primary'>".$model->idTrip->idRoute->departureHarbor->name."</span> -> <span class='text-warning'>".$model->idTrip->idRoute->arrivalHarbor->name."</span> ) On <b>".date('d-m-Y',strtotime($model->idTrip->date))."</b> At <b>". date('H:i',strtotime($model->idTrip->dept_time))."</b><br>";
                }
                }
            ],
            [
                'header'=>'Passenger',
                'value'=>function($model){
                  
                    $Child = TPassenger::find()->where(['id_booking'=>$model->id])->andWhere(['id_type'=>'2'])->all();
                    $Infant = TPassenger::find()->where(['id_booking'=>$model->id])->andWhere(['id_type'=>'3'])->all();
                    $Adult = TPassenger::find()->where(['id_booking'=>$model->id])->andWhere(['id_type'=>'1'])->all();
                    if ($Child == null && $Infant == null) {
                       return count($Adult)." Adult";
                    }elseif ($Child == null && $Infant != null) {
                       return count($Adult)." Adult, ".count($Infant)." Infant";
                    }elseif($Child != null && $Infant == null){
                        return count($Adult)." Adult, ". count($Child)." Child";
                    }else{
                        return count($Adult)." Adult, ". count($Child)." Child, ".count($Infant)." Infant";
                    }
                    
                }
            ],
            // 'token:ntext',
            // 'process_by',
            // 'expired_time',
            // 'datetime',
        ],
    ]); ?>
    </div>
<div class="col-md-12">
<div class=" col-md-8 panel panel-default material-panel material-panel_warning">
            <h5 class="panel-heading material-panel__heading">Summary Passengers</h5>
            <div id="body-summary" class="panel-body material-panel__body">
                Something Its Wrong..Try To reload page or contact Us
                

</div>
</div>
</div>
<?php Pjax::end(); ?>
</div>
<?php 
$this->registerJs('
    $("#body-summary").html("<center><div class=\'col-md-12\'><img src=\'/spinner.svg\'></div></center>");
     $.ajax({
                url:"'.Url::to(["summary"]).'",
                type: "POST",
                success:function(data){
                    $("#body-summary").html(data);
                }
              })
    ');
?>