<?php

use app\models\Population;
use kartik\icons\Icon;
use yii\bootstrap5\Modal;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\PopulationSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Populations';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="population-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="d-flex">
        <?php
        Modal::begin([
            'title' => '<h2>Hello world</h2>',
            'toggleButton' => ['label' => 'Filters '.Icon::show('filter'),'class'=>'btn btn-primary','style'=>'height: 40px'],
        ]);

        echo $this->render('_search', ['model' => $searchModel]);

        Modal::end();
        ?>

        <p>
            <?= Html::a('Create Population', ['create'], ['class' => 'btn btn-success ms-2']) ?>
        </p>
    </div>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
//        'filterModel' => $searchModel,
        'columns' => [
                [
                        'attribute' => 'region_c',
                        'value' => function (Population $model) {
                            return Html::encode(ucfirst($model->regionC->region_m));
                        }
                ],
                [
                        'attribute' => 'province_c',
                        'value' => function (Population $model) {
                            return Html::encode(ucfirst($model->provinceC->province_m));
                        }
                ],
                [
                        'attribute' => 'citymun_id',
                        'value' => function (Population $model) {
                            return Html::encode(ucfirst($model->citymun->citymun_m));
                        }
                ],
            'population_count',
            [
                'class' => ActionColumn::class,
                'urlCreator' => function ($action, Population $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>


</div>
