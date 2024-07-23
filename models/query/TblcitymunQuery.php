<?php

namespace app\models\query;

use Yii;

/**
 * This is the ActiveQuery class for [[\app\models\Tblcitymun]].
 *
 * @see \app\models\Tblcitymun
 */
class TblcitymunQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return \app\models\Tblcitymun[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return \app\models\Tblcitymun|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

    public function getCitiesForDepDrop($region,$province){
        $params = Yii::$app->user->identity->getParamsJurisdictionCityMun();
        return parent::
            andWhere(['region_c'=>$region,'province_c'=>$province])->
            andWhere($params)->
            select(['citymun_id as id','citymun_m as name'])
            ->asArray()
            ->all();

    }

    public function getDistrictForDepDrop($region,$province,$city){
        return parent::select(['district_c as id','district_c as name'])
            ->where(['region_c'=>$region,'province_c'=>$province,'citymun_id'=>$city])
            ->asArray()
            ->all();
    }
}
