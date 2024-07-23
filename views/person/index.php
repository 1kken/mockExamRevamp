<?php

use kartik\icons\Icon;
use yii\bootstrap5\Modal;
use yii\helpers\Html;
use yii\widgets\ListView;

/** @var yii\web\View $this */
/** @var app\models\PersonSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Person Preview';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="person-index">

    <h1 class=""><?= Html::encode($this->title) ?></h1>
    <?php
    Modal::begin([
        'title' => '<h2>Hello world</h2>',
        'toggleButton' => ['label' => 'Filters '.Icon::show('filter'),'class'=>'btn btn-primary'],
    ]);

    echo $this->render('_search', ['model' => $searchModel]);

    Modal::end();
    ?>
        <?= ListView::widget([
            'dataProvider' => $dataProvider,
            'itemOptions' => ['class' => 'item col'],
            'itemView' => '_personItem',
            'options'=>['class'=>'row']
        ]) ?>
</div>


