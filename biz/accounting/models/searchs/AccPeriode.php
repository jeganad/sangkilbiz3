<?php

namespace biz\accounting\models\searchs;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use biz\accounting\models\AccPeriode as AccPeriodeModel;

/**
 * AccPeriode represents the model behind the search form about `biz\accounting\models\AccPeriode`.
 */
class AccPeriode extends AccPeriodeModel
{
    public function rules()
    {
        return [
            [['id_periode', 'status', 'create_by', 'update_by'], 'integer'],
            [['nm_periode', 'date_from', 'date_to', 'create_at', 'update_at'], 'safe'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = AccPeriodeModel::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id_periode' => $this->id_periode,
            'date_from' => $this->date_from,
            'date_to' => $this->date_to,
            'status' => $this->status,
            'create_by' => $this->create_by,
            'update_by' => $this->update_by,
        ]);

        $query->andFilterWhere(['like', 'nm_periode', $this->nm_periode])
            ->andFilterWhere(['like', 'create_at', $this->create_at])
            ->andFilterWhere(['like', 'update_at', $this->update_at]);

        return $dataProvider;
    }
}
