<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Products;

/**
 * ProductsSearch represents the model behind the search form of `app\models\Products`.
 */
class ProductsSearch extends Products
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['product_id', 'product_manufacture', 'product_date'], 'integer'],
            [['product_name'], 'safe'],
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
        $query = Products::find();

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
        if (!empty($params['product_category'])) {
            $products = ProductCategories::find()
                ->asArray()
                ->where(['pc_category_id' => $params['product_category']])
                ->all();
            $products = array_column($products, 'pc_product_id');

            $query->andFilterWhere(['IN', 'product_id', $products]);
        }

        $query->andFilterWhere([
            'product_id' => $this->product_id,
            'product_manufacture' => $this->product_manufacture,
            'product_date' => $this->product_date,
        ]);

        $query->andFilterWhere(['like', 'product_name', $this->product_name]);

        return $dataProvider;
    }
}
