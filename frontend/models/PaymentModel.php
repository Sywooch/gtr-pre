<?php

namespace frontend\models;

use Yii;
use yii\base\Model;

/**
 * ContactForm is the model behind the contact form.
 */
class PaymentModel extends Model
{
    public $payment;
   // public $phone;



    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // departure, email, arrival and body are required
            [['payment'], 'required'],        
            ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'payment' => 'Payment',
           // 'phone' => 'Phone',
          
        ];
    }

}
