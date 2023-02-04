<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use ProtoneMedia\Splade\SpladeTable;

class PostController extends Controller
{
    public function index()
    {
        return view('posts.index', [
            'posts' => SpladeTable::for(Post::class)
                ->withGlobalSearch(columns: ['title'])
                ->column('title', canBeHidden:false, sortable:true)
                ->column('slug')
                ->paginate(5),
        ]);
    }
}
