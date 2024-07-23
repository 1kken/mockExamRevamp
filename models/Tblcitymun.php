<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tblcitymun".
 *
 * @property int $citymun_id
 * @property string $region_c
 * @property string $province_c
 * @property string $district_c
 * @property string $citymun_c
 * @property string $citymun_m
 * @property string $lgu_type
 * @property string $income
 *
 * @property Jurisdiction[] $jurisdictions
 * @property Person[] $people
 * @property Tblprovince $provinceC
 * @property Tblregion $regionC
 */
class Tblcitymun extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tblcitymun';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['region_c', 'province_c', 'district_c', 'citymun_c', 'citymun_m', 'lgu_type', 'income'], 'required'],
            [['region_c', 'province_c', 'citymun_c'], 'string', 'max' => 2],
            [['district_c', 'lgu_type'], 'string', 'max' => 3],
            [['citymun_m'], 'string', 'max' => 200],
            [['income'], 'string', 'max' => 20],
            [['region_c'], 'exist', 'skipOnError' => true, 'targetClass' => Tblregion::class, 'targetAttribute' => ['region_c' => 'region_c']],
            [['province_c'], 'exist', 'skipOnError' => true, 'targetClass' => Tblprovince::class, 'targetAttribute' => ['province_c' => 'province_c']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'citymun_id' => 'Citymun ID',
            'region_c' => 'Region C',
            'province_c' => 'Province C',
            'district_c' => 'District C',
            'citymun_c' => 'Citymun C',
            'citymun_m' => 'Citymun M',
            'lgu_type' => 'Lgu Type',
            'income' => 'Income',
        ];
    }

    /**
     * Gets query for [[Jurisdictions]].
     *
     * @return \yii\db\ActiveQuery|\app\models\query\JurisdictionQuery
     */
    public function getJurisdictions()
    {
        return $this->hasMany(Jurisdiction::class, ['citymun_id' => 'citymun_id']);
    }

    /**
     * Gets query for [[People]].
     *
     * @return \yii\db\ActiveQuery|\app\models\query\PersonQuery
     */
    public function getPeople()
    {
        return $this->hasMany(Person::class, ['citymun_id' => 'citymun_id']);
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

    /**
     * {@inheritdoc}
     * @return \app\models\query\TblcitymunQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\query\TblcitymunQuery(get_called_class());
    }

    //helper functions
    public static function getCities($region,$province){
        return self::find()->getCitiesForDepDrop($region,$province);
    }

    public static function getDistrict($region,$province,$city){
        return self::find()->getDistrictForDepDrop($region,$province,$city);
    }
}
