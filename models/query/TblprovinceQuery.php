<?php

namespace app\models\query;

use Yii;

/**
 * This is the ActiveQuery class for [[\app\models\Tblprovince]].
 *
 * @see \app\models\Tblprovince
 */
class TblprovinceQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return \app\models\Tblprovince[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return \app\models\Tblprovince|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

    public function getProvinces($region_c){
        $params = Yii::$app->user->identity->getParamsJurisdictionProvince();
        return parent::
            andWhere(['region_c'=>$region_c])->
             andWhere($params)
            ->select(['id'=>'province_c','name'=>'province_m'])->asArray()->all();
    }
}
