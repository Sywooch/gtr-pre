<?php 
use yii\helpers\Html;
?>
<?= Html::a(' Add Operator', ['/operator/create'], ['class' => 'btn btn-md btn-danger glyphicon glyphicon-plus']); ?>
<br><br>
<ul class="list-group material-list-group">
<?php foreach($listOperator as $key => $val): ?>
	<li class="list-group-item material-list-group__item">
	<span class="fa fa-user"> <?= $val['name'] ?> </span> | 
	<span class="fa fa-phone"> <?= $val['phone'] ?> </span> | 
	<span class="fa fa-envelope"> <?= $val['email'] ?> </span>
	<?= Html::beginForm(['/private-booking/change-operator', 'id' =>$val['id']], 'post') ?>
    <div class="funkyradio">
    <div class="funkyradio-warning">
    <?= Html::hiddenInput('id_booking', $id_booking, ['readonly' => true]); ?>
    <?= Html::checkbox('id_operator', $checked = false,[
          'id'=>$val['id'],
          'value'=>$val['id'],
          'class'=>'checkbox-operator',
          'onchange'=>'
          if ($(this).is(":checked")) {
            $(".checkbox-operator").prop("checked", false);
            $(this).prop("checked", true);
            $(".btn-operator").hide(100);
            $("#btn-'.$val['id'].'").show(100);
          }else{
            $("#btn-'.$val['id'].'").hide(100);
          }
          '
          ]); ?>
    <?= Html::label('Select', $val['id']); ?>
    
    </div>
    </div>
    <?= Html::submitButton('Submit', [
            'class' => 'btn-operator btn btn-danger',
            'id'=>'btn-'.$val['id'],
            'style'=>'display: none;',
            'data' => [
              'confirm' => 'Are You Sure ? ',
              ]
            ]); ?>
<?= Html::endForm() ?>
	</li>
<?php endforeach; ?>
</ul>

<style type="text/css">
    .funkyradio label {
    /*min-width: 400px;*/
    width: 100%;
    border-radius: 3px;
    border: 2px solid #f2a12e;
    font-weight: normal;
}
.funkyradio input[type="checkbox"]:empty {
    display: none;
}
.funkyradio input[type="checkbox"]:empty ~ label {
    position: relative;
    line-height: 2.5em;
    text-indent: 3.25em;
    margin-top: 2em;
    cursor: pointer;
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;
}
.funkyradio input[type="checkbox"]:empty ~ label:before {
    position: absolute;
    display: block;
    top: 0;
    bottom: 0;
    left: 0;
    content:'';
    width: 2.5em;
    background: #ECEFF1;
    border-radius: 3px 0 0 3px;
}
.funkyradio input[type="checkbox"]:hover:not(:checked) ~ label:before {
    content:'\2714';
    text-indent: .9em;
    color: #C2C2C2;
}
.funkyradio input[type="checkbox"]:hover:not(:checked) ~ label {
    color: #888;
}
.funkyradio input[type="checkbox"]:checked ~ label:before {
    content:'\2714';
    text-indent: .9em;
    color: #333;
    background-color: #ccc;
}
.funkyradio input[type="checkbox"]:checked ~ label {
    color: #777;
}
.funkyradio input[type="checkbox"]:focus ~ label:before {
    box-shadow: 0 0 0 3px #999;
}
.funkyradio-warning input[type="checkbox"]:checked ~ label:before {
    color: #fff;
    background-color: #f0ad4e;
}

</style>
