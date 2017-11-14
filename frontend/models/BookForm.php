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
            [['departurePort', 'arrivalPort', 'adults','departureDate'], 'required'],
            [['childs','infants','type'],'integer'],
            [['currency'],'string','max'=>3],
            ['returnDate','returnvalidate'],
            ];
    }

public function returnvalidate($attribute, $params, $validator){
    if ($this->type == "2" && $this->$attribute < $this->departureDate) {
        
        $this->addError($attribute,'Please Select Valid Return');
       return false;
    }else{
        return true;
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
