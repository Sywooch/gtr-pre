<?php
use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\label\LabelInPlace;
use kato\pickadate\Pickadate;
use kartik\dialog\Dialog;
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
echo Dialog::widget([
'dialogDefaults'=>[
    Dialog::DIALOG_CONFIRM => [
        'type'           => Dialog::TYPE_INFO,
        'title'          => 'Confirm',
        'btnOKClass'     => 'btn-danger',
        'btnOKLabel'     =>' Yes',
        'btnCancelLabel' =>' No'
        ]
    ]]);
$session = Yii::$app->session;
var_dump($session['session_key']);
?>


	 <!-- Cart Start -->
<div class="panel panel-default material-panel material-panel_primary">
  <div class="panel-heading material-panel__heading"><b><?= count($cartList) ?> Item On Cart</b></div>
    <div id="cart" class="panel-body material-panel__body">
      <?php foreach ($cartList as $index => $value): ?>
                    
					<ul class="list-group">
					<li class="list-group-item"><?= $value->idTrip->idRoute->fromRoute->location." <span class='glyphicon glyphicon-arrow-right'></span> ".$value->idTrip->idRoute->toRoute->location ?>
          <br><span class="glyphicon glyphicon-calendar"></span> <?= date('d-m-Y',strtotime($value->trip_date)) ?>
          | <span class="glyphicon glyphicon-time"></span> <?= date('H:i',strtotime($value->trip_date)) ?>
          <span class="pull-right">
					<?= Html::a('', ['remove-cart','id'=>$value->id], [
						'class' => 'btn material-btn material-btn_danger main-container__column material-btn_xs pull-right glyphicon glyphicon-trash',
            'data-toggle' =>'tooltip',
            'title'       =>'Delete This Item',
						'data' => [
              'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
						  'method' => 'post',
							],
					]); ?>
          </span>
					</li>
					<li class="list-group-item"><span class="fa fa-money"></span>
            <?php 
              $totalPax = $value->adult+$value->child;
              $maxPax = $value->idTrip->max_person;
            ?>

            <?php if($totalPax <= $maxPax): ?>
              <?php $totalPrice = round($value->idTrip->min_price/$value->exchange,0,PHP_ROUND_HALF_UP); ?> 
						<?= $value->adult+$value->child." Pax = ".$value->currency." ".$totalPrice ?>
            <span class="pull-right"><b><?= $value->currency." ".$totalPrice ?></b></span>
            <?php else: ?>
              <?php
               $minPrice = round($value->idTrip->min_price/$value->exchange,0,PHP_ROUND_HALF_UP);
               $extraPax = $totalPax-$maxPax;
               $extraPrice = round($value->idTrip->person_price/$value->exchange*$extraPax,0,PHP_ROUND_HALF_UP);
               $totalPrice = round($minPrice+$extraPrice,0,PHP_ROUND_HALF_UP)
              ?>
            <?= $value->adult+$value->child." Pax = @ ".$value->currency." ".round($value->idTrip->person_price/$value->exchange,0,PHP_ROUND_HALF_UP) ?>
            <span class="pull-right"><b><?= $value->currency." ".$totalPrice ?></b></span>
            <?php endif; ?>

          </li>
					</ul>
          <?php 
          $grandTotal[] = $totalPrice;  
          ?> 
      <?php endforeach; ?>
            
