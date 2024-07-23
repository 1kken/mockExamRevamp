<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%population}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%tblregion}}`
 * - `{{%tblprovince}}`
 * - `{{%tblcitymun}}`
 */
class m240716_023103_create_population_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%population}}', [
            'id' => $this->primaryKey(),
            'region_c'=> $this->string(2)->notNull(),
            'province_c'=> $this->string(2)->notNull(),
            'citymun_id'=>$this->integer()->notNull(),
            'population_count' => $this->bigInteger(),
        ],'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB');

        // creates index for column `region_c`
        $this->createIndex(
            '{{%idx-population-region_c}}',
            '{{%population}}',
            'region_c'
        );

        // add foreign key for table `{{%tblregion}}`
        $this->addForeignKey(
            '{{%fk-population-region_c}}',
            '{{%population}}',
            'region_c',
            '{{%tblregion}}',
            'region_c',
            'CASCADE'
        );

        // creates index for column `province_c`
        $this->createIndex(
            '{{%idx-population-province_c}}',
            '{{%population}}',
            'province_c'
        );

        // add foreign key for table `{{%tblprovince}}`
        $this->addForeignKey(
            '{{%fk-population-province_c}}',
            '{{%population}}',
            'province_c',
            '{{%tblprovince}}',
            'province_c',
            'CASCADE'
        );

        // creates index for column `citymun_id`
        $this->createIndex(
            '{{%idx-population-citymun_id}}',
            '{{%population}}',
            'citymun_id'
        );

        // add foreign key for table `{{%tblcitymun}}`
        $this->addForeignKey(
            '{{%fk-population-citymun_id}}',
            '{{%population}}',
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
            '{{%fk-population-region_c}}',
            '{{%population}}'
        );

        // drops index for column `region_c`
        $this->dropIndex(
            '{{%idx-population-region_c}}',
            '{{%population}}'
        );

        // drops foreign key for table `{{%tblprovince}}`
        $this->dropForeignKey(
            '{{%fk-population-province_c}}',
            '{{%population}}'
        );

        // drops index for column `province_c`
        $this->dropIndex(
            '{{%idx-population-province_c}}',
            '{{%population}}'
        );

        // drops foreign key for table `{{%tblcitymun}}`
        $this->dropForeignKey(
            '{{%fk-population-citymun_id}}',
            '{{%population}}'
        );

        // drops index for column `citymun_id`
        $this->dropIndex(
            '{{%idx-population-citymun_id}}',
            '{{%population}}'
        );

        $this->dropTable('{{%population}}');
    }
}
