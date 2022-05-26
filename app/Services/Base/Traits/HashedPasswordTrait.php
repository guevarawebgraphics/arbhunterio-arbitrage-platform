<?php

namespace App\Services\Base\Traits;

use Illuminate\Support\Facades\Hash;

/**
 * Class HashedPasswordTrait
 * @package App\Servicess\Base\Traits
 * @author Bryan James Dela Luya
 */

trait HashedPasswordTrait
{
    /**
     * Auto-hash incoming password attribute
     * 
     * @param  string $password Password
     */
    public function setPasswordAttribute($password)
    {
        if ($password !== null) {
            $password = Hash::make($password);
        }

        $this->attributes['password'] = $password;
    }

    /**
     * Check if password matches the hash in the database
     * 
     * @param  string $password Password
     * @return boolean
     */
    public function checkPassword($password)
    {
        return Hash::check($password, $this->attributes['password']);
    }
}
