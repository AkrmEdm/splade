<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use ProtoneMedia\Splade\SpladeTable;

class CategoryController extends Controller
{
    public function index()
    {
        return view('categories.index', [
            'categories' => SpladeTable::for(Category::class)
                ->withGlobalSearch(columns: ['name'])
                ->column('name', canBeHidden:false, sortable:true)
                ->column('slug')
                ->paginate(5),
        ]);
    }
}
