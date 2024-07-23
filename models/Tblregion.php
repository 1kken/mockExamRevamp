<?php

namespace app\models;

use app\models\query\PersonQuery;
use app\models\query\TblregionQuery;

/**
 * This is the model class for table "tblregion".
 *
 * @property string $region_c
 * @property string $region_m
 * @property string $abbreviation
 * @property int|null $region_sort
 *
 * @property Jurisdiction[] $jurisdictions
 * @property Person[] $people
 * @property Tblcitymun[] $tblcitymuns
 */
class Tblregion extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tblregion';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['region_c', 'region_m', 'abbreviation'], 'required'],
            [['region_sort'], 'integer'],
            [['region_c'], 'string', 'max' => 2],
            [['region_m', 'abbreviation'], 'string', 'max' => 200],
            [['region_c'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'region_c' => 'Region C',
            'region_m' => 'Region M',
            'abbreviation' => 'Abbreviation',
            'region_sort' => 'Region Sort',
        ];
    }

    /**
     * Gets query for [[Jurisdictions]].
     *
     * @return \yii\db\ActiveQuery|JurisdictionQuery
     */
    public function getJurisdictions()
    {
        return $this->hasMany(Jurisdiction::class, ['region_c' => 'region_c']);
    }

    /**
     * Gets query for [[People]].
     *
     * @return \yii\db\ActiveQuery|PersonQuery
     */
    public function getPeople()
    {
        return $this->hasMany(Person::class, ['region_c' => 'region_c']);
    }

    /**
     * Gets query for [[Tblcitymuns]].
     *
     * @return \yii\db\ActiveQuery|TblcitymunQuery
     */
    public function getTblcitymuns()
    {
        return $this->hasMany(Tblcitymun::class, ['region_c' => 'region_c']);
    }

    /**
     * {@inheritdoc}
     * @return TblregionQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new TblregionQuery(get_called_class());
    }
}
