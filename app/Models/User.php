<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Http\UploadedFile;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;

/**
 * Eloquent class User
 * @property int $id
 * @property string $name
 * @property string $email
 * @property float $balance
 * @property int $role
 * @property string $phone
 * @property string $birthdate
 * @property string $image
 * @property string $remember_token
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Transaction[] $transactions
 */
class User extends Authenticatable
{
    use Notifiable;

    const ROLE_ADMIN = 1;
    const ROLE_USER = 0;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'role', 'phone', 'birthdate', 'image', 'balance'
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
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Returns transactions relation
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function transactions()
    {
        return $this->hasMany('App\Models\Transaction');
    }

    public function uploadImage(?UploadedFile $image)
    {
        if ($image){
            $imageName = $this->id.'_'.time().'.'.$image->extension();
            $image->storeAs('/public/users-images', $imageName);

            return $imageName;
        }

        return '';

    }

    public function getUserImageDir()
    {
        return storage_path() . '/app/public/users-images';
    }

    public function getUserImageUrl()
    {
        if (file_exists($this->getUserImageDir() . '/' . $this->image)) {
            return asset('storage/users-images/' . $this->image);
        }
        return false;
    }

    public function transactionGrouping($type, $format, $periodType)
    {
        $minDate = false;
        if ($periodType == Transaction::CHART_DAILY){
            $minDate = date('Y-m-d 00:00:00', strtotime('-1 month'));
        }elseif ($periodType == Transaction::CHART_MONTHLY) {
            $minDate = date('Y-m-d 00:00:00', strtotime('-1 year'));
        }
        $transactionQuery = Transaction::query()
            ->whereHas('category', function ($query) use ($type) {
                return $query->where('type', '=', $type);
            })
            ->selectRaw("DATE_FORMAT(created_at, '{$format}') as data, sum(amount) as amountSum")
            ->where('user_id', $this->id)
            ->groupBy('data')
            ->orderByDesc('created_at');

        if ($minDate) {
            $transactionQuery = $transactionQuery->where('created_at', '>', $minDate);
        }
        $transactions = $transactionQuery->get()->toArray();

        return $transactions;
    }

    public function transactionsSum($transactionType)
    {
        return $this->transactions()->whereHas('category', function ($query) use ($transactionType) {
            return $query->where('type', '=', $transactionType);
        })->sum('amount');

    }


}
