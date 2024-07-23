<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "population".
 *
 * @property int $id
 * @property string $region_c
 * @property string $province_c
 * @property int $citymun_id
 * @property int|null $population_count
 *
 * @property Tblcitymun $citymun
 * @property Tblprovince $provinceC
 * @property Tblregion $regionC
 */
class Population extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'population';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['region_c', 'province_c', 'citymun_id'], 'required'],
            [['citymun_id'], 'integer'],
            [['population_count'],'integer','min'=>1],
            [['region_c', 'province_c'], 'string', 'max' => 2],
            [['citymun_id'], 'exist', 'skipOnError' => true, 'targetClass' => Tblcitymun::class, 'targetAttribute' => ['citymun_id' => 'citymun_id']],
            [['province_c'], 'exist', 'skipOnError' => true, 'targetClass' => Tblprovince::class, 'targetAttribute' => ['province_c' => 'province_c']],
            [['region_c'], 'exist', 'skipOnError' => true, 'targetClass' => Tblregion::class, 'targetAttribute' => ['region_c' => 'region_c']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'region_c' => 'Region',
            'province_c' => 'Province',
            'citymun_id' => 'City/Municipality',
            'population_count' => 'Population Count',
        ];
    }

    /**
     * Gets query for [[Citymun]].
     *
     * @return \yii\db\ActiveQuery|\app\models\query\TblcitymunQuery
     */
    public function getCitymun()
    {
        return $this->hasOne(Tblcitymun::class, ['citymun_id' => 'citymun_id']);
    }

    /**
     * Gets query for [[ProvinceC]].
     *
     * @return \yii\db\ActiveQuery|\app\models\query\TblprovinceQuery
     */
    public function getProvinceC()
    {
        return $this->hasOne(Tblprovince::class, ['province_c' => 'province_c']);
    }

    /**
     * Gets query for [[RegionC]].
     *
     * @return \yii\db\ActiveQuery|\app\models\query\TblregionQuery
     */
    public function getRegionC()
    {
        return $this->hasOne(Tblregion::class, ['region_c' => 'region_c']);
    }

    public function getRegions(){
        $params = Yii::$app->user->identity->getParamsJurisdictionRegion();
        $regions = Tblregion::find()
            ->select(['region_c','region_m'])
            ->andWhere($params)
            ->all();
        return ArrayHelper::map($regions,'region_c','region_m');
    }

    /**
     * {@inheritdoc}
     * @return \app\models\query\PopulationQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\query\PopulationQuery(get_called_class());
    }
}
