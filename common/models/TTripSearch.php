<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\TTrip;

/**
 * TTripSearch represents the model behind the search form about `common\models\TTrip`.
 */
class TTripSearch extends TTrip
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'id_boat', 'id_route', 'status', 'id_est_time'], 'integer'],
            [['date', 'dept_time', 'description', 'datetime'], 'safe'],
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
    public function search($params)
    {
        $query = TTrip::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=>[
                'defaultOrder'=>[
                'date'=>SORT_ASC,
                'dept_time'=>SORT_ASC
                ]
            ]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id'          => $this->id,
            'id_boat'     => $this->id_boat,
            'id_route'    => $this->id_route,
            'date'        => $this->date,
            'dept_time'   => $this->dept_time,
            'status'      => $this->status,
            'datetime'    => $this->datetime,
            'id_est_time' => $this->id_est_time,
        ]);

        $query->andFilterWhere(['like', 'description', $this->description]);

        return $dataProvider;
    }
}
