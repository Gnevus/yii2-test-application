<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "towns".
 *
 * @property int $town_id
 * @property string $town_name
 * @property int $town_region
 */
class Towns extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'towns';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['town_name'], 'required'],
            [['town_region'], 'integer'],
            [['town_name'], 'string', 'max' => 52],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'town_id' => 'Town ID',
            'town_name' => 'Town Name',
            'town_region' => 'Town Region',
        ];
    }

    public function getRegions()
    {
        return $this->hasOne(Regions::className(), ['region_id' => 'town_id']);
    }
}
