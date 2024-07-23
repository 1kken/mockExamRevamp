<?php

use kartik\datecontrol\DateControl;
use kartik\depdrop\DepDrop;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\PersonSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="person-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <div class="container">
        <div class="row">
            <div class="col-auto">
                <?= $form->field($model, 'first_name')->textInput(['maxlength' => true]) ?>
            </div>
            <div class="col-auto">
                <?= $form->field($model, 'last_name')->textInput(['maxlength' => true]) ?>
            </div>

            <div class="col-auto">
                <?= $form->field($model, 'birthdate')->widget(DateControl::classname(), [
                    'type' => 'date',
                    'ajaxConversion' => true,
                    'autoWidget' => true,
                    'displayFormat' => 'php:F-d-Y',
                    'saveFormat' => 'php:Y-m-d',
                    'saveTimezone' => 'UTC',
                    'displayTimezone' => 'Asia/Kolkata',
                ]); ?>
            </div>

            <div class="col-12 col-md-3 co-lg-3">
                <?= $form->field($model,'sex')->dropDownList($model->getSex(),['prompt'=>'Select Sex'])?>
            </div>
        </div>

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
                if (!empty($model->province_c) && !empty($model->provinceC) && !empty($model->citymun)){
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
            <div class="col">
                <?php
                $data = [];
                if (!empty($model->province_c) && !empty($model->provinceC)){
                    $data = [$model->district_c=>$model->district_c];
                }
                ?>
                <?= $form->field($model, 'district_c')->widget(DepDrop::class, [
                    'data'=>$data,
                    'options'=>['id'=>'district'],
                    'pluginOptions'=>[
                        'depends'=>['region','province','citymun'],
                        'placeholder'=>'Select district',
                        'url'=>Url::to(['/city-mun/district'])
                    ]]);?>
            </div>
        </div>
        <div class="form-group">
            <?= Html::submitButton('Search', ['class' => 'btn btn-primary ']) ?>
            <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
        </div>
    </div>


    <?php ActiveForm::end(); ?>

</div>
<?php
$person_index = Url::to(['person/index']);
$js = <<<JS
//get reset button
$('button[type="reset"]').on('click',function(){
    window.location = '$person_index';
});
JS;
$this->registerJs($js);
?>
