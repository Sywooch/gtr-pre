<?php

namespace frontend\models;

use Yii;
use yii\base\Model;

/**
 * ContactForm is the model behind the contact form.
 */
class BookForm extends Model
{
    public $departurePort;
    public $departureDate;
    public $arrivalPort;
    public $returnDate;
    public $type;
    public $adults;
    public $childs;
    public $infants;
    public $currency;



    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // departure, email, arrival and body are required
            [['departurePort','type', 'arrivalPort', 'adults','departureDate'], 'required'],
            [['departureDate','returnDate'],'date', 'format'=>'php:Y-m-d'],
            [['childs','infants','adults'],'integer'],
            [['type'],'boolean'],
            [['currency'],'string','max'=>3],
            ['returnDate','returnValidate'],
            ];
    }



 public function returnValidate($attribute, $params, $validator){
    if ($this->type == true) {
        if(strtotime($this->returnDate) < strtotime($this->departureDate)){
        $this->addError('returnDate','This Item Is Invalid');
        $this->addError('departureDate','This Item Is Invalid');

        }
    }    
 }
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'departurePort' => 'From',
            'arrivalPort' => 'To',
            'departureDate' => 'Departure',
            'returnDate' => 'Return',
            'type' => 'type',
            'adults' => 'adults',
            'childs' => 'childs',
            'currency' => 'Currency',
            'infants' => 'infants',

        ];
    }

}
