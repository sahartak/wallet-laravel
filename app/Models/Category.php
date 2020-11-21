<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Eloquent class Category
 * @property int $id
 * @property string $name
 * @property integer $type
 * @property integer $user_id
 * @property string $created_at
 * @property string $updated_at
 */
class Category extends Model
{
    const TYPE_EXPENSE = 0;
    const TYPE_INCOME = 1;

    protected $guarded = [];

    const TYPES = [
        self::TYPE_EXPENSE => 'Expense',
        self::TYPE_INCOME => 'Income',
    ];

    /**
     * Returns user relation
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
}
