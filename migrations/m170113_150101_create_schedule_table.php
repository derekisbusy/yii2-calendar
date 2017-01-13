<?php

use yii\db\Schema;

class m170113_150101_create_schedule_table extends \yii\db\Migration
{
    public function up()
    {
        $tables = Yii::$app->db->schema->getTableNames();
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }
        
        if (!in_array(Yii::$app->db->tablePrefix.'schedule', $tables))  {
            $this->createTable('{{%schedule}}', [
                'id' => $this->primaryKey(3)->unsigned(),
                'user_id' => $this->integer(11)->notNull(),
                'status' => $this->smallInteger(1)->unsigned()->notNull(),
                'min_advance_schedule' => $this->smallInteger(3)->unsigned()->notNull(),
                'max_advance_schedule' => $this->smallInteger(3)->unsigned()->notNull(),
                'max_daily_appointments' => $this->smallInteger(3)->unsigned()->notNull(),
                'max_weekly_appointments' => $this->smallInteger(3)->unsigned()->notNull(),
                'require_confirmation' => $this->smallInteger(1)->notNull(),
            ], $tableOptions);
            
            // User ID
            $this->createIndex(
                'idx-schedule-user_id',
                '{{%schedule}}',
                'user_id'
            );

            $this->addForeignKey(
                'fk-schedule-user_id',
                '{{%schedule}}',
                'user_id',
                '{{%user}}',
                'id',
                'CASCADE',
                'CASCADE'
            );
            
        } else {
            echo "\nTable `".Yii::$app->db->tablePrefix."schedule` already exists!\n";
        }
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        $this->dropTable('{{%schedule}}');
        $this->execute('SET foreign_key_checks = 1');
    }
}
