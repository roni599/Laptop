<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_name',
        'email',
        'phone',
        'password',
        'profile_img',
        'status',
        'role_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
    // Rest omitted for brevity

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }


    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function suppliers()
    {
        return $this->hasMany(Supplier::class);
    }
    public function stocks()
    {
        return $this->hasMany(Stock::class);
    }
    public function serials()
    {
        return $this->hasMany(Serial::class);
    }
    public function paymenttypes()
    {
        return $this->hasMany(Paymenttype::class, 'user_id');
    }
    public function investments()
    {
        return $this->hasMany(Investment::class);
    }
    // public function reserves()
    // {
    //     return $this->hasMany(Reserve::class);
    // }
    public function expenseCategories()
    {
        return $this->hasMany(ExpenseCategory::class);
    }
    // public function expenses()
    // {
    //     return $this->hasMany(Expense::class);
    // }
    public function expenser()
    {
        return $this->hasMany(User::class, 'expenser_id');
    }
    public function reserves()
    {
        return $this->hasMany(Reserve::class);
    }


    public function expenses()
    {
        return $this->hasMany(Expense::class, 'expenser_id');
    }
    public function customers()
    {
        return $this->hasMany(Customer::class);
    }
    public function bills()
    {
        return $this->hasMany(Bill::class);
    }
    public function activityLogs()
    {
        return $this->hasMany(ActivityLog::class);
    }
    
}
