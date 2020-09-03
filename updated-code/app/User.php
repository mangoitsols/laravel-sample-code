<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Zizaco\Entrust\Traits\EntrustUserTrait;
use Kyslik\ColumnSortable\Sortable;

class User extends Authenticatable {

    use Notifiable;
    use EntrustUserTrait;
    use Sortable;

    protected $sortable = ['name', 'email'];
    protected $with = ['userrole'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'mobile_number', 'user_work_phone',
        'designation', 'user_org_id', 'user_nationality_id', 'user_status', 'phone_code'
        , 'updated_at', 'created_at', 'deleted_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function userrole() {
        return $this->belongsTo('App\RoleUser', 'id', 'user_id');
    }

    public function organization() {
        return $this->belongsTo('App\Organization', 'user_org_id', 'id');
    }

    public function desig() {
        return $this->belongsTo('App\Designation', 'designation', 'id');
    }

    public function country() {
        return $this->belongsTo('App\Country', 'user_nationality_id', 'id');
    }
    
    public function parentOrders() {
        return $this->hasMany('App\OrderGeneralInfo', 'id', 'parent_id');
    }

}
