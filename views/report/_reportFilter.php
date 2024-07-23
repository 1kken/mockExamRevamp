<?php
use yii\bootstrap5\Html;
/** @var $regions array */
?>


        <div class="row">
            <div class="mb-3 col">
                <label for="region" class="form-label">Region</label>
                <?= Html::dropDownList('region', null, $regions, ['id' => 'region', 'prompt' => 'Select Region', 'class' => 'form-select']); ?>
            </div>
            <div class="mb-3 col">
                <label for="province" class="form-label">Province</label>
                <?= Html::dropDownList('province', null, [], ['id' => 'province', 'prompt' => 'Select Province', 'class' => 'form-select', 'disabled' => true]); ?>
            </div>
            <div class="mb-3 col">
                <label for="citymun" class="form-label">City/Municipality</label>
                <?= Html::dropDownList('citymun', null, [], ['id' => 'citymun', 'prompt' => 'Select City/Municipality', 'class' => 'form-select', 'disabled' => true]); ?>
            </div>
        </div>
