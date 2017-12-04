<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\TTrip;
use mdm\admin\components\Helper;
/**
 * TTripSearch represents the model behind the search form about `common\models\TTrip`.
 */
class TTripSearch extends TTrip
{
    public $id_company;
    public $islandRoute;

  //  public $
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'id_boat', 'id_route', 'status', 'id_est_time'], 'integer'],

            [['date', 'dept_time', 'description', 'datetime','id_company','islandRoute'], 'safe'],
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
        if(Helper::checkRoute('/booking/*')){
        $query = TTrip::find()->joinWith('idBoat.idCompany')->select('id_route,id_boat,dept_time,MIN(date) AS minDate,MAX(date) maxDate')->groupBy('id_boat,id_route,dept_time')->orderBy(['t_company.name'=>SORT_ASC]);
        }else{
            $query = TTrip::find()->joinWith(['idBoat.idCompany','idRoute.departureHarbor departure','idRoute.arrivalHarbor as arrival'])->select(['id_route','id_boat','dept_time,MIN(date) AS minDate','MAX(date) maxDate','CONCAT( departure.id_island, "-", arrival.id_island) as islandRoute'])->where(['t_company.id_user'=>Yii::$app->user->identity->id])->groupBy('islandRoute, dept_time')->orderBy(['islandRoute'=>SORT_ASC,'dept_time'=>SORT_ASC]);
        }
        //$query
        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination'=> ['defaultPageSize' => 10],
            'sort'=>[
                'defaultOrder'=>[
               // 'id_boat'=>SORT_ASC,
                'id_route'=>SORT_ASC,
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
            'id'                => $this->id,
            'id_boat'           => $this->id_boat,
            'id_route'          => $this->id_route,
            'date'              => $this->date,
            'dept_time'         => $this->dept_time,
            'status'            => $this->status,
            'datetime'          => $this->datetime,
            'id_est_time'       => $this->id_est_time,
            't_boat.id_company' => $this->id_company,
        ]);

        $query->andFilterWhere(['like', 'description', $this->description]);

        return $dataProvider;
    }
}
