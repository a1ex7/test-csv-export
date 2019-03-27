<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Course extends Model
{

    public $timestamps = false;

    /**
     * @return HasMany
     */
    public function students()
    {
        return $this->hasMany(Student::class);
    }
}
