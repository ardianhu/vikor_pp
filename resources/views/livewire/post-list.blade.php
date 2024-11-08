<div>
    <div class="mb-4">
        <input
            wire:model.live.debounce.300ms="search"
            type="text"
            placeholder="Search posts..."
            class="focus:ring-blue-500 w-full rounded-lg border px-4 py-2 focus:outline-none focus:ring-2" />
    </div>

    <div class="space-y-4">
        @foreach($posts as $post)
        <div class="rounded-lg bg-white p-6 shadow-md">
            <h2 class="mb-2 text-2xl font-bold">
                <a href="{{ route('posts.show', $post) }}" class="text-blue-600 hover:text-blue-800">{{ $post->title }}</a>
            </h2>
            <p class="text-gray-600 mb-2">By {{ $post->user->name }} on {{ $post->published_at }}</p>
            <p class="text-gray-700 mb-4">{{ Str::limit($post->content, 200) }}</p>
            <div class="flex flex-wrap gap-2">
                @foreach($post->tags as $tag)
                <span class="bg-blue-100 text-blue-800 rounded px-2.5 py-0.5 text-xs font-semibold">{{ $tag->name }}</span>
                @endforeach
            </div>
        </div>
        @endforeach
    </div>

    <div class="mt-4">{{ $posts->links() }}</div>
</div>