<?php

use yii\db\Schema;

class m170113_150101_create_calendar_appointment_status_table extends \yii\db\Migration
{
    public function up()
    {
        $tables = Yii::$app->db->schema->getTableNames();
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }
        
        if (!in_array(Yii::$app->db->tablePrefix.'calendar_appointment_status', $tables))  {
          $this->createTable('{{%calendar_appointment_status}}', [
              'id' => $this->primaryKey(1)->unsigned(),
              'abbr' => $this->string(12)->notNull(),
              'name' => $this->string(100)->notNull(),
              ], $tableOptions);
                } else {
          echo "\nTable `".Yii::$app->db->tablePrefix."calendar_appointment_status` already exists!\n";
        }
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        $this->dropTable('{{%calendar_appointment_status}}');
        $this->execute('SET foreign_key_checks = 1');
    }
}
