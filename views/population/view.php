<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\Population $model */

$this->title = $model->regionC->region_m.', '.$model->provinceC->province_m.', '.$model->citymun->citymun_m;
$this->params['breadcrumbs'][] = ['label' => 'Populations', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="population-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            [
                    'attribute'=>'Region',
                    'value'=>$model->regionC->region_m
            ],
            [
                    'attribute'=>'Province',
                    'value'=>$model->provinceC->province_m
            ],
            [
                    'attribute'=>'City/Municipality',
                    'value'=>$model->citymun->citymun_m
            ],
            [
                    'attribute'=>'Population',
                    'value'=>$model->population_count
            ]

        ],
    ]) ?>

</div>
