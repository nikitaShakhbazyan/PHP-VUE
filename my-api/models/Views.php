<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "views".
 *
 * @property int $id
 * @property int|null $count
 * @property int|null $website_views
 * @property int|null $time_spent
 * @property int|null $btn_clicked
 * @property string|null $OS
 * @property string|null $IP
 */
class Views extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'views';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['count', 'website_views', 'time_spent', 'btn_clicked'], 'integer'],
            [['OS', 'IP'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'count' => 'Count',
            'website_views' => 'Website Views',
            'time_spent' => 'Time Spent',
            'btn_clicked' => 'Button Clicked',
            'OS' => 'Operating System',
            'IP' => 'IP Address',
        ];
    }
}
