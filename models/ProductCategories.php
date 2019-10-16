<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "product_categories".
 *
 * @property int $id
 * @property int $pc_product_id
 * @property int $pc_category_id
 */
class ProductCategories extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'product_categories';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['pc_product_id', 'pc_category_id'], 'required'],
            [['pc_product_id', 'pc_category_id'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'pc_product_id' => 'Pc Product ID',
            'pc_category_id' => 'Pc Category ID',
        ];
    }
}
