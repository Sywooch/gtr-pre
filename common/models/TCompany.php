<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "t_company".
 *
 * @property integer $id
 * @property string $name
 * @property string $address
 * @property string $email_bali
 * @property string $email_gili
 * @property string $phone
 * @property integer $id_pod
 * @property string $logo_path
 * @property integer $id_user
 * @property string $create_at
 * @property string $update_at
 *
 * @property TAvaibilityTemplate[] $tAvaibilityTemplates
 * @property TBoat[] $tBoats
 * @property TPod $idPod
 * @property User $idUser
 * @property TSeasonPriceSet[] $tSeasonPriceSets
 * @property TShuttlePrice[] $tShuttlePrices
 */
class TCompany extends \yii\db\ActiveRecord
{
    public $logo;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 't_company';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'address', 'email_bali', 'phone', 'id_pod', 'logo_path', 'id_user'], 'required'],
            [['id_pod', 'id_user'], 'integer'],
            [['logo_path'], 'string'],
            [['create_at', 'update_at'], 'safe'],
            [['name', 'email_bali', 'email_gili','email_cc'], 'string', 'max' => 50],
            [['email_bali', 'email_gili','email_cc'],'email'],
            [['address'], 'string', 'max' => 75],
            [['phone'], 'string', 'max' => 50],
            [['id_pod'], 'exist', 'skipOnError' => true, 'targetClass' => TPod::className(), 'targetAttribute' => ['id_pod' => 'id']],
            [['id_user'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['id_user' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'         => Yii::t('app', 'ID'),
            'name'       => Yii::t('app', 'Name'),
            'address'    => Yii::t('app', 'Address'),
            'email_bali' => Yii::t('app', 'Email Bali'),
            'email_gili' => Yii::t('app', 'Email Gili'),
            'email_cc'   => Yii::t('app', 'Email CC'),
            'phone'      => Yii::t('app', 'Phone'),
            'id_pod'     => Yii::t('app', 'Accept Pod ?'),
            'logo_path'  => Yii::t('app', 'Logo Path'),
            'id_user'    => Yii::t('app', 'User ID'),
            'create_at'  => Yii::t('app', 'Create At'),
            'update_at'  => Yii::t('app', 'Update At'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTAvaibilityTemplates()
    {
        return $this->hasMany(TAvaibilityTemplate::className(), ['id_company' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTBoats()
    {
        return $this->hasMany(TBoat::className(), ['id_company' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdPod()
    {
        return $this->hasOne(TPod::className(), ['id' => 'id_pod']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdUser()
    {
        return $this->hasOne(User::className(), ['id' => 'id_user']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTSeasonPriceSets()
    {
        return $this->hasMany(TSeasonPriceSet::className(), ['id_company' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTShuttlePrices()
    {
        return $this->hasMany(TShuttlePrice::className(), ['id_company' => 'id']);
    }
}
