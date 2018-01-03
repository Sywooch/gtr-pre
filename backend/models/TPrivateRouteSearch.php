<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\TPrivateRoute;

/**
 * TPrivateRouteSearch represents the model behind the search form about `common\models\TPrivateRoute`.
 */
class TPrivateRouteSearch extends TPrivateRoute
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'from_route', 'to_route'], 'integer'],
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
        $query = TPrivateRoute::find();

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
            'from_route' => $this->from_route,
            'to_route' => $this->to_route,
        ]);

        return $dataProvider;
    }
}
