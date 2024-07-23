<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%jurisdiction}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%user}}`
 * - `{{%tblregion}}`
 * - `{{%tblprovince}}`
 * - `{{%tblcitymun}}`
 */
class m240715_011943_create_jurisdiction_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%jurisdiction}}', [
            'id' => $this->primaryKey(),
            'user_id'=> $this->integer()->unique()->notNull(),
            'region_c'=> $this->string(2),
            'province_c'=> $this->string(2),
            'citymun_id'=>$this->integer(),
        ], 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB');

        // creates index for column `user_id`
        $this->createIndex(
            '{{%idx-jurisdiction-user_id}}',
            '{{%jurisdiction}}',
            'user_id'
        );

        // add foreign key for table `{{%user}}`
        $this->addForeignKey(
            '{{%fk-jurisdiction-user_id}}',
            '{{%jurisdiction}}',
            'user_id',
            '{{%user}}',
            'id',
            'CASCADE'
        );

        // creates index for column `region_c`
        $this->createIndex(
            '{{%idx-jurisdiction-region_c}}',
            '{{%jurisdiction}}',
            'region_c'
        );

        // add foreign key for table `{{%tblregion}}`
        $this->addForeignKey(
            '{{%fk-jurisdiction-region_c}}',
            '{{%jurisdiction}}',
            'region_c',
            '{{%tblregion}}',
            'region_c',
            'CASCADE'
        );

        // creates index for column `province_c`
        $this->createIndex(
            '{{%idx-jurisdiction-province_c}}',
            '{{%jurisdiction}}',
            'province_c'
        );

        // add foreign key for table `{{%tblprovince}}`
        $this->addForeignKey(
            '{{%fk-jurisdiction-province_c}}',
            '{{%jurisdiction}}',
            'province_c',
            '{{%tblprovince}}',
            'province_c',
            'CASCADE'
        );

        // creates index for column `citymun_c`
        $this->createIndex(
            '{{%idx-jurisdiction-citymun_c}}',
            '{{%jurisdiction}}',
            'citymun_id'
        );

        // add foreign key for table `{{%tblcitymun}}`
        $this->addForeignKey(
            '{{%fk-jurisdiction-citymun_c}}',
            '{{%jurisdiction}}',
            'citymun_id',
            '{{%tblcitymun}}',
            'citymun_id',
            'CASCADE'
        );

        $this->batchInsert('jurisdiction',['user_id','region_c','province_c','citymun_id'],[
            //agoo Test
            [5,null,null,58],
            //adams
            [9,null,null,1],
            //la union
            [6,null,'33',null],
            //region 1
            [7,'01',null,null],
            [8,'02',null,null]

        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%user}}`
        $this->dropForeignKey(
            '{{%fk-jurisdiction-user_id}}',
            '{{%jurisdiction}}'
        );

        // drops index for column `user_id`
        $this->dropIndex(
            '{{%idx-jurisdiction-user_id}}',
            '{{%jurisdiction}}'
        );

        // drops foreign key for table `{{%tblregion}}`
        $this->dropForeignKey(
            '{{%fk-jurisdiction-region_c}}',
            '{{%jurisdiction}}'
        );

        // drops index for column `region_c`
        $this->dropIndex(
            '{{%idx-jurisdiction-region_c}}',
            '{{%jurisdiction}}'
        );

        // drops foreign key for table `{{%tblprovince}}`
        $this->dropForeignKey(
            '{{%fk-jurisdiction-province_c}}',
            '{{%jurisdiction}}'
        );

        // drops index for column `province_c`
        $this->dropIndex(
            '{{%idx-jurisdiction-province_c}}',
            '{{%jurisdiction}}'
        );

        // drops foreign key for table `{{%tblcitymun}}`
        $this->dropForeignKey(
            '{{%fk-jurisdiction-citymun_c}}',
            '{{%jurisdiction}}'
        );

        // drops index for column `citymun_c`
        $this->dropIndex(
            '{{%idx-jurisdiction-citymun_c}}',
            '{{%jurisdiction}}'
        );

        $this->dropTable('{{%jurisdiction}}');
    }
}
