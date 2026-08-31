<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\UserLog;
use App\Notifications\ResetPasswordNotification;


class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'name',
        'email',
        'password',
        'user_type',
        'is_active',
        'is_verified',
        'contact_detail',
        'phone',
        'dob',
        'address',
        'city',
        'country',
        'state',
        'postal',
        'website_url',
        'image',
        'group_id',
        'stripe',
        'slug', 'talentlms_id', 'secret', 'brief', 'fb_token', 'provider', 'is_login', 'middle_name', 'language_type',
        'race', 'gender', 'citizenship', 'education', 'institution', 'department', 'program', 'is_approved',
        'additional_address', 'fees_paid', 'd_month', 'd_day', 'd_year', 'payment_id', 'email_send', 'program_id',
        'doc_requested', 'doc_submitted', 'documents', 'bb_id', 'salary', 'secondary_email', 'last_reminded',
        'website', 'cover_image', 'name', 'password_reset', 'password_rand', 'device_key', 'own_delivery',
        'about_company', 'company_address', 'working_time_start', 'working_time_end', 'working_day',
        'show_address_on_adds', 'chats', 'feedback', 'reason', 'reason_details', 'login_datetime',
        'social_links','is_deleted','user_email', 'last_activity'
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
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function group()
    {
        return $this->hasOne(UserGroups::class, 'id','group_id');
    }

    function plan()
    {
        return $this->hasOne(UserPlan::class, 'user_id', 'id')->where('expired', 0)->where('unsub', 0)->where('paid', 1);
    }

    function orders()
    {
        return $this->hasMany(Orders::class, 'user_id');
    }

    function activeAds()
    {
        return $this->hasMany(Advertise::class, 'user_id')->where('status', 'active');
    }

    function ads()
    {
        return $this->hasMany(Advertise::class, 'user_id');
    }

    public function notifications()
    {
        return $this->hasMany(Notifications::class);
    }

    public function wallet()
    {
        return $this->hasOne(Wallets::class, 'user_id', 'id');
    }

    public function moneySpent() {
        return $this->hasMany(WalletTransactions::class, 'user_id', 'id')->where('type', 'credit')->sum('amount');
    }

    public function unreadNotificationCount(): int
    {
        return $this->notifications()->where('is_read', 0)->count();
    }


    public function setSocialLinksAttribute($value)
    {
        $this->attributes['social_links'] = json_encode($value);
    }

    public function getSocialLinksAttribute($value)
    {
        return json_decode($value);
    }
    
    public function setWorkingDayAttribute($value)
    {
        $this->attributes['working_day'] = json_encode($value);
    }

    public function getWorkingDayAttribute($value)
    {
        return json_decode($value);
    }

    /**
     * "First Last", falling back to the legacy `name` column for
     * users who haven't got first_name/last_name populated yet.
     */
    public function getFullNameAttribute()
    {
        $fullName = trim(($this->first_name ?? '').' '.($this->last_name ?? ''));

        return $fullName !== '' ? $fullName : ($this->name ?? '');
    }

    /* User Log */
    protected static function boot()
    {
        parent::boot();

        // Keep the legacy `name` column (still relied on across the app,
        // e.g. admin panel, chat, ads listings) in sync whenever
        // first_name/last_name are set, so it never goes stale.
        static::saving(function ($user) {
            if ($user->isDirty('first_name') || $user->isDirty('last_name')) {
                $fullName = trim(($user->first_name ?? '').' '.($user->last_name ?? ''));
                if ($fullName !== '') {
                    $user->name = $fullName;
                }
            }
        });

        static::created(function ($post) {
            UserLog::create([
                'user_id' => auth()->id(),
                'action' => 'create',
                'model' => 'User',
                'model_id' => $post->id,
                'user_ip'=>request()->ip(),
                'description' => "Created user: {$post->name}",
            ]);
        });

        static::updated(function ($post) {
            UserLog::create([
                'user_id' => auth()->id(),
                'action' => 'update',
                'model' => 'User',
                'model_id' => $post->id,
                'user_ip'=>request()->ip(),
                'description' => "Updated user: {$post->name}",
            ]);
        });

        static::deleted(function ($post) {
            UserLog::create([
                'user_id' => auth()->id(),
                'action' => 'delete',
                'model' => 'User',
                'model_id' => $post->id,
                'user_ip'=>request()->ip(),
                'description' => "Deleted user: {$post->name}",
            ]);
        });
    }
    /* User Log */

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token));
    }
}
