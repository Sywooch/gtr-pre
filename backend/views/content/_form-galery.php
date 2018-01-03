<?php
use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\widgets\FileInput;
use yii\helpers\Url;
?>
<?php $form = ActiveForm::begin([
        'options'=>['enctype'=>'multipart/form-data']
    ]); ?>

<div class="galery-form">
<?= $form->field($modelGalery, 'galery[]')->widget(FileInput::classname(), [
        'options' => [
            'multiple'=>true,
            'accept' => 'image/*',
            'resizeImages'=>true,
            ],
            'pluginOptions' => [
				'initialPreview'       => $galeryPreview,
				'initialPreviewAsData' => true,
				'initialCaption'       => "Galery Image",
				'uploadUrl'            => Url::to(['upload-galery']),
				'browseOnZoneClick'    => true,
				'showCaption'          => true,
				'maxFileCount'         => 50,
				'uploadExtraData'      => [
						'id_parent'       => $modelContent->id,
						'id_type_galery'  => $modelContent->id_type_content,
						'slug'            => $modelContent->slug,
						'type_galery_dir' => $modelContent->idTypeContent->type,

                    ],
                
                ],
                'pluginEvents'=>[
                    'filebatchselected'=>'function(event, files) {
                                            $(this).fileinput("upload");
                                         }',
                    'filesuccessremove'=>'function(event, id) {
                                        var el = $(this).attr("class");
                                               alert(el);
                                        }'
                ]
    ])->label(false); ?>
</div>
<div class="form-group">
        <?= Html::submitButton(Yii::t('app', ' Save'), ['class' => 'btn material-btn material-btn_primary main-container__column material-btn_lg glyphicon glyphicon-floppy-saved']) ?>
    </div>
<?php ActiveForm::end(); ?>