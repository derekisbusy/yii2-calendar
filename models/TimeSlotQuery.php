<?php

namespace derekisbusy\calendar\models;

/**
 * This is the ActiveQuery class for [[TimeSlot]].
 *
 * @see TimeSlot
 */
class TimeSlotQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return TimeSlot[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return TimeSlot|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}