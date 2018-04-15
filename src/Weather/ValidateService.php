<?php

namespace App\Weather;


class ValidateService
{
    /**
     * @param $day
     * @return bool
     */
    public function validateDateRange($day, $range)
    {
        $valid = false;
        $dayDateTime = new \DateTime($day);
        $now = new \DateTime(date('Y-m-d')) ;
        $interval = $dayDateTime->diff($now);
        if($now<=$dayDateTime && $interval->days < $range)
        {
            $valid = true;
        }

        return $valid;
    }
}
