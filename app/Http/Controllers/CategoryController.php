<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;

class CategoryController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        $user = Auth::user();
        /* @var $user User */
        $categories = Category::query()
            ->where('user_id', $user->id)
            ->orWhereNull('user_id')
            ->paginate(config('app.usersPerPage', 10));

        return View::make('category.index', compact('categories'));
    }


    /**
     * @return \Illuminate\Contracts\View\View
     */
    public function create()
    {
        $category = new Category();
        return View::make('category.create', compact('category'));
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
            'name' => 'required',
            'type' => 'required',
        ]);

        $category = new Category([
            'name' => $request->get('name'),
            'type' => $request->get('type'),
            'user_id' => Auth::user()->id,
        ]);
        $category->save();

        return redirect('category')->with('success', 'Category saved!');
    }


    /**
     * @param int $id
     * @return \Illuminate\Contracts\View\View
     */
    public function edit($id)
    {
        $user = Auth::user();
        /* @var $user User */
        $category = Category::query()
            ->where('id', $id)
            ->where('user_id', $user->id)
            ->first();
        if ($category) {
            return View::make('category.edit', compact('category'));
        } else{
            return redirect('category')->with('error', 'Not Authorized!');
        }

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = Auth::user();
        /* @var $user User */
        $category = Category::query()
            ->where('id', $id)
            ->where('user_id', $user->id)
            ->first();
        if ($category) {
            /* @var $category Category*/
            $request->validate([
                'name' => 'required',
                'type' => 'required',
            ]);
            $category->update([
                'name' => $request->get('name'),
                'type' => $request->get('type'),
                'user_id' => $user->id,
            ]);

            return redirect('category')->with('success', 'Category updated!');
        }else {
            return redirect('category')->with('error', 'Not Authorized!');
        }

    }


    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy(int $id)
    {
        $user = Auth::user();
        /* @var $user User */
        $category = Category::query()
            ->where('id', $id)
            ->where('user_id', $user->id)
            ->first();

        if ($category) {
            $category->delete();
            return redirect()->route('category.index')->with('success', 'Category deleted!');
        } else{
            return redirect('category')->with('error', 'Not Authorized!');
        }

    }
}
