<?php

use app\components\rbac\rules\managePerson;
use app\components\rbac\rules\managePersonRule;
use app\components\rbac\rules\managePopulationRule;
use yii\db\Migration;

/**
 * Class m240713_143223_init_rbac
 */
class m240713_143223_init_rbac extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        //auth for init
        $auth = Yii::$app->authManager;
        //manage population rule
        $managePopulationRule = new managePopulationRule();
        $auth->add($managePopulationRule);

        //manage person rule
        $managePersonRule = new managePersonRule();
        $auth->add($managePersonRule);

        // Permissions
        $managePopulation = $auth->createPermission('managePopulation');
        $managePopulation->ruleName = $managePopulationRule->name;
        $managePopulation->description = 'Manage population';
        $auth->add($managePopulation);

        $managePerson = $auth->createPermission('managePerson');
        $managePerson->ruleName = $managePersonRule->name;
        $managePerson->description = 'Manage Person';
        $auth->add($managePerson);

        $manageCityMun = $auth->createPermission('manageCityMun');
        $manageCityMun->description = 'Manage cities and municipalities';
        $auth->add($manageCityMun);
        $auth->addChild($manageCityMun, $managePopulation);
        $auth->addChild($manageCityMun,$managePerson);

        $manageProvince = $auth->createPermission('manageProvince');
        $manageProvince->description = 'Manage provinces';
        $auth->add($manageProvince);

        $manageRegion = $auth->createPermission('manageRegion');
        $manageRegion->description = 'Manage regions';
        $auth->add($manageRegion);


        // Roles
        $cityMun = $auth->createRole('cityMun');
        $auth->add($cityMun);
        $auth->addChild($cityMun, $manageCityMun);

        $province = $auth->createRole('province');
        $auth->add($province);
        $auth->addChild($province, $manageCityMun);
        $auth->addChild($province, $cityMun);

        $region = $auth->createRole('region');
        $auth->add($region);
        $auth->addChild($region, $manageProvince);
        $auth->addChild($region, $province);

        $admin = $auth->createRole('admin');
        $auth->add($admin);
        $auth->addChild($admin, $manageRegion);
        $auth->addChild($admin, $region);

        //assign
        //admin
        $auth->assign($admin,2);
        //agoo
        $auth->assign($cityMun,5);
        //adams
        $auth->assign($cityMun,9);
        //la union
        $auth->assign($province,6);
        //region 1
        $auth->assign($region,7);
        //region 2
        $auth->assign($region,8);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $auth = Yii::$app->authManager;
        $auth->removeAll();
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240713_143223_init_rbac cannot be reverted.\n";

        return false;
    }
    */
}
