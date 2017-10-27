<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "t_visitor".
 *
 * @property integer $id
 * @property string $ip
 * @property string $dns
 * @property string $user_agent
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $last_page
 */
class TVisitor extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 't_visitor';
    }

    public function behaviors()
    {
    return [
        TimestampBehavior::className(),
    ];
    }
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ip', 'dns', 'user_agent', 'last_page','country'], 'required'],
            [['user_agent'], 'string'],
            [['ip', 'dns'], 'string', 'max' => 20],
            [['last_page','country'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'country' => Yii::t('app', 'Country'),
            'ip' => Yii::t('app', 'Ip'),
            'dns' => Yii::t('app', 'Dns'),
            'user_agent' => Yii::t('app', 'User Agent'),
            'created_at' => Yii::t('app', 'In Time'),
            'updated_at' => Yii::t('app', 'Out Time'),
            'last_page' => Yii::t('app', 'Last Page'),
        ];
    }
}
