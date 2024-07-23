<?php

use kartik\depdrop\DepDrop;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap5\ActiveForm;
use kartik\datecontrol\DateControl;

/** @var yii\web\View $this */
/** @var app\models\Person $model */
/** @var yii\bootstrap5\ActiveForm $form */
?>

<div class="person-form">

    <?php $form = ActiveForm::begin(
        [
            'options'=>['class'=>'container']
        ]
    ); ?>
    <div class="row">
        <div class="col">
            <?= $form->field($model, 'first_name')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col">
            <?= $form->field($model, 'last_name')->textInput(['maxlength' => true]) ?>
        </div>

        <div class="col">
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
    </div>

    <div class="row">
        <div class="col-4">
            <label for="age" class="form-label">Age</label>
            <input type="number" class="form-control" id="age" disabled>
        </div>
        <div class="col-4">
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
    <div class="row">
        <div class="col">
            <?= $form->field($model, 'contact_info')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col">
            <?= $form->field($model,'status')->dropDownList($model->getStatusList(),['prompt'=>'Select Status'])?>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>


<?php
    $js = <<<JS

    function getAge(dob){
        let today = new Date();
        let age = today.getFullYear() - dob.getFullYear();
        let m = today.getMonth() - dob.getMonth();
        if (m < 0 || (m === 0 && today.getDate() < dob.getDate())) {
            age--;
        }
        return age;
    }
    $('#person-birthdate-disp').change(function(){
        $('#age').val(getAge(new Date($('#person-birthdate-disp').val())));
    });
    
    if($('#person-birthdate-disp').val() != ''){
        $('#age').val(getAge(new Date($('#person-birthdate-disp').val())));
    }
JS;

    $this->registerJs($js);

?>
