<?php

namespace app\controllers;

use app\models\Tblprovince;
use Yii;
use yii\helpers\Json;

class ProvinceController extends \yii\web\Controller
{
    public function actionProvince(){
        $out = [];
        if (isset($_POST['depdrop_parents'])) {
            Yii::warning('Here');
            $parents = $_POST['depdrop_parents'];
            if ($parents != null) {
                $region_c = $parents[0];
                $out = Tblprovince::getProvinces($region_c);
                return Json::encode(['output'=>$out,'selected'=>'']);
            }
        }
        return Json::encode(['output'=>$out,'selected'=>'']);
    }
}
