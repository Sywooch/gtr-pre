<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\TVisitor;

/**
 * TVisitorSearch represents the model behind the search form about `common\models\TVisitor`.
 */
class TVisitorSearch extends TVisitor
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'id_timezone', 'created_at', 'updated_at'], 'integer'],
            [['ip', 'id_country', 'region', 'city', 'latitude', 'longitude', 'url', 'user_agent'], 'safe'],
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
        //$sql = "SELECT * FROM t_visitor GROUP BY ip,DATE_FORMAT(created_at, '%d/%m/%Y %H:%i') ORDER BY updated_at DESC";
        // $sql = "SELECT * FROM t_visitor ORDER BY updated_at DESC";
        // $query = TVisitor::findBySql($sql);  
        $query = TVisitor::find();

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
            'id_timezone' => $this->id_timezone,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'url' => $this->url,
        ]);

        $query->andFilterWhere(['like', 'ip', $this->ip])
            ->andFilterWhere(['like', 'id_country', $this->id_country])
            ->andFilterWhere(['like', 'region', $this->region])
            ->andFilterWhere(['like', 'city', $this->city])
            ->andFilterWhere(['like', 'latitude', $this->latitude])
            ->andFilterWhere(['like', 'longitude', $this->longitude])
           // ->andFilterWhere(['like', 'url', $this->url])
            ->andFilterWhere(['like', 'user_agent', $this->user_agent]);

        return $dataProvider;
    }
}
