<?php

use yii\db\Schema;

class m170113_150101_create_schedule_appointment_type_table extends \yii\db\Migration
{
    public function up()
    {
        $tables = Yii::$app->db->schema->getTableNames();
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }
        
        if (!in_array(Yii::$app->db->tablePrefix.'schedule_appointment_type', $tables))  {
          $this->createTable('{{%schedule_appointment_type}}', [
              'id' => $this->primaryKey(1)->unsigned(),
              'abbr' => $this->string(12)->notNull(),
              'name' => $this->string(100)->notNull(),
              ], $tableOptions);
                } else {
          echo "\nTable `".Yii::$app->db->tablePrefix."schedule_appointment_type` already exists!\n";
        }
                 
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        $this->dropTable('{{%schedule_appointment_type}}');
        $this->execute('SET foreign_key_checks = 1');
    }
}
