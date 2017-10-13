<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\TTrip;

/**
 * TTripSearch represents the model behind the search form about `common\models\TTrip`.
 */
class TripSearching extends TTrip
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'id_boat', 'id_route', 'status'], 'integer'],
            [['date', 'dept_time', 'est_time', 'description', 'datetime'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search()
    {
        return TTrip::find();//->joinWith('TAvaibility');

    }
}
