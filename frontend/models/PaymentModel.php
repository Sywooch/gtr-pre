<?php

namespace frontend\models;

use Yii;
use yii\base\Model;

/**
 * ContactForm is the model behind the contact form.
 */
class PaymentModel extends Model
{
    public $id_payment_method;
   // public $phone;



    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // departure, email, arrival and body are required
            [['id_payment_method'], 'required'],        
            ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_payment_method' => 'Payment',
           // 'phone' => 'Phone',
          
        ];
    }

}
