<?php

use yii\db\Schema;

class m170113_150102_create_schedule_rule_table extends \yii\db\Migration
{
    public function up()
    {
        $tables = Yii::$app->db->schema->getTableNames();
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }
        
        if (!in_array(Yii::$app->db->tablePrefix.'schedule_rule', $tables))  {
          $this->createTable('{{%schedule_rule}}', [
              'id' => $this->primaryKey(),
              'schedule_id' => $this->integer(3)->unsigned()->notNull(),
              'type' => $this->smallInteger(3)->notNull(),
              'day_of_week' => $this->string(0,0),
              'day_of_year' => $this->smallInteger(5),
              'week_number' => $this->smallInteger(3),
              'holiday' => $this->smallInteger(3),
              'start_date' => $this->date(),
              'end_date' => $this->date(),
              'start_at' => $this->datetime()->notNull(),
              'end_at' => $this->datetime()->notNull(),
              'availability' => $this->smallInteger(3)->notNull(),
              'weight' => $this->smallInteger(3)->notNull(),
              'label' => $this->string(20),
              ], $tableOptions);
          
            // Schedule ID
            $this->createIndex(
                'idx-schedule_rule-schedule_id',
                '{{%schedule_rule}}',
                'schedule_id'
            );

            $this->addForeignKey(
                'fk-schedule_rule-schedule_id',
                '{{%schedule_rule}}',
                'schedule_id',
                '{{%schedule}}',
                'id',
                'CASCADE',
                'CASCADE'
            );
          
        } else {
          echo "\nTable `".Yii::$app->db->tablePrefix."schedule_rule` already exists!\n";
        }
                 
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        $this->dropTable('{{%schedule_rule}}');
        $this->execute('SET foreign_key_checks = 1');
    }
}
