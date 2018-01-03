<?php

namespace frontend\models;

use Yii;
use yii\base\Model;

/**
 * ContactForm is the model behind the contact form.
 */
class Hotel extends Model
{
    public $city;
    public $check_in;
    public $check_out;



    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // departure, email, arrival and body are required
            [['city', 'check_out','check_in'], 'required'],
            [['city'],'integer'],
            [['check_in','check_out'],'safe'],
            ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'city' => 'City',
            'check_out' => 'Check Out',
            'check_in' => 'Check Out',

        ];
    }

}
