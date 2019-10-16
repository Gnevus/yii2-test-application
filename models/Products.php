<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "products".
 *
 * @property int $product_id
 * @property string $product_name
 * @property int $product_manufacture
 * @property string $product_date
 */
class Products extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'products';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['product_name', 'product_manufacture'], 'required'],
            [['product_name'], 'string'],
            [['product_manufacture'], 'integer'],
            [['product_date'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'product_id' => 'Product ID',
            'product_name' => 'Product Name',
            'product_manufacture' => 'Product Manufacture',
            'product_date' => 'Product Date',
        ];
    }
}
