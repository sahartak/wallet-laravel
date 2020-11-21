<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Eloquent class Transaction
 * @property int $id
 * @property integer $user_id
 * @property integer $category_id
 * @property float $amount
 * @property string $note
 * @property string $created_at
 * @property string $updated_at
 *
 * @property User $user
 * @property Category $category
 */
class Transaction extends Model
{
    protected $guarded = [];

    const CHART_DAILY = 0;
    const CHART_MONTHLY = 1;
    const CHART_YEARLY = 2;

    const CHART_VARIANTS = [
        self::CHART_DAILY => 'Daily',
        self::CHART_MONTHLY => 'Monthly',
        self::CHART_YEARLY => 'Yearly',
    ];

    const CHART_FORMATTERS = [
        self::CHART_DAILY => '%Y-%m-%d',
        self::CHART_MONTHLY => '%Y-%m',
        self::CHART_YEARLY => '%Y',
    ];

    const PHP_DATE_FORMATTERS = [
        self::CHART_DAILY => 'Y-m-d',
        self::CHART_MONTHLY => 'Y-m',
        self::CHART_YEARLY => 'Y',
    ];

    /**
     * Returns user relation
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    /**
     * Returns category relation
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category()
    {
        return $this->belongsTo('App\Models\Category');
    }


    /**
     * Update user balance after transaction
     * @return float
     */
    public function updateBalance()
    {
        $user = $this->user;
        /* @var  $user User*/
        $userBalance = $user->balance;
        $transactionAmount = $this->amount;
        if ($this->category->type == Category::TYPE_EXPENSE) {
            $user->balance = $userBalance - $transactionAmount;
        }else {
            $user->balance = $userBalance + $transactionAmount;
        }
        $user->save();

        return $user->balance;

    }

    public static function addMissingDates($periodType, $data)
    {
        if ($periodType == Transaction::CHART_DAILY) {
            $periodStart = strtotime('-1 month');
            $interval = 'day';
        } elseif ($periodType == Transaction::CHART_MONTHLY) {
            $periodStart = strtotime('-1 year');
            $interval = 'month';
        } else {
            $periodStart = $data ? strtotime(array_keys($data)[0]) : 0;
            $interval = 'year';
        }


        for ($period = $periodStart; $period <= time(); $period = strtotime("+1 $interval", $period) ){
            $date = date(self::PHP_DATE_FORMATTERS[$periodType], $period);
            $data[$date] = $data[$date] ?? ['income' => 0, 'expense' => 0];
        }

        return $data;
    }

}
