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
            [['returnDate'],'safe'],
            ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'departurePort' => 'From',
            'arrivalPort' => 'To',
            'departureDate' => 'Departure Date',
            'returnDate' => 'Return Date',
            'type' => 'type',
            'adults' => 'adults',
            'childs' => 'childs',
            'currency' => 'Currency',
            'infants' => 'infants',

        ];
    }

}
