<?php

namespace App\Models\Auth;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    const CARER = 'carer';
    const SUPERVISOR = 'supervisor';
    const SUPER_ADMIN = 'super_admin';

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'roles';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['title', 'slug'];

    /**
     * one-to-many relationship method.
     *
     * @return QueryBuilder
     */
    public function users() {
        return $this->hasMany('App\Models\Carers\Carer');
    }

    /**
     * many-to-many
     *
     * @return type
     */
    public function permissions() {
        return $this->belongsToMany('App\Models\Auth\Permission', 'role_permissions');
    }

    /**
     * Does the user have this role
     *
     * @param string/array $permission
     * @return boolean
     */
    public function hasPermission($permission): bool
    {
        if (is_string($permission)) {
            return $this->permissions->contains('slug', $permission);
        }
        //returns false on 0, else true (Model->intersection)
        return !!$permission->intersection($this->permissions)->count();
    }

    /**
     *
     * @return boolean
     */
    public function isLinked() {
        return ($this->permissions()->count() > 0 ? 'Permissions' : FALSE);
    }
}
