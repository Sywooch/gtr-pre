<?php

namespace frontend\models;

use Yii;
use yii\base\Model;

/**
 * ContactForm is the model behind the contact form.
 */
class PrivateForm extends Model
{
    public $departureLocation;
    public $departureDate;
    public $departtureTime;
    public $arrivalLocation;
    public $returnDate;
    public $returnTime;
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
            [['departureLocation','type', 'arrivalLocation', 'adults','departureDate','departtureTime'], 'required'],
            [['departureDate','returnDate'],'date', 'format'=>'php:Y-m-d'],
            [['childs','infants','adults'],'integer'],
            [['type'],'boolean'],
            [['currency'],'string','max'=>3],
            ['returnDate','returnValidate'],
            ['departureDate','departureValidate'],
            [['departtureTime','returnTime'],'timeValidation'],
            //[]
            ];
    }
//strtotime(date('Y-m-d H:i:s')) > strtotime(date('Y-m-d 18:00:00')) && 
 public function departureValidate($attribute, $params, $validator){
    if (strtotime($this->departureDate) < strtotime('+1 DAYS',strtotime(date('Y-m-d')))) {
        $this->addError('departureDate','This Item Is Invalid');
        return false;
    }else{
        return true;
    }

 }

 public function returnValidate($attribute, $params, $validator){
    if ($this->type == true) {
        if(strtotime($this->returnDate) < strtotime($this->departureDate)){
        $this->addError('returnDate','This Item Is Invalid');
        $this->addError('departureDate','This Item Is Invalid');
        return false;
        }
    }  
 }
 public function timeValidation($attribute, $params, $validator){
        if(strtotime($this->$attribute) < strtotime('09:00')){
        $this->addError($attribute,'This Item Is Invalid');
        return false;

        }   
 }
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'departureLocation' => 'From',
            'arrivalLocation' => 'To',
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
