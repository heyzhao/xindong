<?php

namespace backend\modules\bgadmin\models;

use backend\components\Uploader;
use Yii;

/**
 * This is the model class for table "pre_bgadmin_member_text".
 *
 * @property integer $text_id
 * @property integer $member_id
 * @property string $content
 * @property string $updated_at
 * @property string $time
 * @property string $created_at
 * @property string $created_by
 * @property integer $type
 *
 * @property BgadminMember $member
 * @property BgadminMemberFiles $memberFiles
 */
class BgadminMemberText extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pre_bgadmin_member_text';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['member_id', 'type'], 'required'],
            [['member_id', 'type'], 'integer'],
            [['content'], 'string', 'max' => 256],
            [['updated_at', 'time', 'created_at', 'created_by'], 'string', 'max' => 11]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'text_id' => 'Text ID',
            'member_id' => 'Member ID',
            'content' => '活动描述',
            'updated_at' => 'Updated At',
            'time' => '活动时间',
            'created_at' => 'Created At',
            'created_by' => '创建人',
            'type' => '记录类型',
        ];
    }

    /**
     * @inheritdoc
     */

    public function beforeSave($insert)
    {

        if(parent::beforeSave($insert)){

            if($this->isNewRecord){

                $this->created_at = time();
                $this->updated_at = time();
                $this->created_by = Yii::$app->user->identity->username;

            }else{

                $this->updated_at = time();
            }

            return true;
        }

        return false;
    }

    /**
     * 处理图片的上传
     */
    public function upload()
    {
        $config = [
            'savePath' => Yii::getAlias('@backend').'/web/uploads/bgadmin/'.$this->type.'/', //存储文件夹
            'maxSize' => 4096 ,//允许的文件最大尺寸，单位KB
            'allowFiles' => ['.gif' , '.png' , '.jpg' , '.jpeg' , '.bmp'],  //允许的文件格式
        ];
        $up = new Uploader("file", $config, 'bgadmin_'.$this->text_id);

        $save_path =  Yii::getAlias('@web/uploads/bgadmin/'.$this->type.'/');
        $info = $up->getFileInfo();

        //存入数据库
        $model = new BgadminMemberFiles();
        $model->text_id = $this->text_id;
        $model->member_id = $this->member_id;
        $model->path = $save_path . $info['name'];
        $model->content = $this->content;
        $model->created_by = Yii::$app->user->identity->username;
        $model->img_type = $this->type;
        $model->save();

        return $model;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMember()
    {
        return $this->hasOne(BgadminMember::className(), ['member_id' => 'member_id']);
    }    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMemberFiles()
    {
        return $this->hasMany(BgadminMemberFiles::className(), ['text_id' => 'text_id']);
    }
}
