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
	
	  <div class="panel panel-default material-panel material-panel_primary">

                    <div class="panel-heading material-panel__heading">
                        <b><?= count($cartList) ?> Item On Cart</b>

                    </div>
         <div id="cart" class="panel-body material-panel__body">
            <?php foreach ($cartList as $index => $value): ?>
                    
					<ul class="list-group">
					<li class="list-group-item"><span class="fa fa-ship"></span>
          <b><?= $value->idTrip->idBoat->idCompany->name ?></b>
          | </span> <?= $value->idTrip->idRoute->departureHarbor->name." <span class='fa fa-arrow-right'></span> ".$value->idTrip->idRoute->arrivalHarbor->name ?>
          <br><span class="fa fa-calendar"></span> <?= date('d-m-Y',strtotime($value->idTrip->date)) ?>
          | <span class="fa fa-clock-o"></span> <?= date('H:i',strtotime($value->idTrip->dept_time)) ?>
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
						<?=  $value->adult != '0' ? $value->adult." Adult = <b>".$value->currency." ".round($value->idTrip->adult_price/$value->exchange*$value->adult,0,PHP_ROUND_HALF_UP)."</b>" : " " ?>

						<?=  $value->child != '0' ? " + ".$value->child ." Child = <b>".$value->currency." ".round($value->idTrip->child_price/$value->exchange*$value->child,0,PHP_ROUND_HALF_UP)."</b>" : "" ?>

						<?=   $value->infant != '0' ? " + ".$value->infant." Infant = <b>".$value->currency." 0 </b>" : " " ?>

          <span class="pull-right"><b><?= $value->currency ?> <?= round($value->idTrip->adult_price/$value->exchange*$value->adult,0,PHP_ROUND_HALF_UP)+round($value->idTrip->child_price/$value->exchange*$value->child,0,PHP_ROUND_HALF_UP) ?></b></span>      
            </li>
					</ul>
          <?php $grandTotal[] = round($value->idTrip->adult_price/$value->exchange*$value->adult,0,PHP_ROUND_HALF_UP)+round($value->idTrip->child_price/$value->exchange*$value->child,0,PHP_ROUND_HALF_UP);  ?> 
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
                  echo "<h4 class='col-md-12'>Passenger Detail With <b>".$cartValue->idTrip->idBoat->idCompany->name."</b>. On  <b>".$cartValue->idTrip->date."</b></h4>";
                  
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
                    foreach ($modelChilds as $indexchild => $modelChild) {
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
                    foreach ($modelInfants as $indexinfants => $modelInfant) {
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

                  $departureIsland = $cartValue->idTrip->idRoute->departureHarbor->id_island;
                  $arrivalIsland = $cartValue->idTrip->idRoute->arrivalHarbor->id_island;
                  if ($departureIsland == $arrivalIsland) {
                    
                  }elseif ($departureIsland == 1 ) {
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
                      }elseif ($departureIsland == 2) {
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