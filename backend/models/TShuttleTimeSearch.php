<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\TShuttleTime;

/**
 * TShuttleTimeSearch represents the model behind the search form about `common\models\TShuttleTime`.
 */
class TShuttleTimeSearch extends TShuttleTime
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'id_company', 'id_route', 'id_area', 'created_at'], 'integer'],
            [['dept_time', 'shuttle_time_start','shuttle_time_end'], 'safe'],
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
        $query = TShuttleTime::find()->joinWith(['idCompany','idRoute','idArea'])->orderBy(['t_company.name'=>SORT_ASC,'t_route.departure'=>SORT_ASC,'t_shuttle_area.area'=>SORT_ASC]);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=>[
                'defaultOrder'=>[
               // 't_company.name'=>SORT_ASC,
                //''
                //'dept_time'=>SORT_ASC
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
            'id' => $this->id,
            'id_company' => $this->id_company,
            'id_route' => $this->id_route,
            'dept_time' => $this->dept_time,
            'id_area' => $this->id_area,
            'created_at' => $this->created_at,
        ]);

        $query->andFilterWhere(['like', 'shuttle_time_start', $this->shuttle_time_start]);
        $query->andFilterWhere(['like', 'shuttle_time_end', $this->shuttle_time_end]);

        return $dataProvider;
    }
}