<?= Html::a('Add Another Trip', Yii::$app->homeUrl, [
            'class'       => 'pull-left btn material-btn material-btn_warning main-container__column material-btn_lg pull-right',
            
            ]); ?>
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
                  echo "<h4 class='col-md-12'>Passenger Detail <b>".$cartValue->idTrip->idRoute->fromRoute->location." <span class='glyphicon glyphicon-arrow-right'></span> ".$cartValue->idTrip->idRoute->toRoute->location."</b>. On  <b>".date('d-m-Y H:i',strtotime($cartValue->trip_date))."</b></h4>";
                  
                  foreach ($modelAdults as $index => $modelAdult) {
                    echo "<h4 class='col-md-12'>Adult</h4>";
                    for ($i=0; $i < $cartList[$key]['adult']; $i++) { 
                      if ($key != 0 && $i == 0) {
                    echo '<div class="col-md-3 main-container__column material-checkbox-group material-checkbox-group_primary">
                          '.Html::checkbox('checkbox'.$cartValue->id_trip, $checked = false, [
                            'id' => 'checkbox-'.$cartValue->id_trip.'-'.$key,
                            'class'=>'material-checkbox checkbox-copy',
                            'onchange'=>'
                            if ($(this).is(":checked")) {
                             var jml = $("[id^=adult-source-]").size();
                             for (n=0; n < jml; n++) {
                               var src = $(".form-adult-source-"+n).val();
                               if ( $(".form-adult-obj-'.$cartValue->id_trip.'-"+n).length ) {
                                $(".form-adult-obj-'.$cartValue->id_trip.'-"+n).val(src);
                                $(".label-adult-'.$cartValue->id_trip.'-"+n).hide();
                               }else{
                                return true;
                               }
                             }
                            }else{
                              var jml = $("[id^=adult-source-]").size();
                             for (n=0; n < jml; n++) {
                               var src = $(".form-adult-source-"+n).val();
                               if ( $(".form-adult-obj-'.$cartValue->id_trip.'-"+n).length ) {
                               // alert(src);
                                $(".form-adult-obj-'.$cartValue->id_trip.'-"+n).val(null);
                                $(".label-adult-'.$cartValue->id_trip.'-"+n).show();
                               }else{
                                return true;
                               }
                             }
                            }
                              ',
                            ]).'<label class="material-checkbox-group__label" for="checkbox-'.$cartValue->id_trip.'-'.$key.'">Same As Above</label>
                          </div>';
                  }
                      echo "<div class='col-md-12'><div class='col-md-5'>";
                      echo $form->field($modelAdult, "[$cartValue->id_trip][adult][$i]name",$config)->widget(LabelInPlace::classname(),
                      [
                      'options'=>[
                            'class'=>$key == 0 ? 'form-control form-adult-source-'.$i : 'form-control form-adult-obj-'.$cartValue->id_trip.'-'.$i,
                            'id'=>$key == 0 ? 'adult-source-'.$key.'-'.$i : 'adult-obj-'.$key.'-'.$i,
                            ],
                      'labelOptions'=>['class'=>'label-adult-'.$cartValue->id_trip.'-'.$i],
                      'defaultIndicators'=>false,
                      'encodeLabel'=> false,
                      'label'=>'<i class="glyphicon glyphicon-user"></i>Adult Name',
                      ]
                      )."</div>";
           
                      echo "<div class='col-md-3'>";
                      echo $form->field($modelAdult, "[$cartValue->id_trip][adult][$i]id_nationality",$config)->dropDownList($listNationality, [
                          'class' => 'form-nationality',
                          'prompt' => 'Select Nationality',
                          'onchange'=>$key == 0 ? '
                              var ntn = $(this).val();
                              if (ntn == "" || ntn == null || ntn == undefined) {
                                
                              }else{
                                $(".form-nationality").val(ntn);
                              }
                                
                                ' : 'return true;',
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
  format: 'yyyy-mm-dd',
  formatSubmit: 'yyyy-mm-dd',
  today: '',
  clear: 'Clear',
  close: '',
});
SCRIPT;
$this->registerJs($customScript, \yii\web\View::POS_READY);

