<?php

use kartik\depdrop\DepDrop;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\PopulationSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="population-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>


    <div class="col">
        <div class="row">
            <div class="col">
                <?= $form->field($model, 'region_c')->dropDownList($model->getRegions(),['id'=>'region','prompt'=>"Select Region"]); ?>
            </div>
            <div class="col">
                <?php
                $data = [];
                if (!empty($model->province_c) && !empty($model->provinceC)) {
                    $data = [$model->provinceC->province_c => $model->provinceC->province_m];
                }
                ?>
                <?= $form->field($model, 'province_c')->widget(DepDrop::class, [
                    'data'=>$data,
                    'options'=>['id'=>'province'],
                    'pluginOptions'=>[
                        'depends'=>['region'],
                        'placeholder'=>'Select Province',
                        'url'=>Url::to(['/province/province'])
                    ]]);?>
            </div>
            <div class="col">
                <?php
                $data = [];
                if (!empty($model->province_c) && !empty($model->provinceC)){
                    $data = [$model->citymun->citymun_id=>$model->citymun->citymun_m];
                }
                ?>
                <?= $form->field($model, 'citymun_id')->widget(DepDrop::class, [
                    'data'=>$data,
                    'options'=>['id'=>'citymun'],
                    'pluginOptions'=>[
                        'depends'=>['region','province'],
                        'placeholder'=>'Select city/municipality',
                        'url'=>Url::to(['/city-mun/city-mun']),
                    ]]);?>
            </div>

        </div>
    </div>
    <?= $form->field($model, 'population_count') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
