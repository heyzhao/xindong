<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\WeeklyCommentSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="weekly-comment-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'weekly_id') ?>

    <?= $form->field($model, 'created_at') ?>

    <?= $form->field($model, 'user_id') ?>

    <?= $form->field($model, 'content') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'likes') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
