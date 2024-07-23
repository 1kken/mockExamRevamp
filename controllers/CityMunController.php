<?php

namespace app\controllers;

use app\models\Tblcitymun;
use yii\helpers\Json;

class CityMunController extends \yii\web\Controller
{
    public function actionCityMun(){
        $out = [];
        if (isset($_POST['depdrop_parents'])) {
            $ids = $_POST['depdrop_parents'];
            $region = empty($ids[0]) ? null : $ids[0];
            $province = empty($ids[1]) ? null : $ids[1];
            if ($region != null) {
                $out = Tblcitymun::getCities($region, $province);
                $out = ['out'=>$out,'selected'=>''];
                return Json::encode(['output'=>$out['out'],'selected'=>$out['selected']]);
            }
        }
        return Json::encode([['output'=>$out,'selected'=>'']]);
    }

    public function actionDistrict(){
        $out = [];
        if (isset($_POST['depdrop_parents'])) {
            $ids = $_POST['depdrop_parents'];
            $region = empty($ids[0]) ? null : $ids[0];
            $province = empty($ids[1]) ? null : $ids[1];
            $city = empty($ids[2]) ? null : $ids[2];
            if ($region != null) {
                $out = Tblcitymun::getDistrict($region, $province,$city);
                $out = ['out'=>$out,'selected'=>''];
                return Json::encode(['output'=>$out['out'],'selected'=>$out['selected']]);
            }
        }
        return Json::encode([['output'=>$out,'selected'=>'']]);
    }
}
