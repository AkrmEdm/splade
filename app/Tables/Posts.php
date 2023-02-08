<?php

namespace App\Tables;

use App\Models\Post;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use ProtoneMedia\Splade\SpladeTable;
use Spatie\QueryBuilder\QueryBuilder;
use ProtoneMedia\Splade\AbstractTable;
use ProtoneMedia\Splade\Facades\Toast;
use Spatie\QueryBuilder\AllowedFilter;

class Posts extends AbstractTable
{
    /**
     * Create a new instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function authorize(Request $request): bool
    {
        return true;
    }

    /**
     * The resource or query builder.
     *
     * @return mixed
     */
    public function for()
    {
        return Post::query();
    }

    /**
     * Configure the given SpladeTable.
     *
     * @param \ProtoneMedia\Splade\SpladeTable $table
     * @return void
     */
    public function configure(SpladeTable $table): void
    {
        $globalSearch = AllowedFilter::callback('global', function ($query, $value) {
            $query->where(function ($query) use ($value) {
                Collection::wrap($value)->each(function ($value) use ($query) {
                    $query
                        ->orWhere('title', 'LIKE', "%{$value}%")
                        ->orWhere('slug', 'LIKE', "%{$value}%");
                });
            });
        });

        $posts = QueryBuilder::for(Post::class)
            ->defaultSort('title')
            ->allowedSorts(['title', 'slug'])
            ->allowedFilters(['title', 'slug', 'category_id', $globalSearch]);

        $categories = Category::pluck('name', 'id')->toArray();

        $table
            ->column('id', sortable: true)
            ->column('title', canBeHidden: false, sortable: true)
            ->withGlobalSearch(columns: ['title'])
            ->column('slug', sortable: true)
            ->column('updated_at')
            ->column('action', exportAs: false)
            ->selectFilter('category_id', $categories)
            ->export(label: 'Post Export')
            ->bulkAction(
                label: 'Touch timestamp',
                each: fn (Post $post) => $post->touch(),
                before: fn () => info('Touching the selected posts'),
                after: fn () => Toast::info('Timestamps updated!')
            )
            ->bulkAction(
                label: 'Delete Posts',
                each: fn (Post $post) => $post->delete(),
                after: fn () => Toast::info('Posts Deleted!')
            )
            ->paginate(5);

            // ->searchInput()
            // ->selectFilter()
            // ->withGlobalSearch()

            // ->bulkAction()
            // ->export()
    }
}
