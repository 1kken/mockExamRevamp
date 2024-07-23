<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "jurisdiction".
 *
 * @property int $id
 * @property int $user_id
 * @property string|null $region_c
 * @property string|null $province_c
 * @property int|null $citymun_id
 *
 * @property Tblcitymun $citymun
 * @property Tblprovince $provinceC
 * @property Tblregion $regionC
 * @property User $user
 */
class Jurisdiction extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'jurisdiction';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id'], 'required'],
            [['user_id', 'citymun_id'], 'integer'],
            [['region_c', 'province_c'], 'string', 'max' => 2],
            [['citymun_id'], 'exist', 'skipOnError' => true, 'targetClass' => Tblcitymun::class, 'targetAttribute' => ['citymun_id' => 'citymun_id']],
            [['province_c'], 'exist', 'skipOnError' => true, 'targetClass' => Tblprovince::class, 'targetAttribute' => ['province_c' => 'province_c']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
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
            'user_id' => 'User ID',
            'region_c' => 'Region C',
            'province_c' => 'Province C',
            'citymun_id' => 'Citymun ID',
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

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery|\app\models\query\UserQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    /**
     * {@inheritdoc}
     * @return \app\models\query\JurisdictionQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\query\JurisdictionQuery(get_called_class());
    }
}
