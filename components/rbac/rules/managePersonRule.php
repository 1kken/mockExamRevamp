<?php

namespace app\components\rbac\rules;

use app\models\User;
use Yii;
use yii\rbac\Rule;

class managePersonRule extends Rule
{
    public $name = "managePerson";
    public function execute($user, $item, $params)
    {
        $action = Yii::$app->controller->action->id;
        $user_role = Yii::$app->authManager->getRolesByUser($user);
        $user = User::findOne(['id'=>$user]);

        if(isset($user_role['admin'])){
            return true;
        }

        //Manage scope Read Update Delete
        $isActionNotCreate = $action != 'create';
        if(isset($params['person']) && $isActionNotCreate){
            return $this->traverseJurisdictionManage($user,$params,$user_role);
        }
        //if there's a jurisdiction for the user you can create
        return isset($user->jurisdiction);
    }

    /**
     * @param $user User
     * @param $params
     * @return bool
     */
    private function traverseJurisdictionManage($user,$params,$user_role){
        $person = $params['person'];

        if(isset($user_role['region'])){
            return $user->jurisdiction->region_c == $person->region_c;
        }

        if(isset($user_role['province'])){
            return $user->jurisdiction->province_c == $person->province_c;
        }

        if(isset($user_role['cityMun'])){
            return $user->jurisdiction->citymun_id == $person->citymun_id;
        }

        return false;
    }
}