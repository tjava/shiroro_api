<?php

namespace App;

use App\Models\Iot;
/**
 * Authentication
 *
 * PHP version 7.0
 */
class Dbgeter
{
    /**
     * Get database class and return it.
     *
     * @param User $iot The Iot model
     * @param boolean $iot
     *
     * @return void
     */
    public static function Iot()
    {
        return $iot = new Iot;
    }

}