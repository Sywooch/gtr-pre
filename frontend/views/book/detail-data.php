<?php
use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\widgets\DatePicker;
use kartik\label\LabelInPlace;
use yii\helpers\ArrayHelper;
use kartik\widgets\Select2;
use kato\pickadate\Pickadate;
/* @var $this yii\web\View */
/* @var $model common\models\TKurs */
/* @var $form yii\widgets\ActiveForm */
$config = ['template'=>"{input}\n{error}\n{hint}"];
//var_dump($cartList[1]['id_trip']);
$this->title = 'Fill Your Data';
$customCss = <<< SCRIPT
  #cart {
    font-size:12px;
}
.list-group-item{
  padding: 10px 10px;
}
#grand-total{
  font-size: 20px;
  font-weight: bold;
}

SCRIPT;
$this->registerCss($customCss);


?>

	 <!-- Cart Start -->
	
	  <div class="material-panel material-panel_primary">

                    <div class="material-panel__heading">
                        <b><?= count($cartList) ?> Item On Cart</b>

                    </div>
         <div id="cart" class="panel-body">
            <?php foreach ($cartList as $index => $value): ?>
                    
					<ul class="list-group material-list-group">
					<li class="list-group-item material-list-group__item"><b><?= $value->idTrip->idBoat->idCompany->name ?></b> - <?=  $value->idTrip->idBoat->name ?>
          <?php if(count($cartList) > 1 ): ?>
          <?= $value->type == '1' ? '<span class="material-label material-label_xs material-label_primary">One Way' : '<span class="material-label material-label_xs material-label_success">Return' ?>
        <?php else: ?>
          <span class="material-label material-label_xs material-label_primary">One Way
        <?php endif; ?>
          </span>
          <span class="pull-right">
					<?= Html::a('', ['remove-cart','id'=>$value->id], [
						'class' => 'btn material-btn material-btn_danger main-container__column material-btn_xs pull-right glyphicon glyphicon-trash',
						'data' => [
              'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
						  'method' => 'post',
							],
					]); ?>
          </span>
					</li>
					<li class="list-group-item material-list-group__item"><?= $value->idTrip->idRoute->departureHarbor->name." -> ".$value->idTrip->idRoute->arrivalHarbor->name ?></li>
					<li class="list-group-item material-list-group__item">
						<?=  $value->adult != '0' ? $value->adult." Adult = ".$value->currency." ".round($value->idTrip->adult_price/$value->exchange*$value->adult,2,PHP_ROUND_HALF_UP) : " " ?>

						<?=  $value->child != '0' ? " + ".$value->child ." Child = ".$value->currency." ".round($value->idTrip->child_price/$value->exchange*$value->child,2,PHP_ROUND_HALF_UP) : " " ?>

						<?=   $value->infant != '0' ? " + ".$value->infant." Infant = ".$value->currency." 0 " : " " ?>

          <span class="pull-right"><b><?= $value->currency ?> <?= round($value->idTrip->adult_price/$value->exchange*$value->adult,2,PHP_ROUND_HALF_UP)+round($value->idTrip->child_price/$value->exchange*$value->child,2,PHP_ROUND_HALF_UP) ?></b></span>      
            </li>
					</ul>
          <?php $grandTotal[] = round($value->idTrip->adult_price/$value->exchange*$value->adult,2,PHP_ROUND_HALF_UP)+round($value->idTrip->child_price/$value->exchange*$value->child,2,PHP_ROUND_HALF_UP);  ?> 
            <?php endforeach; ?>
            
<?= Html::a('Add Another Trip', Yii::$app->homeUrl, ['class' => 'pull-left btn material-btn material-btn_warning main-container__column material-btn_lg pull-right']); ?>
<?php if(!empty($cartList)):  ?> 
<span class="pull-right" id="grand-total">TOTAl <?= $cartList[0]['currency']." ".array_sum($grandTotal) ?></span>
  </div>
  </div>
<?php else: ?>
  <span class="pull-right" id="grand-total">-</span>
  </div>
  </div>
<?php endif; ?>
<?php if(!empty($cartList)):  ?> 


  <!-- Cart End -->
  		<?php $form = ActiveForm::begin(); ?>
      <div class="col-md-12">
     <h4>Fill Your Contact</h4>
    <?= $form->field($modelPayment, "name",$config)->widget(LabelInPlace::classname(),
                [
               
                'class'=>'form-control name',
                'defaultIndicators'=>false,
                'encodeLabel'=> false,
                'label'=>'<i class="glyphicon glyphicon-user"></i> Buyer Name',
                ]
                );
        ?>
        </div>
     <div class="col-md-12">
		<?= $form->field($modelPayment, "email",$config)->widget(LabelInPlace::classname(),
                [
               
                'class'=>'form-control email',
                'defaultIndicators'=>false,
                'encodeLabel'=> false,
              	'label'=>'<i class="glyphicon glyphicon-envelope"></i> Your Email For Sending Ticket',
                ]
                );
        ?>
        </div>
        <div class="col-md-12 col-lg-12">
        <?= $form->field($modelPayment, "phone",$config)->widget(LabelInPlace::classname(),
                [
               
                'class'=>'form-control phone',
                'defaultIndicators'=>false,
                'encodeLabel'=> false,
                'label'=>'<i class="glyphicon glyphicon-phone"></i> Phone Number',
                ]
                );
        ?>
