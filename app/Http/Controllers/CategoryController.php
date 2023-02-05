<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use ProtoneMedia\Splade\SpladeTable;
use ProtoneMedia\Splade\Facades\Toast;
use App\Http\Requests\CategoryStoreRequest;

class CategoryController extends Controller
{
    public function index()
    {
        return view('categories.index', [
            'categories' => SpladeTable::for(Category::class)
                ->withGlobalSearch(columns: ['name'])
                ->column('name', canBeHidden:false, sortable:true)
                ->column('slug')
                ->column('action')
                ->paginate(5),
        ]);
    }

    public function create()
    {
        return view('categories.create');
    }

    public function store(CategoryStoreRequest $request)
    {
        Category::create($request->validated());

        Toast::title('New category added!')->autoDismiss(7);
        return redirect()->route('categories.index');
    }
}