$this->registerJs('
$("#checkbox-'.$cartValue->id_trip.'-'.$key.'").on("change",function(){
  if ($(this).is(":checked")) {
    var jmlc = $("[id^=child-name-source-]").size();
    for (c=0; c < jmlc; c++) {
      var nsrc = $(".child-name-source-"+c).val();
      var bsrc = $(".child-birthday-source-"+c).val();
      if ( $(".child-name-obj-'.$cartValue->id_trip.'-"+c).length ) {
        $(".child-name-obj-'.$cartValue->id_trip.'-"+c).val(nsrc);
        $(".label-child-'.$cartValue->id_trip.'-"+c).hide();
        $("#c-brith-obj-'.$cartValue->id_trip.'-"+c+" > div > input").val(bsrc);
      }
    }
  }else{
    $("[id^=c-brith-obj-'.$cartValue->id_trip.'-] > div > input").val(null);
    $(".form-child-obj").val(null);
    $(".label-childs").show();

  }
});

  ', \yii\web\View::POS_READY);
                    foreach ($modelChildsInfants as $indexchild => $modelChild) {
                        echo "<h4 class='col-md-12'>Child</h4>";

                        for ($i=$cartList[$key]['adult']; $i < $cartList[$key]['child']+$cartList[$key]['adult']; $i++) { 
                          $copyVarC = $i-$cartList[$key]['adult'];
                          echo "<div class='col-md-12'><div class='col-md-5'>";
                          echo $form->field($modelChild, "[$cartValue->id_trip][child][$i]name",$config)->widget(LabelInPlace::classname(),
                          [
                          'defaultIndicators'=>false,
                          'encodeLabel'=> false,
                          'label'=>'<i class="glyphicon glyphicon-user"></i>Child Name',
                          'options'=>[
                            'class'=>$key == 0 ? 'form-control child-name-source-'.$copyVarC : 'form-control form-child-obj child-name-obj-'.$cartValue->id_trip.'-'.$copyVarC,
                            'id'=>$key == 0 ? 'child-name-source-'.$key.'-'.$copyVarC : 'child-obj-'.$key.'-'.$copyVarC,
                            ],
                          'labelOptions'=>['class'=>$key == 0 ? '' : 'label-childs label-child-'.$cartValue->id_trip.'-'.$copyVarC],
                          ]
                          )."</div>";
                          echo "<div class='col-md-3'>".$form->field($modelChild, "[$cartValue->id_trip][child][$i]id_nationality",$config)->dropDownList($listNationality, [
                          'class' => 'form-nationality',
                          'prompt' => 'Select Nationality',
                          ])."</div>";

                          echo "<div class='col-md-2'>". $form->field($modelChild, "[$cartValue->id_trip][child][$i]birthday",['template'=>"{input}\n{error}\n{hint}",'options' => [ 'id' => $key == 0 ? 'c-brith-src' : 'c-brith-obj-'.$cartValue->id_trip.'-'.$copyVarC]])->widget(Pickadate::classname(), [
                              'isTime' => false,
                             // 'id'=>'child-birthday',
                              'options'=>[
                                  'class' => $key == 0 ? 'picker-childs child-birthday-source-'.$copyVarC : 'picker-childs child-birthday-obj-'.$cartValue->id_trip.'-'.$copyVarC,
                                  'id'    => $key == 0 ? 'child-birthday-source-'.$key.'-'.$copyVarC : 'child-birthday-obj-'.$key.'-'.$copyVarC,
                                  'placeholder'=>'Date of birth',

                                  ],
                              
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
  format: 'yyyy-mm-dd',
  formatSubmit: 'yyyy-mm-dd',
  today: '',
  clear: 'Clear',
  close: '',
});
SCRIPT;
$this->registerJs($customScript, \yii\web\View::POS_READY);

$this->registerJs('
$("#checkbox-'.$cartValue->id_trip.'-'.$key.'").on("change",function(){
  if ($(this).is(":checked")) {
    var jmli = $("[id^=infant-name-source-]").size();
    for (i=0; i < jmli; i++) {
      var src = $(".infant-name-source-"+i).val();
      var bsri = $(".infants-birthday-source-"+i).val();
      if ( $(".form-infant-obj-'.$cartValue->id_trip.'-"+i).length ) {
        $(".form-infant-obj-'.$cartValue->id_trip.'-"+i).val(src);
        $(".label-infant-'.$cartValue->id_trip.'-"+i).hide();
        $("#i-brith-obj-'.$cartValue->id_trip.'-"+i+" > div > input").val(bsri);
      }
    }
  }else{
    $("[id^=i-brith-obj-'.$cartValue->id_trip.'-] > div > input").val(null);
    $(".form-infant-obj").val(null);
    $(".label-infants").show();
  }
});

  ', \yii\web\View::POS_READY);                    
                    foreach ($modelChildsInfants as $indexinfants => $modelInfant) {
                      echo "<h4 class='col-md-12'>Infants</h4>";
                      for ($i=$cartList[$key]['child']+$cartList[$key]['adult']; $i < $cartList[$key]['infant']+$cartList[$key]['child']+$cartList[$key]['adult']; $i++) {
                        $copyVarI = $i-($cartList[$key]['child']+$cartList[$key]['adult']); 
                          echo "<div class='col-md-12'><div class='col-md-5'>";
                          echo $form->field($modelInfant, "[$cartValue->id_trip][infant][$i]name",$config)->widget(LabelInPlace::classname(),
                          [
                          'class'=>'infant',
                          'defaultIndicators'=>false,
                          'encodeLabel'=> false,
                          'label'=>'<i class="glyphicon glyphicon-user"></i>Infant Name',
                          'options'=>[
                            'class'=>$key == 0 ? 'form-control infant-name-source-'.$copyVarI : 'form-control form-infant-obj-'.$cartValue->id_trip.'-'.$copyVarI,
                            'id'=>$key == 0 ? 'infant-name-source-'.$key.'-'.$copyVarI : 'infant-obj-'.$key.'-'.$copyVarI,
                            ],
                          'labelOptions'=>['class'=>$key == 0 ? '' : 'label-infants label-infant-'.$cartValue->id_trip.'-'.$copyVarC],
                          ]
                          )."</div>";

                          echo "<div class='col-md-3'>".$form->field($modelInfant, "[$cartValue->id_trip][infant][$i]id_nationality",$config)->dropDownList($listNationality, [
                          'class' => 'form-nationality',
                          'prompt' => 'Select Nationality',
                          ])."</div>";

                          echo "<div class='col-md-2'>". $form->field($modelInfant, "[$cartValue->id_trip][infant][$i]birthday",['template'=>"{input}\n{error}\n{hint}",'options' => [ 'id' => $key == 0 ? 'i-brith-src' : 'i-brith-obj-'.$cartValue->id_trip.'-'.$copyVarI]])->widget(Pickadate::classname(), [
                              'isTime' => false,
                             // 'id'=>'infants-birthday',
                              'options'=>[
                                  'class' => $key == 0 ? 'picker-infants infants-birthday-source-'.$copyVarI : 'picker-infants infants-birthday-obj-'.$cartValue->id_trip.'-'.$copyVarI,
                                  'id'    => $key == 0 ? 'infants-birthday-source-'.$key.'-'.$copyVarI : 'infants-birthday-obj-'.$key.'-'.$copyVarI,
                                  'placeholder'=>'Date of birth',

                                  ],
                              
                              ])."</div></div>";

                      }
                    }
                  }


              if ($cartValue->idTrip->idRoute->to_route == 1 || $cartValue->idTrip->idRoute->from_route == 1) {
                  $label = "Flight Number/Time ";
              }else{
                  $label = " Hotel Name/Hotel Address/Shuttle Location";
              }
                  echo "<div class='col-md-12'>";
                  echo "<div class='col-md-12'><span class='glyphicon glyphicon-info-sign'></span> Additional Information </div>";
                  echo "<div class='col-md-8'>";
                  echo LabelInPlace::widget([
                        'name'=>"Note[".$cartValue->id_trip."][".date('Y-m-d',strtotime($cartValue->trip_date))."][".date('H:i',strtotime($cartValue->trip_date))."]",
                        'label'=>$label,
                        'defaultIndicators'=>false,
                        'encodeLabel'=>false,
                        'type' => LabelInPlace::TYPE_TEXTAREA
                        ]);
                  echo "</div>";
                  echo "</div>";  
              }

             ?>
       <?= Html::submitButton('Next', ['class' => 'btn material-btn material-btn_warning main-container__column material-btn_lg btn-block pull-right']); ?>


  
		<?php ActiveForm::end(); ?>
<?php endif; ?>