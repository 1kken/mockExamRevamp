<?php

namespace app\components\rbac\rules;

use app\models\Population;
use app\models\User;
use Yii;
use yii\rbac\Rule;

class managePopulationRule extends Rule
{
    public $name = 'managePopulation';

    /**
     * @param $user
     * @param $item
     * @param $params
     * @return boolean
     */
    //$params -> population
    public function execute($user, $item, $params)
    {
        $user_role = Yii::$app->authManager->getRolesByUser($user);

        if(isset($user_role['admin'])){
            return true;
        }

        if(empty($params['population'])){
            return false;
        }

        $user = User::findOne(['id'=>$user]);
        return $this->traverseJurisdiction($params,$user,$user_role);
    }


    /**
     * @param $params
     * @param $user User
     * @return bool
     */
    private function traverseJurisdiction($params, $user, $user_role){
        $population = $params['population'];

        if(isset($user_role['region'])){
            return $user->jurisdiction->region_c == $population->region_c;
        }

        if(isset($user_role['province'])){
            return $user->jurisdiction->province_c == $population->province_c;
        }

        if(isset($user_role['cityMun'])){
            return $user->jurisdiction->citymun_id == $population->citymun_id;
        }

        return false;
    }
}