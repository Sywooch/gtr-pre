<?php

namespace common\models;

use Yii;

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
class TAvaibilityTemplate extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 't_avaibility_template';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_company', 'name'], 'required'],
            [['id_company', 'senin', 'selasa', 'rabu', 'kamis', 'jumat', 'sabtu', 'minggu'], 'integer'],
            //[['senin', 'selasa', 'rabu', 'kamis', 'jumat', 'sabtu', 'minggu'], 'boolean'],
            [['time_senin', 'time_selasa', 'time_rabu', 'time_kamis', 'time_jumat', 'time_sabtu', 'time_minggu', 'datetime'], 'safe'],
            [['name'], 'string', 'max' => 50],
            [['id_company'], 'exist', 'skipOnError' => true, 'targetClass' => TCompany::className(), 'targetAttribute' => ['id_company' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'id_company' => Yii::t('app', 'Id Company'),
            'name' => Yii::t('app', 'Name'),
            'senin' => Yii::t('app', 'Senin'),
            'selasa' => Yii::t('app', 'Selasa'),
            'rabu' => Yii::t('app', 'Rabu'),
            'kamis' => Yii::t('app', 'Kamis'),
            'jumat' => Yii::t('app', 'Jumat'),
            'sabtu' => Yii::t('app', 'Sabtu'),
            'minggu' => Yii::t('app', 'Minggu'),
            'time_senin' => Yii::t('app', 'Time'),
            'time_selasa' => Yii::t('app', 'Time'),
            'time_rabu' => Yii::t('app', 'Time'),
            'time_kamis' => Yii::t('app', 'Time'),
            'time_jumat' => Yii::t('app', 'Time'),
            'time_sabtu' => Yii::t('app', 'Time'),
            'time_minggu' => Yii::t('app', 'Time'),
            'datetime' => Yii::t('app', 'Datetime'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdCompany()
    {
        return $this->hasOne(TCompany::className(), ['id' => 'id_company']);
    }
}
