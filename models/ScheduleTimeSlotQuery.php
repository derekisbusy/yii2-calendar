<?php

namespace derekisbusy\calendar\models;

/**
 * This is the ActiveQuery class for [[ScheduleTimeSlot]].
 *
 * @see ScheduleTimeSlot
 */
class ScheduleTimeSlotQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return ScheduleTimeSlot[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return ScheduleTimeSlot|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}