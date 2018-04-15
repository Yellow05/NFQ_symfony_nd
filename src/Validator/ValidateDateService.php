<?php
/**
 * Created by PhpStorm.
 * User: liudas
 * Date: 18.4.15
 * Time: 23.02
 */

namespace App\Validator;


class ValidateDateService
{
    /**
     * @param $day
     * @return bool
     */
    public function validateIfDateTime($day)
    {
        $valid = true;
        try{
            new \DateTime($day);
        } catch (\Exception $exp) {
            $valid = false;
        }

        return $valid;
    }
}
