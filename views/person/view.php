<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\icons\Icon;

/** @var yii\web\View $this */
/** @var app\models\Person $model */
$this->params['breadcrumbs'][] = ['label' => 'People', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="person-view">

    <?php
    //name
    $full_name = $model->first_name . ' ' . $model->last_name;
    $this->title = "View: ".$full_name;
    //color of the badge
    $color_for_status = ['primary','success','success','danger','secondary'];
    $status_color = $color_for_status[$model->status];
    //status
    $status_name = [0=>'Under Investigation', 1=>'Surrendered', 2=>'Apprehended', 3=>'Escaped', 4=>'Deceased'];
    $status_name = $status_name[$model->status];
    //Calculate Age
    $birthdate = new DateTime($model->birthdate);
    $now = new DateTime();
    $interval = $birthdate->diff($now);
    $age = $interval->y;
    //Address
    $address = $model->regionC->region_m . ', ' . $model->provinceC->province_m . ', ' . $model->citymun->citymun_m;
    ?>
    <div class="container my-5">
        <div class="card" style="width: 100%;">
            <div class="card-body">
                <h2 class="card-title">Name: <?= Html::encode($full_name) ?> <span class="text-body-secondary">Gender: <?= Html::encode($model->getSex()[$model->sex]) ?></span></h2>
                <h4 class="card-subtitle mb-3 text-body-secondary">Status: <span class="badge bg-<?= Html::encode($status_color) ?>"><?= Html::encode($status_name) ?></span></h4>
                <h5 class="card-subtitle mb-3 text-body-secondary">Birth Date: <?= Html::encode($model->birthdate) ?> Age: <?= Html::encode($age) ?></h5>
                <h5 class="card-subtitle mb-3 text-body-secondary">Contact Number: <?= Html::encode($model->contact_info) ?></h5>
                <p class="card-text">Address: <?= Html::encode($address) ?></p>
                <div class="d-flex flex-shrink-1">
                    <a class="btn btn-success p-3 me-3" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Edit" href="<?= Url::to(['/person/update', 'id' => $model->id]) ?>" role="button"><?= Icon::show('pen') ?> Edit</a>
                    <a class="btn btn-danger p-3" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Delete" role="button" href="<?= Url::to(['/person/delete', 'id' => $model->id]) ?>" data-confirm="Are you sure you want to delete this item?" data-method="post"><?= Icon::show('trash') ?> Delete</a>
                </div>
            </div>
        </div>
    </div>

    <?php
    $script = <<< JS
    $(function () {
        $('[data-bs-toggle="tooltip"]').tooltip()
    });
JS;
    $this->registerJs($script);
    ?>

</div>
