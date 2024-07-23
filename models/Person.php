<?php

namespace app\models;

use app\models\query\PersonQuery;
use app\models\query\TblregionQuery;
use Yii;
use yii\db\ActiveRecord;
use yii\db\Expression;
use yii\debug\models\search\Db;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "person".
 *
 * @property int $id
 * @property string $first_name
 * @property string $last_name
 * @property string $birthdate
 * @property int|null $sex
 * @property string $region_c
 * @property string $province_c
 * @property int $citymun_id
 * @property string $district_c
 * @property string $contact_info
 * @property int $status
 * @property string $date_created
 * @property string|null $date_update
 *
 * @property Tblcitymun $citymun
 * @property Tblprovince $provinceC
 * @property Tblregion $regionC
 */
class Person extends \yii\db\ActiveRecord
{

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'person';
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        //timestamp
        return [
            'timestamp' => [
                'class' => 'yii\behaviors\TimestampBehavior',
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['date_created'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['date_update'],
                ],
                'value' => new \yii\db\Expression('NOW()'),
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['first_name', 'last_name', 'birthdate', 'region_c', 'province_c', 'citymun_id', 'district_c', 'contact_info', 'status'], 'required'],
            [['birthdate', 'date_created', 'date_update'], 'safe'],
            [['sex', 'citymun_id', 'status'], 'integer'],
            [['first_name', 'last_name'], 'string', 'max' => 255],
            [['region_c', 'province_c'], 'string', 'max' => 2],
            [['district_c'], 'string', 'max' => 3],
            [['contact_info'], 'string', 'max' => 11],
            [['contact_info'],'match', 'pattern' => '/^(09|\+639)\d{9}$/'],
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
            'first_name' => 'First Name',
            'last_name' => 'Last Name',
            'birthdate' => 'Birth Date',
            'sex' => 'Sex',
            'region_c' => 'Region',
            'province_c' => 'Province',
            'citymun_id' => 'City/Municipality',
            'district_c' => 'District',
            'contact_info' => 'Contact Info',
            'status' => 'Status',
            'date_created' => 'Date Created',
            'date_update' => 'Date Update',
        ];
    }

    /**
     * Gets query for [[Citymun]].
     *
     * @return \yii\db\ActiveQuery|TblcitymunQuery
     */
    public function getCitymun()
    {
        return $this->hasOne(Tblcitymun::class, ['citymun_id' => 'citymun_id']);
    }

    /**
     * Gets query for [[ProvinceC]].
     *
     * @return \yii\db\ActiveQuery|TblprovinceQuery
     */
    public function getProvinceC()
    {
        return $this->hasOne(Tblprovince::class, ['province_c' => 'province_c']);
    }

    /**
     * Gets query for [[RegionC]].
     *
     * @return \yii\db\ActiveQuery|TblregionQuery
     */
    public function getRegionC()
    {
        return $this->hasOne(Tblregion::class, ['region_c' => 'region_c']);
    }

    /**
     * {@inheritdoc}
     * @return PersonQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new PersonQuery(get_called_class());
    }

    //helper methods
    /**
     * Get the list of regions
     * @return array
     */
    public function getSex()
    {
        return ['male','female'];
    }
    public function getStatusList(){
        return [
            0=>'Under Investigation',
            1=>'Surrendered',
            2=>'Apprehended',
            3=>'Escaped',
            4=>'Deceased'
        ];
    }

    /**
     * Get the list of regions
     * @return array
     */
    public function getRegions(){
        $params = Yii::$app->user->identity->getParamsJurisdictionRegion();
        $regions = Tblregion::find()
            ->select(['region_c','region_m'])
            ->andWhere($params)
            ->all();
        return ArrayHelper::map($regions,'region_c','region_m');
    }

    public static function getPopulation($params)
    {
        return self::find()->andWhere($params);
    }
    public static function getStatusCountsByAge($ageRange,$params,$status)
    {
        $query = Person::find()
            ->andWhere(['status'=>$status])
            ->getCountByBracket()
            ->andWhere($params)
            ->andwhere(['between', new Expression('TIMESTAMPDIFF(YEAR,birthdate,NOW())'), $ageRange[0], $ageRange[1]])
            ->asArray();
        return $query->all();
    }
}
