<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;
use Laravel\Sanctum\HasApiTokens;
use Rawilk\ProfileFilament\Concerns\TwoFactorAuthenticatable;
use Rawilk\ProfileFilament\Contracts\PendingUserEmail\MustVerifyNewEmail;
use Filament\Models\Contracts\HasAvatar;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;

class User extends Authenticatable implements MustVerifyNewEmail, FilamentUser, HasAvatar
{
    use HasApiTokens, HasFactory, Notifiable;
    use TwoFactorAuthenticatable;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id',
        'avatar_url',
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

    protected static function booted(): void
    {
        static::creating(function (User $user) {
            $user->role_id = 3;
        });
    }

    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }
    public function userBio()
    {
        return $this->hasOne(UserBio::class);
    }

    public function getFilamentAvatarUrl(): ?string
    {
        return $this->avatar_url ? Storage::url($this->avatar_url) : null;
    }

    //appointment relation
    public function appointmentswpatient()
    {
        //return with appointment.patient_id instead of appointments.user_id
        return $this->hasMany(Appointment::class, 'patient_id');
    
    }
    
    public function appointmentswdentist()
    {
        //return with appointment.dentist_id instead of appointments.user_id
        return $this->hasMany(Appointment::class, 'dentist_id');
    
    }

    public function canAccessPanel(Panel $panel): bool
    {
        if ($panel->getId() === 'admin') {
            return $this->role->name === 'admin';
        }
        if ($panel->getId() === 'app') {
            //all role but user must have role
            return true;
        }
       
    }
}
