<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "regions".
 *
 * @property int $region_id
 * @property string $region_name
 *
 * @property Towns[] $towns
 */
class Regions extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'regions';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['region_name'], 'required'],
            [['region_name'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'region_id' => 'Region ID',
            'region_name' => 'Region Name',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTowns()
    {
        return $this->hasMany(Towns::className(), ['town_region' => 'region_id']);
    }
}
