<?php

use kartik\depdrop\DepDrop;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Population $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="population-form">

    <?php $form = ActiveForm::begin(); ?>
    <div class="container">
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
            <?= $form->field($model, 'population_count')->textInput(['disabled'=>true]) ?>
        </div>
</div>



    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success','id'=>'submit','disabled'=>true]) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php
$js = <<<JS
//if all drop down has values enable the population count
$('#region, #province, #citymun').on('change', function() {
    //regex for digits
    let regex = /^[0-9]+$/;
    //get the values of the drop down
    let region = $('#region').val();
    let province = $('#province').val();
    let citymun = $('#citymun').val();
   //check teh values if within regex
    if (regex.test(region) && regex.test(province) && regex.test(citymun)) {
        //enable the population count
        $('#population-population_count').prop('disabled', false);
    } else {
        //disable the population count
        $('#population-population_count').prop('disabled', true);
    }
});

//if population count has some value enable button
$('#population-population_count').on('input', function() {
    //get the value of the population count
    let populationCount = $(this).val();
    //check if the value is not empty
    if (populationCount !== '') {
        //enable the button
        $('button[type="submit"]').prop('disabled', false);
    } else {
        //disable the button
        $('button[type="submit"]').prop('disabled', true);
    }
});



JS;

$this->registerJs($js);

?>
