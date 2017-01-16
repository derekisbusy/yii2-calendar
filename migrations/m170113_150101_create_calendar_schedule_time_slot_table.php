<?php

use yii\db\Schema;

class m170113_150101_create_schedule_time_slot_table extends \yii\db\Migration
{
    public function up()
    {
        $tables = Yii::$app->db->schema->getTableNames();
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }
        
        if (!in_array(Yii::$app->db->tablePrefix.'calendar_schedule_time_slot', $tables))  {
          $this->createTable('{{%calendar_schedule_time_slot}}', [
              'id' => $this->primaryKey(10)->unsigned(),
              'schedule_id' => $this->integer(3)->unsigned()->notNull(),
              'start_at' => $this->datetime()->notNull(),
              'end_at' => $this->datetime()->notNull(),
              ], $tableOptions);
        
            // Schedule ID
            $this->createIndex(
                'idx-calendar_schedule_time_slot-schedule_id',
                '{{%calendar_schedule_time_slot}}',
                'schedule_id'
            );

            $this->addForeignKey(
                'fk-calendar_schedule_time_slot-schedule_id',
                '{{%calendar_schedule_time_slot}}',
                'schedule_id',
                '{{%calendar_schedule}}',
                'id',
                'CASCADE',
                'CASCADE'
            );
        } else {
          echo "\nTable `".Yii::$app->db->tablePrefix."calendar_schedule_time_slot` already exists!\n";
        }
                 
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        $this->dropTable('{{%calendar_schedule_time_slot}}');
        $this->execute('SET foreign_key_checks = 1');
    }
}
