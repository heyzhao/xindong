<?php

namespace backend\modules\dating\models;

use Yii;

/**
 * This is the model class for table "pre_dating_signup_weichat".
 *
 * @property integer $id
 * @property string $openid
 * @property string $number
 * @property integer $status
 * @property string $like_id
 * @property integer $type
 * @property string $extra
 * @property integer $created_at
 * @property integer $updated_at
 */
class DatingSignupWeichat extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pre_dating_signup_weichat';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['openid', 'number', 'status', 'like_id', 'extra', 'created_at', 'updated_at'], 'required'],
            [['status', 'type', 'created_at', 'updated_at'], 'integer'],
            [['extra'], 'string'],
            [['openid', 'like_id'], 'string', 'max' => 50],
            [['number'], 'string', 'max' => 256]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'openid' => 'Openid',
            'number' => 'Number',
            'status' => 'Status',
            'like_id' => 'Like ID',
            'type' => 'Type',
            'extra' => 'Extra',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
