<?php

namespace App\Models\Visits;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    const CREATED = 'created';
    const COMPLETED = 'completed';
    const IN_PROGRESS = 'in_progress';
    const CANCELLED = 'cancelled';
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'visit_status';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['description', 'slug', 'colour_code'];


    /**
     *
     * @return boolean
     */
    public function isLinked() {
        return false;
    }
}
