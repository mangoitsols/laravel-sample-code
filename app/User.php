<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Cashier\Billable;
use App\CompanySettings;
use App\Property;
use \App\Http\Controllers\QuickBooksController;
use App\Lease;

class User extends Authenticatable
{
    use Notifiable;
    use Billable;

    protected $primaryKey = 'id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'qb_sub',
        'realm_id',
        'name',
        'email',
        'password',
        'company_name',
        'company_address',
        'qb_refresh_token',
        'phone',
        'trial_ends_at',
        'first_steps_completed',
        'stripe_id',
        'user_type'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'trial_ends_at'
    ];

    public function settings()
    {
      return $this->hasOne('App\CompanySettings', 'realm_id', 'realm_id');
    }


    // Return true/false in methods bellow as string, because this methods
    // used to send props to Vue component and normal true/false provokes render errors
    public function qbConnected()
    {
      if ($this->realm_id != null) {
        return 'true';
      }
      return 'false';
    }

    public function hasProperties()
    {
      if ($this->realm_id != null) {
        $properties = Property::where('belong_to', $this->realm_id)->count();
        if ($properties > 0) {
          return 'true';
        }
        return 'false';
      }
      return 'false';
    }

    public function hasTentant()
    {
      if ($this->realm_id != null) {
        // get QB dataService
        $qb = new QuickBooksController();
        $dataService = $qb->returnDS();
        $tenant_id = $this->tenant_responsible;
        $tenant = collect($dataService->Query("SELECT * FROM Customer"))->count();
        if ($tenant > 0) {
          return 'true';
        }
        return 'false';
      }
      return 'false';
    }

    public function hasLease()
    {
      $lease = Lease::where('belong_to', $this->realm_id)->count();
      if ($lease > 0) {
        return 'true';
      }
      return 'false';
    }

}
