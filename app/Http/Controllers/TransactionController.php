<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Transaction;
use App\Models\User;
use App\Rules\EnoughBalance;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;

class TransactionController extends Controller
{

    /**
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        $user = Auth::user();
        /* @var $user User*/
        $transactions = $user->transactions()->paginate(config('app.usersPerPage', 10));
        $totalIncome = $user->transactionsSum(Category::TYPE_INCOME);
        $totalExpense = $user->transactionsSum(Category::TYPE_EXPENSE);
        return View::make('transaction.index', compact('transactions', 'totalExpense', 'totalIncome'));
    }

    /**
     * @return \Illuminate\Contracts\View\View
     */
    public function create()
    {
        $user = Auth::user();
        /* @var $user User */
        $userCategories = Category::query()
            ->where('user_id', $user->id)
            ->orWhereNull('user_id');
        $categories = $userCategories->pluck('name', 'id')->toArray();
        $categoryTypes = $userCategories->pluck('type', 'id')->toArray();

        return View::make('transaction.create', compact( 'categories', 'categoryTypes'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'amount' => ['required', new EnoughBalance($request->get('category_id'))],
            'category_id' => 'required',
        ]);

        $transaction= new Transaction([
            'amount' => $request->get('amount'),
            'category_id' => $request->get('category_id'),
            'note' => $request->get('note'),
            'user_id' => Auth::user()->id
        ]);
        $transaction->save();
        $transaction->updateBalance();

        return redirect('transaction')->with('success', 'Transaction saved!');
    }


    /**
     * Displays transactions chart
     * @param Request $request
     * @return \Illuminate\Contracts\View\View
     */
    public function transactionChart(Request $request)
    {
        $periodType = $request->get('type') ?? Transaction::CHART_DAILY;
        $user = Auth::user();
        /* @var $user User*/

        $format = Transaction::CHART_FORMATTERS[$periodType];
        $transactionsExpense = $user->transactionGrouping(Category::TYPE_EXPENSE, $format, $periodType);
        $transactionsIncome = $user->transactionGrouping(Category::TYPE_INCOME, $format, $periodType);
        $result = [];
        foreach ($transactionsExpense as $expense){
            $result[$expense['data']] = [
                'income' => 0,
                'expense' => $expense['amountSum']
            ];
        }
        foreach ($transactionsIncome as $income){
            $result[$income['data']] = $result[$income['data']] ?? ['expense' => 0];
            $result[$income['data']]['income'] = $income['amountSum'];
        }

        $result = Transaction::addMissingDates($periodType, $result);
        ksort($result);
        $dates = array_keys($result);
        $values = array_values($result);
        $income = array_column($values, 'income');
        $expense = array_column($values, 'expense');

        return View::make('transaction.chart', compact('dates', 'income', 'expense', 'periodType'));
    }

}
