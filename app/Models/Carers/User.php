<?php

namespace App\Models\Carers;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'carers';

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'surname',
        'email',
        'username',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Get the roles this user belongs to has access to
     *
     * @return Role
     */
    public function roles() {
        return $this->belongsToMany('App\Models\Auth\Role', 'carer_roles', 'carer_id', 'role_id')->withTimestamps();
    }

    /**
     * Does the user have this role
     *
     * @param string $role
     * @return boolean
     */
    public function hasRole($role) {
        if (is_string($role)) {
            return $this->roles->contains('slug', $role);
        }
        return !!$role->intersection($this->roles)->count();
    }

    /**
     * Checks to see if the this user can access this permission
     *
     * @param string/array $permission
     * @return boolean
     */
    public function canAccess($permission = null) {
        return !is_null($permission) && $this->hasPermission($permission);
    }

    /**
     * Does the user have this permission
     *
     * @param string/array $permission
     * @return boolean
     */
    public function hasPermission($permission) {
        $roles = $this->roles;
        foreach ($roles AS $role) {
            if ($role->hasPermission($permission)) {
                return true;
            }
        }
        return false;
    }

    /**
     * Get the Company assigned to this user
     *
     * @return Company
     */
    public function company() {
        return $this->belongsTo('App\Models\System\Company');
    }

    /**
     * Get the Detail for this user
     *
     * @return Detail
     */
    public function detail() {
        return $this->hasOne(Detail::class, 'carer_id', 'id');
    }
}
