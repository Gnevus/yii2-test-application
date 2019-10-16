<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Manufactures;

/**
 * ManufacturesSearch represents the model behind the search form of `app\models\Manufactures`.
 */
class ManufacturesSearch extends Manufactures
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['manufacture_id', 'manufacture_town'], 'integer'],
            [['manufacture_name'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
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
        $query = Manufactures::find();

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

        if (!empty($params['manufacture_region']) && empty($params['manufacture_town'])) {
            $towns = Towns::find()
                ->asArray()
                ->where(['town_region' => $params['manufacture_region']])
                ->all();

            $towns = array_column($towns, 'town_id');

            $query->andFilterWhere(['IN', 'manufacture_town', $towns]);
        } elseif (!empty($params['manufacture_town'])) {
            $query->andFilterWhere([
                'manufacture_town' => $params['manufacture_town'],
            ]);
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'manufacture_id' => $this->manufacture_id,
            'manufacture_town' => $this->manufacture_town,
        ]);

        $query->andFilterWhere(['like', 'manufacture_name', $this->manufacture_name]);

        return $dataProvider;
    }
}
