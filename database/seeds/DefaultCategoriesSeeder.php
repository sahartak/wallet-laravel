<?php

use App\Models\Category;
use Illuminate\Database\Seeder;

class DefaultCategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach($this->defaultData() as $categoryData){
            Category::query()->create($categoryData);
        }
    }

    public function defaultData()
    {
        return [
            [
                'name' => 'Salary',
                'type' => Category::TYPE_INCOME,
            ],
            [
                'name' => 'Bonuses',
                'type' => Category::TYPE_INCOME,
            ],
            [
                'name' => 'Overtime',
                'type' => Category::TYPE_INCOME,
            ],
            [
                'name' => 'Food & Drinks',
                'type' => Category::TYPE_EXPENSE,
            ],
            [
                'name' => 'Shopping',
                'type' => Category::TYPE_EXPENSE,
            ],
            [
                'name' => 'Housing',
                'type' => Category::TYPE_EXPENSE,
            ],
            [
                'name' => 'Transportation',
                'type' => Category::TYPE_EXPENSE,
            ],
        ];

    }
}
