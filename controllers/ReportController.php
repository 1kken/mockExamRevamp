<?php

namespace app\controllers;

use Yii;
use app\models\Person;
use app\models\Tblcitymun;
use app\models\Tblprovince;
use app\models\Tblregion;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\web\Response;

class ReportController extends \yii\web\Controller
{
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),[
            'access'=>[
                'class'=>AccessControl::class,
                'rules'=>[
                    [
                        'allow'=>true,
                        'roles'=>['admin','manageProvince','manageRegion','manageCityMun']
                    ],
        ]]]);
    }
    public function actionChart()
    {
        return $this->render('chart',['regions'=>$this->getRegions()]);
    }

    public function actionTable()
    {
        return $this->render('table',['regions'=>$this->getRegions()]);
    }



    public function actionProvince($region){
        Yii::$app->response->format = Response::FORMAT_JSON;
        return $this->getProvince($region);
    }

    public function actionCity($region,$province){
        Yii::$app->response->format = Response::FORMAT_JSON;
        return $this->getCityMun($region,$province);
    }

    function getRegions(){
        $regions = TblRegion::find()->all();
        return ArrayHelper::map($regions, 'region_c', 'region_m');
    }

    function getProvince($region){
        $province = TblProvince::find()->where(['region_c'=>$region])->all();
        return ArrayHelper::map($province, 'province_c', 'province_m');
    }
    private array $colorByStatus = [
        'Under Investigation' => '#607D8B', // Darker blue-gray
        'Surrendered' => '#66BB6A', // Darker green
        'Apprehended' => '#42A5F5', // Darker blue
        'Escaped' => '#FFD54F', // Darker yellow
        'Deceased' => '#EC407A'  // Darker pink
    ];

    function getCityMun($region,$province){
        $citymun = Tblcitymun::find()
            ->andWhere(['region_c'=>$region])
            ->andWhere(['province_c'=>$province])
            ->orderBy(['citymun_m'=>SORT_ASC])
            ->all();

        return ArrayHelper::map($citymun,'citymun_id','citymun_m');
    }
    //color by status
    public function actionChartone($region = null,$province= null,$citymun = null){
        $params = [];
        if(isset($region)){
            if(trim($region)!=''){
                $params += ['region_c'=>$region];
            }
        }
        if(isset($province)){
            if(trim($province)!=''){
                $params += ['province_c'=>$province];
            }
        }
        if(isset($citymun)){
            if(trim($citymun)!=''){
                $params += ['citymun_id'=>$citymun];
            }
        }

        // Step 1: Fetch status counts
        $statusCounts = Person::find()
            ->getGroupedStatusCount()
            ->andWhere($params)
            ->groupBy('person.status') // Group by status to count each status separately
            ->asArray()
            ->all();

        $chartData = [
            'name' => 'Status',
            'colorByPoint' => false,
            'data' => []
        ];
        foreach ($statusCounts as $status) {
            $chartData['data'][] = [
                'name' => $status['status_text'],
                'y' => (int) $status['count'], // Use the count from statusCounts
                'color' => $this->colorByStatus[$status['status_text']], // Use the color from 'colorByStatus
                'drilldown' => $status['status_text'] // Assuming you want to use status_text as drilldown
            ];
        }
        return Json::encode($chartData);
    }

    function actionCharttwo($region = null,$province= null,$citymun = null){
        $params = [];
        if(isset($region)){
            if(trim($region)!=''){
                $params += ['region_c'=>$region];
            }
        }
        if(isset($province)){
            if(trim($province)!=''){
                $params += ['province_c'=>$province];
            }
        }
        if(isset($citymun)){
            if(trim($citymun)!=''){
                $params += ['citymun_id'=>$citymun];
            }
        }

        $population = Person::getPopulation($params)->count();

        // Step 1: Fetch status counts
        $statusCounts = Person::find()
            ->getGroupedStatusCount()
            ->andWhere($params)
            ->groupBy('person.status') // Group by status to count each status separately
            ->asArray()
            ->all();
        $chartData = [];
        foreach ($statusCounts as $status) {
            $chartData[] = ['name'=>$status['status_text'],'y'=>(float) ($status['count']/$population)*100,'color'=>$this->colorByStatus[$status['status_text']]];
        }
        return Json::encode($chartData);
    }

    function actionChartthree($region=null,$province=null,$citymun=null){
        $params = [];
        if(isset($region)){
            if(trim($region)!=''){
                $params += ['region_c'=>$region];
            }
        }
        if(isset($province)){
            if(trim($province)!=''){
                $params += ['province_c'=>$province];
            }
        }
        if(isset($citymun)){
            if(trim($citymun)!=''){
                $params += ['citymun_id'=>$citymun];
            }
        }

        // Define age groups
        $ageGroups = [
            '0-12' => [0, 12],
            '13-18' => [13, 18],
            '19-25' => [19, 25],
            '26-35' => [26, 35],
            '36-50' => [36, 50],
            '51-65' => [51, 65],
            '65-Above' => [66, 120]
        ];

        $status = [0,1,2,3,4];
        $stats = ['Under Investigation','Surrendered','Apprehended','Escaped','Deceased'];

        $result=[];
        foreach ($status as $stats_idx){
            $inner_result =[ 'name' => $stats[$stats_idx], 'data' => [],'color'=>$this->colorByStatus[$stats[$stats_idx]]];
            foreach ($ageGroups as $label=>$range){
                $statusCounts = Person::getStatusCountsByAge($range,$params,$stats_idx);
                $inner_result['data'][] = $statusCounts[0]['count'];
            }
            $result[] = $inner_result;
        }

        return Json::encode($result);


    }
}
