<?php

use yii\db\Schema;

class m170113_150102_create_calendar_schedule_rule_table extends \yii\db\Migration
{
    public function up()
    {
        $tables = Yii::$app->db->schema->getTableNames();
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }
        
        if (!in_array(Yii::$app->db->tablePrefix.'calendar_schedule_rule', $tables))  {
          $this->createTable('{{%calendar_schedule_rule}}', [
              'id' => $this->primaryKey(),
              'schedule_id' => $this->integer(3)->unsigned()->notNull(),
              'availability' => $this->smallInteger(3)->notNull(),
              'weight' => $this->smallInteger(3)->notNull(),
              'label' => $this->string(20)->null(),
              'type' => $this->smallInteger(3)->notNull(),
              'day_of_week' => $this->string(0,0)->null(),
              'day_of_year' => $this->smallInteger(5)->null(),
              'week_number' => $this->smallInteger(3)->null(),
              'holiday' => $this->smallInteger(3)->null(),
              'start_date' => $this->date()->null(),
              'end_date' => $this->date()->null(),
              'start_at' => $this->datetime()->notNull(),
              'end_at' => $this->datetime()->notNull(),
              'sunday' => $this->smallInteger(1)->null(),
              'monday' => $this->smallInteger(1)->null(),
              'tuesday' => $this->smallInteger(1)->null(),
              'wednesday' => $this->smallInteger(1)->null(),
              'thursday' => $this->smallInteger(1)->null(),
              'friday' => $this->smallInteger(1)->null(),
              'saturday' => $this->smallInteger(1)->null(),
              ], $tableOptions);
          
            // Schedule ID
            $this->createIndex(
                'idx-calendar_schedule_rule-schedule_id',
                '{{%calendar_schedule_rule}}',
                'schedule_id'
            );

            $this->addForeignKey(
                'fk-calendar_schedule_rule-schedule_id',
                '{{%calendar_schedule_rule}}',
                'schedule_id',
                '{{%schedule}}',
                'id',
                'CASCADE',
                'CASCADE'
            );
          
        } else {
          echo "\nTable `".Yii::$app->db->tablePrefix."calendar_schedule_rule` already exists!\n";
        }
                 
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        $this->dropTable('{{%calendar_schedule_rule}}');
        $this->execute('SET foreign_key_checks = 1');
    }
}
