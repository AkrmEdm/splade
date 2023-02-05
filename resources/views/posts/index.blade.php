<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Posts') }}
            </h2>
            <Link 
                href="{{ route('posts.create') }}" 
                class="px-4 py-2 bg-indigo-400 hover:bg-indigo-600 text-white rounded-md">
                {{ __('New Post') }}
            </Link>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-splade-table :for="$posts">
                @cell('action', $post)
                    <Link 
                        href="{{ route('posts.edit', $post->id) }}" 
                        class="text-green-600 hover:text-green-400 font-semibold">
                        {{ __('Edit') }}
                    </Link>
                @endcell
            </x-splade-table>
        </div>
    </div>
</x-app-layout>
