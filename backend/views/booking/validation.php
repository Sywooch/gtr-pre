<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use mdm\admin\components\Helper;
use common\models\TPassenger;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $searchModel app\models\TBookingSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Booking Validation';
$this->params['breadcrumbs'][] = $this->title;


?>
<div class="tbooking-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    
<?php  if(Helper::checkRoute('/*')): ?>
    <p>
        <?= Html::a('', ['create'], ['class' => 'btn material-btn material-btn_warning main-container__column material-btn_lg glyphicon glyphicon-plus']) ?>
    </p>
<?php endif; ?>
<?php Pjax::begin(['id'=>'pjax-validate']); ?>
<?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel'  => $searchModel,
        'panel'=>['type'=>'primary', 'heading'=>'Booking Data'],
        'striped'      =>true,
        'bordered'  => true,
        'hover'        =>true,
        'columns' => [
            ['class' => 'kartik\grid\SerialColumn'],

            [
                'attribute'=>'id_payment',
                'width'=>'auto',
                'format'=>'raw',
                'value'=>function ($model, $key, $index, $widget) { 
                return "Customer <b>".$model->idPayment->name." - ".$model->idPayment->email." - ".$model->idPayment->phone."</b><span class='pull-right'>".
                    Html::a('', '#', [
                                    'class' => 'btn material-btn material-btn_success main-container__column material-btn_xs glyphicon glyphicon-check',
                                    'onclick'=>'
                                        if(confirm("Confirm This Booking Is Valid and Ticket will be Send To Customer")){
                                           $.ajax({
                                               url:"'.Url::to(["validation-accept"]).'",
                                               type: "POST",
                                               data:{id: '.$model->id_payment.'},
                                               success:function(){
                                                $.pjax.reload({
                                                    container: "#pjax-validate"
                                                })
                                               }
                                           })
                                        }else{
                                            return false;
                                        }
                                    ',
                                    ]).
                    Html::a('', '#', [
                                    'class' => 'btn material-btn material-btn_danger main-container__column       material-btn_xs glyphicon glyphicon-remove',
                                    'onclick'=>'
                                        if(confirm("Confirm Alert\\r\\nThis Booking Is Invalid And Rejected?")){
                                           $.ajax({
                                               url:"'.Url::to(["validation-reject"]).'",
                                               type: "POST",
                                               data:{id: '.$model->id_payment.'},
                                               success:function(){
                                                $.pjax.reload({
                                                    container: "#pjax-validate"
                                                })
                                               }
                                           })
                                        }else{
                                            return false;
                                        }
                                    ',
                                    
                        ]).
                    "</span>";
                },
                
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
<?php Pjax::end(); ?></div>
