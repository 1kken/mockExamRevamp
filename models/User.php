<?php

namespace app\models;

use Yii;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property string|null $username
 * @property string|null $password
 * @property string|null $auth_key
 * @property string|null $access_token
 *
 * @property Jurisdiction $jurisdiction
 */
class User extends \yii\db\ActiveRecord implements IdentityInterface
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['username', 'password', 'auth_key', 'access_token'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Username',
            'password' => 'Password',
            'auth_key' => 'Auth Key',
            'access_token' => 'Access Token',
        ];
    }
    public static function findIdentity($id)
    {
        return self::findOne($id);
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return self::findOne(['access_token' => $token]);
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return self::findOne(['username' => $username]);
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey)
    {
        return $this->auth_key === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password);
    }

    /**
     * Gets query for [[Jurisdiction]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getJurisdiction()
    {
        return $this->hasOne(Jurisdiction::class, ['user_id' => 'id']);
    }
    public function getParamsJurisdictionRegion(){
        if(isset(Yii::$app->authManager->getRolesByUser($this->id)['admin'])){
            return [];
        }
        $jurisdictions = $this->jurisdiction;
        if(empty($jurisdictions)){
            return [];
        }
        $params = [];
        //this applies to REGION users only
        if(isset(Yii::$app->authManager->getRolesByUser($this->id)['region'])){
            $region = $jurisdictions->region_c;
            if(isset($region)){
                $params += ['region_c'=>$region];
            }
        }

        //this applies to PROVINCE users only
        if(isset(Yii::$app->authManager->getRolesByUser($this->id)['province'])){
            $province = $jurisdictions->province_c;
            $region = Tblprovince::findOne(['province_c'=> $province])->region_c;
            $params += ['region_c'=>$region];
        }

        //this applies to CITYMUN users only
        if(isset(Yii::$app->authManager->getRolesByUser($this->id)['cityMun'])){
            $citymun = $jurisdictions->citymun_id;
            $region = Tblcitymun::findOne(['citymun_id'=>$citymun])->region_c;
            $params += ['region_c'=>$region];
        }
        return $params;
    }

    public function getParamsJurisdictionProvince(){
        $jurisdictions = $this->jurisdiction;
        if(empty($jurisdictions)){
            return [];
        }
        $params = [];
        //this applies to PROVINCE users only
        if(isset(Yii::$app->authManager->getRolesByUser($this->id)['province'])){
            $province = $jurisdictions->province_c;
            $params += ['province_c'=>$province];
        }

        //this applies to CITYMUN users only
        if(isset(Yii::$app->authManager->getRolesByUser($this->id)['cityMun'])){
            $citymun = $jurisdictions->citymun_id;
            $province = Tblcitymun::findOne(['citymun_id'=>$citymun])->province_c;
            $params += ['province_c'=>$province];
        }
        return $params;
    }

    public function getParamsJurisdictionCitymun(){
        $jurisdictions = $this->jurisdiction;
        if(empty($jurisdictions)){
            return [];
        }
        $params = [];
        //this applies to CITYMUN users only
        if(isset(Yii::$app->authManager->getRolesByUser($this->id)['cityMun'])){
            $citymun = $jurisdictions->citymun_id;
            $params += ['citymun_id'=>$citymun];
        }
        return $params;
    }

    public function getParamsPersonIndex(){
        $params = [];
        $jurisdictions = $this->jurisdiction;
        if(empty($jurisdictions)){
            return [];
        }
        //this applies to REGION users only
        if(isset(Yii::$app->authManager->getRolesByUser($this->id)['region'])){
            $region = $jurisdictions->region_c;
            if(isset($region)){
                $params += ['region_c'=>$region];
            }
        }
        //this applies to PROVINCE users only
        if(isset(Yii::$app->authManager->getRolesByUser($this->id)['province'])){
            $province = $jurisdictions->province_c;
            if(isset($province)){
                $params += ['province_c'=>$province];
            }
        }
        if(isset(Yii::$app->authManager->getRolesByUser($this->id)['cityMun'])){
            $citymun = $jurisdictions->citymun_id;
            $params += ['citymun_id'=>$citymun];
        }
        return $params;
    }
}
