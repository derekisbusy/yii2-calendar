<?php

namespace derekisbusy\calendar\models;

use derekisbusy\calendar\models\AppointmentStatus;
use derekisbusy\calendar\models\AppointmentType;
use derekisbusy\calendar\backend\modules\calendar\Module;
use Yii;

/**
 * This is the model class for table "{{%schedule_appointment}}".
 *
 * @property integer $id
 * @property string $patient_id
 * @property integer $type_id
 * @property string $start_at
 * @property string $end_at
 * @property integer $status_id
 * @property string $assigned_to
 * @property string $created_by
 * @property string $updated_by
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Patient $patient
 * @property User $createdBy
 * @property User $updatedBy
 * @property AppointmentType $type
 * @property AppointmentStatus $status
 * @property User $assignedTo
 */
class AppointmentSearch extends Appointment
{
    
    public $appointment_type;
    public $appointment_status;
    public $patient_name;
    public $assigned_to_username;
    public $created_by_username;
    public $updated_by_username;
    public $phone_numbers;
    
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return array_merge(parent::rules(),[
            [['appointment_type','appointment_status'], 'integer'],
            [['patient_name','assigned_to_username'],'safe']
        ]);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(),[
            'assigned_to_username' => Yii::t('common', 'Assigned To'),
            'created_by_username' => Yii::t('common', 'Created By'),
            'updated_by_username' => Yii::t('common', 'Updated By'),
            'appointemnt_type' => Yii::t('common', 'Type'),
            'appointemnt_status' => Yii::t('common', 'Status'),
        ]);
    }
    
    public function select()
    {
        
        $select=[Appointment::tableName().'.*'];
        $select[] = new \yii\db\Expression("`user_assigned`.`username` AS `assigned_to_username`");
        $select[] = new \yii\db\Expression("`type`.`name` AS `appointment_type`");
        $select[] = new \yii\db\Expression("`t_status`.`name` AS `appointment_status`");
        $select[] = new \yii\db\Expression("`user_created`.`username` AS `created_by_username`");
        $select[] = new \yii\db\Expression("`user_updated`.`username` AS `updated_by_username`");
//        $select[] = new \yii\db\Expression("CONCAT(`patient`.`first_name`,', ',`patient`.`last_name`,' ',SUBSTRING(`patient`.`middle_name`,0,1)) AS `patient_name`");
        return $select;
    }
    
    public function query($query)
    {
        return $query->innerJoin(Module::getUserTableName().' user', '`user`.`'.Module::getUserModelIdName().'` = `user_id`')
            ->innerJoin(Module::getUserTableName().' user_created', '`user_created`.`id` = '.Appointment::tableName().'.`created_by`')
            ->innerJoin(Module::getUserTableName().' user_updated', '`user_updated`.`id` = '.Appointment::tableName().'.`updated_by`')
            ->innerJoin(AppointmentType::tableName().' type', '`type`.`id` = `type_id`')
            ->innerJoin(AppointmentStatus::tableName().' t_status', '`t_status`.`id` = '.Appointment::tableName().'.`status_id`')
            ->leftJoin(Module::getUserTableName().' user_assigned', '`user_assigned`.`id` = '.Appointment::tableName().'.`assigned_to`');
    }
    
    public function sort()
    {
        return [
           'attributes' => array_merge([
//               'patient_name' => [
//                    'asc' => ['patient_name' => SORT_ASC],
//                    'desc' => ['patient_name' => SORT_DESC],
//                    'label' => 'Order Name',
//                    'default' => SORT_ASC
//               ],
               'appointment_type' => [
                    'asc' => ['appointment_type' => SORT_ASC],
                    'desc' => ['appointment_type' => SORT_DESC],
                    'label' => 'Order Type',
                    'default' => SORT_ASC
               ],
               'appointment_status' => [
                    'asc' => ['appointment_status' => SORT_ASC],
                    'desc' => ['appointment_status' => SORT_DESC],
                    'label' => 'Order Status',
                    'default' => SORT_ASC
               ],
               'assigned_to_username' => [
                    'asc' => ['assigned_to_username' => SORT_ASC],
                    'desc' => ['assigned_to_username' => SORT_DESC],
                    'label' => 'Order Assigned To',
                    'default' => SORT_ASC
               ],
               'created_by_username' => [
                    'asc' => ['user_created.username' => SORT_ASC],
                    'desc' => ['user_created.username' => SORT_DESC],
                    'label' => 'Order Created By',
                    'default' => SORT_ASC
               ],
               'updated_by_username' => [
                    'asc' => ['user_updated.username' => SORT_ASC],
                    'desc' => ['user_updated.username' => SORT_DESC],
                    'label' => 'Order Updated By',
                    'default' => SORT_ASC
               ],
           ],array_keys($this->attributes))];
    }
    
    public function filters($query)
    {
        $query->andFilterWhere([
            'id' => $this->id,
            'patient_id' => $this->patient_id,
            'type.id' => $this->appointment_type,
            't_status.id' => $this->appointment_status,
            ])
            ->andFilterWhere(['like', new \yii\db\Expression("CONCAT(`patient`.`first_name`,' ',`patient`.`middle_name`,' ',`patient`.`last_name`)"), $this->patient_name])
            ->andFilterWhere(['like', 'user_assigned.username', $this->assigned_to_username])
            ->andFilterWhere(['like', 'user_created.username', $this->created_by_username])
            ->andFilterWhere(['like', 'user_updated.username', $this->updated_by_username]);
    }
    
    public function search($params)
    {
        $select = $this->select();
        $query = $this->query(self::find()->select($select));
        
        
        $dataProvider = new \yii\data\ActiveDataProvider([
            'query' => $query,
        ]);
        
        $dataProvider->setSort($this->sort());
        
        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }
        
        $this->filters($query);
        
        return $dataProvider;
    }
    
}
