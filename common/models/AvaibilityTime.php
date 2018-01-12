<?php

namespace common\models;

use Yii;
use yii\base\Model;

/**
 * This is the model class for table "t_avaibility_template".
 *
 * @property integer $id
 * @property integer $id_company
 * @property string $name
 * @property integer $senin
 * @property integer $selasa
 * @property integer $rabu
 * @property integer $kamis
 * @property integer $jumat
 * @property integer $sabtu
 * @property integer $minggu
 * @property string $time_senin
 * @property string $time_selasa
 * @property string $time_rabu
 * @property string $time_kamis
 * @property string $time_jumat
 * @property string $time_sabtu
 * @property string $time_minggu
 * @property string $datetime
 *
 * @property TCompany $idCompany
 */
class AvaibilityTime extends Model
{
    public $time_senin;
    public $time_selasa;
    public $time_rabu;
    public $time_kamis;
    public $time_jumat;
    public $time_sabtu;
    public $time_minggu;



    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['time_senin', 'time_selasa', 'time_rabu', 'time_kamis', 'time_jumat', 'time_sabtu','time_minggu'], 'required'],
            [['time_senin', 'time_selasa', 'time_rabu', 'time_kamis', 'time_jumat', 'time_sabtu', 'time_minggu', 'datetime'], 'safe'],

           
           
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'time_senin' => Yii::t('app', 'Time'),
            'time_selasa' => Yii::t('app', 'Time'),
            'time_rabu' => Yii::t('app', 'Time'),
            'time_kamis' => Yii::t('app', 'Time'),
            'time_jumat' => Yii::t('app', 'Time'),
            'time_sabtu' => Yii::t('app', 'Time'),
            'time_minggu' => Yii::t('app', 'Time'),
           
        ];
    }

}
