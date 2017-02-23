<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use SammyK\LaravelFacebookSdk\SyncableGraphNodeTrait;
use Illuminate\Support\Facades\DB;
class User extends Authenticatable {

    use Notifiable;

use SyncableGraphNodeTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    protected $table = 'users';

    public function images() {
        return $this->hasMany('App\Image');
    }

    public function articles() {
        return $this->hasMany(Article::class);
    }

    public function roles() {
        return $this->belongsToMany('App\Role', 'users_roles');
    }

    public function hasRole($user_role) {

        $roles = $this->roles()->get();

        foreach ($roles as $role) {
            if ($role->rank === $user_role) {
                return true;
            }
        }
        return false;
    }

    public function hasAnyRole($roles) {
        if (is_array($roles)) {
            foreach ($roles as $role) {
                if ($this->_hasRole($role)) {
                    return true;
                }
            }
        } else {
            if ($this->_hasRole($roles)) {
                return true;
            }
        }
        
        return false;
    }
    
    public function _hasRole($role) {
        if ($this->roles()->where('rank', $role)->first()) {
            return true;
        }
        
        return false;
    }
    
    public static function getAll() {
        return DB::table('users as u')
                ->select(
                        'id', 
                        'name', 
                        'email',
                        DB::raw('(SELECT GROUP_CONCAT(r.rank) FROM roles as r INNER JOIN users_roles as ur ON r.id=ur.role_id INNER JOIN users as u ON ur.user_id=u.id) as roles'),
                        'created_at',
                        'updated_at'
                        )
                ->get()
                ;
    }

}
