<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%person}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%tblregion}}`
 * - `{{%tblprovince}}`
 * - `{{%tblcitymun}}`
 * - `{{%tblcitymun}}`
 */
class m240713_131129_create_person_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%person}}', [
            'id' => $this->primaryKey(),
            'first_name' => $this->string()->notNull(),
            'last_name' => $this->string()->notNull(),
            'birthdate' => $this->date()->notNull(),
            'sex' => $this->integer(),
            'region_c' => $this->string(2)->notNull(),
            'province_c' => $this->string(2)->notNull(),
            'citymun_id' => $this->integer()->notNull(),
            'district_c' => $this->string(3)->notNull(),
            'contact_info' => $this->string(11)->notNull(),
            'status' => $this->integer()->notNull(),
            'date_created' => $this->dateTime()->notNull(),
            'date_update' => $this->dateTime(),
        ],'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB');

        // creates index for column `region_c`
        $this->createIndex(
            '{{%idx-person-region_c}}',
            '{{%person}}',
            'region_c'
        );

        // add foreign key for table `{{%tblregion}}`
        $this->addForeignKey(
            '{{%fk-person-region_c}}',
            '{{%person}}',
            'region_c',
            '{{%tblregion}}',
            'region_c',
            'CASCADE'
        );

        // creates index for column `province_c`
        $this->createIndex(
            '{{%idx-person-province_c}}',
            '{{%person}}',
            'province_c'
        );

        // add foreign key for table `{{%tblprovince}}`
        $this->addForeignKey(
            '{{%fk-person-province_c}}',
            '{{%person}}',
            'province_c',
            '{{%tblprovince}}',
            'province_c',
            'CASCADE'
        );

        // creates index for column `citymun_c`
        $this->createIndex(
            '{{%idx-person-citymun_c}}',
            '{{%person}}',
            'citymun_id'
        );

        // add foreign key for table `{{%tblcitymun}}`
        $this->addForeignKey(
            '{{%fk-person-citymun_c}}',
            '{{%person}}',
            'citymun_id',
            '{{%tblcitymun}}',
            'citymun_id',
            'CASCADE'
        );

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%tblregion}}`
        $this->dropForeignKey(
            '{{%fk-person-region_c}}',
            '{{%person}}'
        );

        // drops index for column `region_c`
        $this->dropIndex(
            '{{%idx-person-region_c}}',
            '{{%person}}'
        );

        // drops foreign key for table `{{%tblprovince}}`
        $this->dropForeignKey(
            '{{%fk-person-province_c}}',
            '{{%person}}'
        );

        // drops index for column `province_c`
        $this->dropIndex(
            '{{%idx-person-province_c}}',
            '{{%person}}'
        );

        // drops foreign key for table `{{%tblcitymun}}`
        $this->dropForeignKey(
            '{{%fk-person-citymun_c}}',
            '{{%person}}'
        );

        // drops index for column `citymun_c`
        $this->dropIndex(
            '{{%idx-person-citymun_c}}',
            '{{%person}}'
        );

        // drops foreign key for table `{{%tblcitymun}}`
        $this->dropForeignKey(
            '{{%fk-person-district_c}}',
            '{{%person}}'
        );

        // drops index for column `district_c`
        $this->dropIndex(
            '{{%idx-person-district_c}}',
            '{{%person}}'
        );

        $this->dropTable('{{%person}}');
    }
}
