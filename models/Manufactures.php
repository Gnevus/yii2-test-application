<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "manufactures".
 *
 * @property int $manufacture_id
 * @property string $manufacture_name
 * @property int $manufacture_town
 */
class Manufactures extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'manufactures';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['manufacture_name', 'manufacture_town'], 'required'],
            [['manufacture_name'], 'string'],
            [['manufacture_town'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'manufacture_id' => 'Manufacture ID',
            'manufacture_name' => 'Manufacture Name',
            'manufacture_town' => 'Manufacture Town',
        ];
    }
}
