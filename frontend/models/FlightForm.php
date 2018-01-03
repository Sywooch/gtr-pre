<?php

namespace frontend\models;

use Yii;
use yii\base\Model;

/**
 * ContactForm is the model behind the contact form.
 */
class FlightForm extends Model
{
    public $flightTime;
    public $flightCode;
    public $airline;



    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
           [['airline','flightCode'],'required'],
           [['airline'],'string','max'=>100],
           [['flightCode'],'string','max'=>25],
           [['flightTime'],'safe'],

            //[]
            ];
    }
//strtotime(date('Y-m-d H:i:s')) > strtotime(date('Y-m-d 18:00:00')) && 
 
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'flightTime' => 'Flight Time',
            'flightCode' => 'flightCode',
            'airline' => 'Airline Name',

        ];
    }

}