</div>

    
       			<?php $now = date('Y,m,d');
                  /*echo $now."<br>";
                  echo date('Y,m,d',strtotime($now));*/
             
               foreach ($cartList as $key => $cartValue) {
                  echo "<h3 class='col-md-12'>Passenger Detail With <b>".$cartValue->idTrip->idBoat->idCompany->name."</b>. On  <b>".$cartValue->idTrip->date."</b></h3>";
                  
                  foreach ($modelAdults as $index => $modelAdult) {
                    echo "<h4 class='col-md-12'>Adult</h4>";
                    for ($i=0; $i < $cartList[$key]['adult']; $i++) { 
                      if ($key != 0 && $i == 0) {

                    echo '<div class="col-md-3 main-container__column material-checkbox-group material-checkbox-group_primary">
                          '.Html::checkbox('checkbox'.$cartValue->id_trip, $checked = false, [
                            'id' => 'checkbox-'.$cartValue->id_trip.'-'.$key,
                            'class'=>'material-checkbox',
                           /* 'onchange'=>'
                            if ($(this).is(":checked")) {
                             // $("[id^=adult-obj]").val($("[id^=adult-source]").val());
                              
                            }else{
                            //  $("[id^=adult-obj]").val(null);
                            }
                              ',*/
                            ]).'<label class="material-checkbox-group__label" for="checkbox-'.$cartValue->id_trip.'-'.$key.'">Same As Above</label>
                          </div>';
                  }
                      echo "<div class='col-md-12'><div class='col-md-5'>";
                      echo $form->field($modelAdult, "[$cartValue->id_trip][adult][$i]name",$config)->widget(LabelInPlace::classname(),
                      [
                      'options'=>[
                            'class'=>$key == 0 ? 'form-control form-adult-source'.$i : 'form-control form-adult-obj-'.$i,
                            'id'=>$key == 0 ? 'adult-source-'.$i.'-'.$key : 'adult-obj-'.$i.'-'.$key ],
                      'defaultIndicators'=>false,
                      'encodeLabel'=> false,
                      'label'=>'<i class="glyphicon glyphicon-user"></i>Adult Name',
                      ]
                      )."</div>";
           
                      echo "<div class='col-md-3'>";
                      echo $form->field($modelAdult, "[$cartValue->id_trip][adult][$i]id_nationality",$config)->widget(Select2::classname(), [
                            'data' => $listNationality,
                            'options' => ['placeholder' => 'Select Nationality'],
                            'pluginOptions' => [
                            'allowClear' => true
                            ],
                            ])."</div></div>";
                    }
                  }

                  if (!empty($cartList[$key]['child'])) {
$customScript = <<< SCRIPT
$('.picker-childs').pickadate({
  min:-4380,
  max:-730,
  selectYears: true,
  selectMonths: true,
  format: 'dd-mm-yyyy',
  formatSubmit: 'yyyy-mm-dd',
  today: '',
  clear: 'Clear',
  close: '',
});
SCRIPT;
$this->registerJs($customScript, \yii\web\View::POS_READY);
                    foreach ($modelChilds as $indexchild => $modelChild) {
                        echo "<h4 class='col-md-12'>Child</h4>";

                        for ($i=$cartList[$key]['adult']; $i < $cartList[$key]['child']+$cartList[$key]['adult']; $i++) { 
                          echo "<div class='col-md-12'><div class='col-md-5'>".$form->field($modelChild, "[$cartValue->id_trip][child][$i]name",$config)->widget(LabelInPlace::classname(),
                          [
                          'defaultIndicators'=>false,
                          'encodeLabel'=> false,
                          'label'=>'<i class="glyphicon glyphicon-user"></i>Child Name',
                          ]
                          )."</div>";
                          echo "<div class='col-md-3'>".$form->field($modelChild, "[$cartValue->id_trip][child][$i]id_nationality",$config)->widget(Select2::classname(), [
                                'data' => $listNationality,
                                'options' => ['placeholder' => 'Select Nationality'],
                                'pluginOptions' => [
                                'allowClear' => true
                                ],
                                ])."</div>";
                          echo "<div class='col-md-2'>". $form->field($modelChild, "[$cartValue->id_trip][child][$i]birthday",$config)->widget(Pickadate::classname(), [
                              'isTime' => false,
                              'id'=>'child-birthday',
                              'options'=>['id'=>'child-birthday-'.$cartValue->id_trip.'-'.$i,'class'=>'picker-childs','placeholder'=>'Date of birth'],
                              
                              ])."</div></div>";
                      }
                    }
                  }

                  if (!empty($cartList[$key]['infant'])) {
$customScript = <<< SCRIPT
  $('.picker-infants').pickadate({
  min:-730,
  max:true,
  selectYears: true,
  selectMonths: true,
  format: 'dd-mm-yyyy',
  formatSubmit: 'yyyy-mm-dd',
  today: '',
  clear: 'Clear',
  close: '',
});
SCRIPT;
$this->registerJs($customScript, \yii\web\View::POS_READY);                    
                    foreach ($modelInfants as $indexinfants => $modelInfant) {
                      echo "<h4 class='col-md-12'>Infants</h4>";
                      for ($i=$cartList[$key]['child']+$cartList[$key]['adult']; $i < $cartList[$key]['infant']+$cartList[$key]['child']+$cartList[$key]['adult']; $i++) { 
                          echo "<div class='col-md-12'><div class='col-md-5'>".$form->field($modelInfant, "[$cartValue->id_trip][infant][$i]name",$config)->widget(LabelInPlace::classname(),
                          [
                          'class'=>'infant',
                          'defaultIndicators'=>false,
                          'encodeLabel'=> false,
                          'label'=>'<i class="glyphicon glyphicon-user"></i>Infant Name',
                          ]
                          )."</div>";

                          echo "<div class='col-md-3'>".$form->field($modelInfant, "[$cartValue->id_trip][infant][$i]id_nationality",$config)->widget(Select2::classname(), [
                                'data' => $listNationality,
                                'options' => ['placeholder' => 'Select Nationality'],
                                'pluginOptions' => [
                                'allowClear' => true,
                                
                                ],
                                ])."</div>";

                          echo "<div class='col-md-2'>". $form->field($modelInfant, "[$cartValue->id_trip][infant][$i]birthday",$config)->widget(\kato\pickadate\Pickadate::classname(), [
                              'isTime' => false,
                              'id'=>'infant-birthday',
                              'options'=>['id'=>'infant-birthday-'.$cartValue->id_trip.'-'.$i,'class'=>'picker-infants','placeholder'=>'Date of birth'],
                             
                              ])."</div></div>";

                      }
                    }
                  }

                  $shuttleParameter = $cartValue->idTrip->idRoute->departureHarbor->id_island;
                  if ($shuttleParameter == 1 ) {
                    $type = 'pickup';
                    foreach ($modelShuttle as $k => $valShuttle) {

                    echo "<div class='col-md-12'>".Html::checkbox('check-pickup', $checked = false, ['class' => 'checkbox','value'=>1,'unchecked'=>0,'class'=>'checkbox-pickup-'.$cartValue->id_trip,
                        'onchange'=>'
                        if($(this).is(":checked"))
                        {
                        $("#form-pickup-'.$cartValue->id_trip.'").show(200);
                
                        }else{
                          $("#form-pickup-'.$cartValue->id_trip.'").hide(200);
                        }
                        
                        '])." <b>Required Pickup</b></div>";
                    echo "<div class='col-md-12' style='display:none;' id='form-pickup-".$cartValue->id_trip."'>";
                    echo  $this->render('_shuttle-form',[
                          'form'=>$form,
                          'type'=>$type,
                          'id'=>$cartValue->id_trip,
                          'valShuttle'=>$valShuttle,
                          'listPickup'=>$listPickup,
                          ])."</div>";
                  }
                      }elseif ($shuttleParameter == 2) {
                        $type = 'drop-off';
                        foreach ($modelShuttle as $k => $valShuttle) {
                        echo "<div class='col-md-12'>".Html::checkbox('check-drop', $checked = false, ['class' => 'checkbox','value'=>1,'unchecked'=>0,'class'=>'checkbox-drop-'.$cartValue->id_trip,
                        'onchange'=>'
                        if($(this).is(":checked"))
                        {
                        $("#form-drop-'.$cartValue->id_trip.'").show(200);
                      
                        }else{
                          $("#form-drop-'.$cartValue->id_trip.'").hide(200);
                        }
                        
                        '])." <b>Required Drop Off</b></div>";
                        echo "<div class='col-md-12' style='display:none;' id='form-drop-".$cartValue->id_trip."'>".
                        $this->render('_shuttle-form',[
                          'form'=>$form,
                          'type'=>$type,
                          'id'=>$cartValue->id_trip,
                          'valShuttle'=>$valShuttle,
                          'listPickup'=>$listPickup,
                          ])."</div>";
                  
                      } 
                      }                  
                    
              }

             ?>
       <?= Html::submitButton('Next', ['class' => 'btn material-btn material-btn_warning main-container__column material-btn_lg btn-block pull-right']); ?>


  
		<?php ActiveForm::end(); ?>
<?php endif; ?>
