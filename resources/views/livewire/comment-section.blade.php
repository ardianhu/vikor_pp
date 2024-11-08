<div>
    <h3 class="mb-4 text-2xl font-bold">Comments</h3>

    @foreach($post->comments as $comment)
    <div class="bg-gray-100 mb-4 rounded-lg p-4">
        <p class="text-gray-800">{{ $comment->content }}</p>
        <p class="text-gray-600 mt-2 text-sm">
            By {{ $comment->user->name }} on {{ $comment->created_at }} @if($comment->user_id ===
            auth()->id()) |
            <button wire:click="deleteComment({{ $comment->id }})" class="text-red-500 hover:underline">
                Delete
            </button>
            @endif
        </p>
    </div>
    @endforeach @auth
    <form wire:submit.prevent="addComment" class="mt-6">
        <div class="mb-4">
            <label for="newComment" class="text-gray-700 mb-2 block font-bold">Add a comment</label>
            <textarea
                wire:model="newComment"
                id="newComment"
                rows="3"
                class="text-gray-700 w-full rounded-lg border px-3 py-2 focus:outline-none"
                required></textarea>
            @error('newComment') <span class="text-red-500">{{ $message }}</span> @enderror
        </div>
        <button
            type="submit"
            class="bg-blue-500 hover:bg-blue-700 rounded px-4 py-2 font-bold text-white">
            Post Comment
        </button>
    </form>
    @else
    <p class="text-gray-600 mt-6">
        Please <a href="{{ route('login') }}" class="text-blue-500 hover:underline">log in</a> to leave
        a comment.
    </p>
    @endauth
</div>