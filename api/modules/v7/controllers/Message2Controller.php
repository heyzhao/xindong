<?php

namespace api\modules\v7\controllers;

use Yii;
use yii\db\Query;
use yii\data\ActiveDataProvider;
use yii\helpers\Response;
use yii\rest\ActiveController;

class Message2Controller extends ActiveController
{

    public $modelClass = 'api\modules\v7\models\Message';
    public $serializer = [
        'class' =>  'yii\rest\Serializer',
        'collectionEnvelope'    =>  'item',
    ];

    public function behaviors()
    {
        return parent::behaviors(); // TODO: Change the autogenerated stub
    }

    public function actions()
    {
        $action =  parent::actions(); // TODO: Change the autogenerated stub
        unset($action['index'],$action['view'],$action['create'],$action['update'],$action['delete']);
        return $action;
    }

    //获取帖子历史消息
    public function actionIndex(){

        $uid = isset($_GET['uid'])?$_GET['uid']:'';

        if(!$uid){
            Response::show('201','操作失败','参数不全');
        }

        $model = new $this->modelClass;
        $query = $model::find()
            ->join('left join','{{%app_words}} as w','pre_app_message.words_id=w.id')
            ->where(" to_id = {$uid} and from_id <> {$uid}  and is_read = 0 or (w.user_id={$uid} and to_id <> {$uid} and from_id <> {$uid})");
            //->orwhere("w.user_id={$uid}");
        return new ActiveDataProvider([
            'query' => $query,
            'pagination'    =>  [
                'pagesize'  =>  15,
            ],
            'sort'  =>  [
                'defaultOrder'  =>  [
                    'id'    =>  SORT_DESC,
                    'created_at'    =>  SORT_DESC,
                ]
            ],
        ]);
    }

    //标记多条为已读消息
    public function actionUpdate($id){

        return '没有该操作';
    }

    //删除单条历史记录
    public function actionDelete($id){

        $info = (new Query())->select('id')->from('{{%app_message}}')->where(['id'=>$id])->one();
        if(!$info){
            Response::show('201','操作失败','该消息不存在');
        }

        $res = Yii::$app->db->createCommand("delete from  pre_app_message where id = {$id}")->execute();
        if($res){
            //删除消息推送
            Yii::$app->db->createCommand("delete from pre_app_push where message_id = {$id}")->execute();

            Response::show('200','操作成功','消息通知已删除');
        }
        Response::show('202','操作失败','消息通知删除失败');
    }

    protected function findModel($id)
    {
        $modelClass = $this->modelClass;
        if (($model = $modelClass::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}