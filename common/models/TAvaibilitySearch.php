<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\TAvaibility;

/**
 * TAvaibilitySearch represents the model behind the search form about `common\models\TAvaibility`.
 */
class TAvaibilitySearch extends TAvaibility
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'id_trip', 'type', 'stok', 'sold', 'process', 'cancel', 'datetime'], 'integer'],
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
        $query = TAvaibility::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'id_trip' => $this->id_trip,
            'type' => $this->type,
            'stok' => $this->stok,
            'sold' => $this->sold,
            'process' => $this->process,
            'cancel' => $this->cancel,
            'datetime' => $this->datetime,
        ]);

        return $dataProvider;
    }
}
