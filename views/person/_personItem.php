<?php
use app\models\Person;
/** @var Person $model */

use kartik\icons\Icon;
use yii\helpers\Html;
use yii\helpers\Url;
?>
<?php
//name
$full_name = $model->first_name . ' ' . $model->last_name;
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
<div class="card mb-2" style="width: 18rem; min-height:300px;">
    <div class="card-body">
        <h5 class="card-title">Name: <?= Html::encode(ucwords($full_name)) ?></h5>
        <h6 class="card-subtitle mb-2 text-body-secondary">Status: <span class="badge bg-<?= $status_color ?>"><?= Html::encode(ucwords($status_name)) ?></span></h6>
        <h6 class="card-subtitle mb-2 text-body-secondary fs-6">Birth Date: <?= $model->birthdate ?> Age: <?= $age ?> </h6>
        <h6 class="card-subtitle mb-2 text-body-secondary fs-6">Contact Number: <?= $model->contact_info ?></h6>
        <p class="card-text">Address: <?= $address ?></p>
        <div class="d-flex flex-shrink-1">
            <a class="btn btn-info p-2 me-2" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="View" href=<?= Url::to('/person/view/'.$model->id)?> role="button" aria-disabled="true"><?= Icon::show('eye')?></a>
            <a class="btn btn-success p-2 me-2" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Edit" href=<?= Url::to('/person/update/'.$model->id) ?> role="button" aria-disabled="true"><?= Icon::show('pen')?></a>
            <?=
                Html::a(Icon::show('trash'),
                        '/person/delete/'.$model->id,
                        ['class'=>"btn btn-danger p-2",
                        'data-bs-toggle'=>'tooltip',
                        'data-bs-placement'=>"top",
                        'data-bs-title'=>'Delete',
                        'role'=>'button',
                        'data'=>[
                                'confirm'=>"Delete Person",
                                'method'=>'post'
                        ]])
            ?>
        </div>
    </div>
</div>

<?php
    $js = <<<JS
        const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
        const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))
JS;

    $this->registerJs($js);

?>