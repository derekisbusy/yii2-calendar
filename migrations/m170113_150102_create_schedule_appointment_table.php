<?php

use yii\db\Schema;

class m170113_150102_create_schedule_appointment_table extends \yii\db\Migration
{
    public function up()
    {
        $tables = Yii::$app->db->schema->getTableNames();
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }
        
        if (!in_array(Yii::$app->db->tablePrefix.'schedule_appointment', $tables))  {
          $this->createTable('{{%schedule_appointment}}', [
              'id' => $this->primaryKey(),
              'label' => $this->string(30),
              'user_id' => $this->integer(11),
              'type_id' => $this->smallInteger(1)->unsigned()->notNull(),
              'start_at' => $this->datetime()->notNull(),
              'end_at' => $this->datetime()->notNull(),
              'status_id' => $this->integer(1)->unsigned()->notNull(),
              'assigned_to' => $this->integer(11),
              'created_by' => $this->integer(11),
              'updated_by' => $this->integer(11),
              'created_at' => $this->datetime()->notNull(),
              'updated_at' => $this->datetime(),
              ], $tableOptions);
          
            // User ID
            $this->createIndex(
                'idx-schedule_appointment-user_id',
                '{{%schedule_appointment}}',
                'schedule_appointment'
            );

            $this->addForeignKey(
                'fk-schedule_appointment-user_id',
                '{{%schedule_appointment}}',
                'user_id',
                '{{%user}}',
                'id',
                'CASCADE',
                'CASCADE'
            );
            
            // Type ID
            $this->createIndex(
                'idx-schedule_appointment-user_id',
                '{{%schedule_appointment}}',
                'schedule_appointment'
            );

            $this->addForeignKey(
                'fk-schedule_appointment-user_id',
                '{{%schedule_appointment}}',
                'user_id',
                '{{%user}}',
                'id',
                'SET NULL',
                'CASCADE'
            );
            
            // Status ID
            $this->createIndex(
                'idx-schedule_appointment-status_id',
                '{{%schedule_appointment}}',
                'status_id'
            );

            $this->addForeignKey(
                'fk-schedule_appointment-status_id',
                '{{%schedule_appointment}}',
                'status_id',
                '{{%schedule_appointment_status}}',
                'id',
                'SET NULL',
                'CASCADE'
            );
            
            // Assigned To
            $this->createIndex(
                'idx-schedule_appointment-assigned_to',
                '{{%schedule_appointment}}',
                'assigned_to'
            );

            $this->addForeignKey(
                'fk-schedule_appointment-assigned_to',
                '{{%schedule_appointment}}',
                'assigned_to',
                '{{%user}}',
                'id',
                'SET NULL',
                'CASCADE'
            );
            
            // Created By
            $this->createIndex(
                'idx-schedule_appointment-created_by',
                '{{%schedule_appointment}}',
                'created_by'
            );

            $this->addForeignKey(
                'fk-schedule_appointment-created_by',
                '{{%schedule_appointment}}',
                'created_by',
                '{{%user}}',
                'id',
                'SET NULL',
                'CASCADE'
            );

            // Updated By
            $this->createIndex(
                'idx-schedule_appointment-updated_by',
                '{{%schedule_appointment}}',
                'updated_by'
            );

            $this->addForeignKey(
                'fk-schedule_appointment-updated_by',
                '{{%schedule_appointment}}',
                'updated_by',
                '{{%user}}',
                'id',
                'SET NULL',
                'CASCADE'
            );
          
        } else {
          echo "\nTable `".Yii::$app->db->tablePrefix."schedule_appointment` already exists!\n";
        }
                 
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        $this->dropTable('{{%schedule_appointment}}');
        $this->execute('SET foreign_key_checks = 1');
    }
}
