<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\TAvaibilityTemplate;

/**
 * TAvaibilityTemplateSearch represents the model behind the search form about `common\models\TAvaibilityTemplate`.
 */
class TAvaibilityTemplateSearch extends TAvaibilityTemplate
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'id_company', 'senin', 'selasa', 'rabu', 'kamis', 'jumat', 'sabtu', 'minggu'], 'integer'],
            [['datetime'], 'safe'],
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
        $query = TAvaibilityTemplate::find();

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
            'id_company' => $this->id_company,
            'senin' => $this->senin,
            'selasa' => $this->selasa,
            'rabu' => $this->rabu,
            'kamis' => $this->kamis,
            'jumat' => $this->jumat,
            'sabtu' => $this->sabtu,
            'minggu' => $this->minggu,
            'datetime' => $this->datetime,
        ]);

        return $dataProvider;
    }
}
