<?php

namespace App\Models;

use App\Enums\Role;
use App\Models\Concerns\ProfilePicture;
use App\Models\Concerns\UploadFile;
use App\Models\Contracts\UploadedFilesInterface;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Model;

class User extends Authenticatable implements UploadedFilesInterface
{
    use Notifiable, ProfilePicture;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */

     protected static function boot()
    {
        parent::boot();

        static::creating(function ($user) {
            // Jika user_code sudah diatur (misalnya oleh seeder), jangan timpa
            if (!empty($user->user_code)) {
                return;
            }

            // Generate user_code hanya jika kosong (misalnya untuk member baru)
            $latestUser = User::where('user_code', 'LIKE', 'M%')->latest('id')->first();

            if ($latestUser && preg_match('/M(\d+)/', $latestUser->user_code, $matches)) {
                $nextNumber = intval($matches[1]) + 1;
            } else {
                $nextNumber = 1;
            }

            $user->user_code = 'M' . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);
        });
    }

    protected $fillable = [
        'name',
        'email',
        'password',
        'gender',
        'address',
        'phone_number',
        'profile_picture',
        'point',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'role' => Role::class,
    ];

    /**
     * Transaction relation
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class, 'member_id');
    }

    /**
     * Vouchers relation
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function vouchers(): HasMany
    {
        return $this->hasMany(UserVoucher::class);
    }

    /**
     * Complaint suggestions relation
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function complaint_suggestions(): HasMany
    {
        return $this->hasMany(ComplaintSuggestion::class);
    }

    /**
     * Return column name for storing file name
     *
     * @return string
     */
    public function fileColumn(): string
    {
        return 'profile_picture';
    }

    /**
     * File path for storing and getting uploaded file
     *
     * @return string
     */
    public function getFilePath(): string
    {
        return 'images';
    }

    /**
     * Get storage name
     *
     * @return string
     */
    public function getStorageName(): string
    {
        return 'public';
    }

    /**
     * Mutator for getting file asset path
     *
     * @return string|null
     */
    public function getFileAsset(): ?string
    {
        if (!$this->hasFile() || $this->isDefaultFileName()) {
            return asset('img/profile/' . $this->getDefaultFileName());
        }

        return $this->getFileStorage()->url($this->getFullFilePath());
    }

    /**
     * Password mutator
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    public function password(): Attribute
    {
        return Attribute::make(
            set: function ($value) {
                if (blank($value)) return null;

                return Hash::needsRehash($value) ? Hash::make($value) : $value;
            }
        );
    }
}
