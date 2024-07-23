<?php

namespace app\commands;

use app\models\User;
use Yii;
use yii\console\ExitCode;
use yii\base\Controller;

class UserController extends Controller
{
    public function actionIndex(){
        $types = ['admin','region','province','citymun','user'];

        foreach ($types as $type){
            $user = new User();
            $user->username = $type;
            $user->password = Yii::$app->security->generatePasswordHash($type);
            $user->access_token = Yii::$app->security->generateRandomString();
            $user->auth_key = Yii::$app->security->generateRandomString();

            //assigning roles
            if($user->save()){
                $auth = \Yii::$app->authManager;
                $authorRole = $auth->getRole($type);
                $auth->assign($authorRole, $user->getId());
            }
        }

    }
}