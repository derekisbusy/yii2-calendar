<?php

namespace derekisbusy\calendar\models;

class AppointmentQuery extends \yii\db\ActiveQuery
{
    public function between($start,$end)
    {
        return $this->where('start_at between :t1 and :t2')
                    ->orWhere('end_at between :t1 and :t2')
                    ->addParams([':t1'=>$start,':t2'=>$end]);
    }
}