<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/2/22
 * Time: 13:51
 */

namespace api\modules\v10\controllers;

use Yii;
use yii\db\Query;
use yii\myhelper\Decode;
use yii\myhelper\Response;
use yii\rest\Controller;

class CellphoneController extends Controller
{


    public $modelClass = 'api\modules\v5\models\User';

    public function behaviors()
    {
        return parent::behaviors(); // TODO: Change the autogenerated stub
    }

    public function actions()
    {
        $actions = parent::actions();
        unset($actions['index'],$actions['update'],$actions['view'],$actions['create'],$actions['delete']);
        return $actions;
    }

    public function actionUpdate($id){

        $decode = new Decode();
        if(!$decode->decodeDigit($id)){
            Response::show(210,'参数不正确');
        }
        $model = new $this->modelClass();
        $model->load(\Yii::$app->getRequest()->getBodyParams(),'');

        if($model->email){
            $is_email = preg_match('/([a-z0-9]*[-_.]?[a-z0-9]+)*@([a-z0-9]*[-_]?[a-z0-9]+)+[.][a-z]{2,3}([.][a-z]{2})?/i',$model->email);
            if(!$is_email){
                Response::show('201','邮箱格式不正确');
            }
            $onlyEmail = (new Query())->select('email')->from('{{%user}}')->where(['email'=>$model->email])->one();
            if($onlyEmail['email']){
                Response::show('201','该邮箱已存在');
            }
            $res = (new Query())->select('email')->from('{{%user}}')->where(['id'=>$id])->one();
            if(!$res['email']){
                $res2 = Yii::$app->db->createCommand("update pre_user set email = '{$model->email}' where id = {$id}")->execute();
                if(!$res2){
                    Response::show('201','邮箱更改失败');
                }
                Response::show('200','邮箱修改成功');
            }else{
                Response::show('201','邮箱不能修改');
            }

        }

        if($model->cellphone){
            if(!preg_match('/^[1][34578][0-9]{9}$/',$model->cellphone)){
                Response::show('201','手机格式不正确');
            }
            $res = (new Query())->select('cellphone')->from('{{%user}}')->where(['id'=>$id])->one();
            //验证手机号的唯一性
            $only = (new Query())->select('cellphone')->from('{{%user}}')->where(['cellphone'=>$model->cellphone])->one();
            if($only['cellphone']){
                Response::show('201','该号码已经存在');
            }

            if(!$res['cellphone']){

                $res1 = Yii::$app->db->createCommand("update pre_user set cellphone = {$model->cellphone} where id = {$id}")->execute();
                if($res1){
                    Response::show('200','号码修改成功');
                }
                Response::show('201','号码修改失败');
            }else{
                Response::show('201','不能修改号码');
            }
        }
    }
}