<div class="flex flex-row gap-5 w-full border-b border-slate-200 pb-5 mb-5">
    <img src="{{ $discussion->user->avatarUrl }}" alt="Avatar" class="rounded-full w-16 h-16" />
    <div class="w-full flex flex-col">
        <span class="text-slate-700 font-medium">{{ $discussion->user->name }}</span>
        <span class="text-slate-500 text-sm mt-1">{{ $discussion->created_at->diffForHumans() }}</span>
        <div class="w-full max-w-full prose mt-3 lg:pr-5 pr-0">
            {!! $discussion->content !!}
        </div>
        <div class="w-full flex items-center gap-5 text-slate-500 text-xs mt-5">
            <button type="button" class="flex items-center gap-2 hover:cursor-pointer" wire:click="toggleLike()">
                <i class="fa-regular fa-thumbs-up"></i> {{ $likes }} {{ $likes > 1 ? 'Likes' : 'Like' }}
            </button>
            <button wire:click="toggleComments()" type="button" class="flex items-center gap-2 hover:cursor-pointer">
                <i class="fa-regular fa-comment"></i> {{ $comments }} {{ $comments > 1 ? 'Comments' : 'Comment' }}
            </button>
            <div wire:loading>
                <i class="fa fa-spinner fa-spin"></i>
            </div>
        </div>
        @if($showComments)
            <div class="w-full flex flex-col gap-2 mt-5">
                <span class="text-slate-700 text-lg">
                    {{ $comments }} {{ $comments > 1 ? 'Comments' : 'Comment' }}
                </span>
                <div class="w-full flex flex-col gap-0 bg-slate-50 border-y border-slate-100">
                    @if($discussion->comments->count())
                        @foreach($discussion->comments as $c)
                            <div class="w-full py-5 px-3 text-slate-700 text-sm {{ $loop->last ? '' : 'border-b border-slate-200' }}">
                                <span class="font-medium">{{ $c->user->name }}</span> (<span class="text-xs">{{ $c->created_at->diffForHumans() }}</span>) - <span>{{ nl2br(e($c->content)) }}</span>
                            </div>
                        @endforeach
                    @else
                        <span class="text-slate-700 font-medium text-sm py-5 px-3">
                            No comments yet! Please come back later, or add a new comment.
                        </span>
                    @endif
                </div>
                @if($comment)
                    <form wire:submit.prevent="saveComment">
                        {{ $this->form }}
                        <!-- Modal footer -->
                        <div class="flex items-center space-x-2 rounded-b mt-2">
                            <button type="submit" wire:loading.attr="disabled" class="text-white bg-blue-700 disabled:bg-slate-300 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                Save comment
                            </button>
                            <button type="button" wire:click="cancelComment()" wire:loading.attr="disabled" class="text-white bg-slate-700 disabled:bg-slate-300 hover:bg-slate-800 focus:ring-4 focus:outline-none focus:ring-slate-300 font-medium rounded text-sm px-5 py-2.5 text-center dark:bg-slate-600 dark:hover:bg-slate-700 dark:focus:ring-slate-800">
                                Cancel
                            </button>
                        </div>
                    </form>
                @else
                    <button wire:click="addComment()" type="button" class="bg-slate-100 px-3 py-2 text-slate-500 text-sm border-slate-100 rounded hover:cursor-pointer w-fit hover:bg-slate-200">
                        Add comment
                    </button>
                @endif
            </div>
        @endif
    </div>
</div>
