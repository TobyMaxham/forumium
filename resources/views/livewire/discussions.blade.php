<div class="flex flex-col gap-8 w-full">
    <form class="w-full">
        {{ $this->form }}
    </form>
    <div class="w-full flex flex-col gap-1">
        @if($selectedSort)
            <div class="text-slate-700 font-medium text-lg flex items-center gap-2">
                {{ $selectedSort }} <div wire:loading><i class="fa fa-spinner fa-spin"></i></div>
            </div>
        @endif
        @if($q)
            <span class="text-slate-700 font-medium text-sm">
                {{ trans('forumium.search_for') }}: {{ $q }}
            </span>
        @endif
    </div>
    <div class="w-full flex flex-col">
        @if($discussions->count())
            @foreach($discussions as $discussion)
                @include('partials.layouts.discussion-item', compact('discussion'))
            @endforeach
        @else
            <span class="text-slate-700 font-medium text-sm">
                @if($q)
                    {{ trans('forumium.no_discussions_available_for_your_current_search') }} @if(auth()->user() && auth()->user()->hasVerifiedEmail()) {{ trans('forumium.maybe_you_should_start_a_new_discussions') }} @endif
                @else
                    {{ trans('forumium.no_discussions_available_for_now') }} @if(auth()->user() && auth()->user()->hasVerifiedEmail()) {{ trans('forumium.please_come_back_later_or_start_a_new_discussion') }} @else {{ trans('forumium.please_come_back_later') }} @endif
                @endif
            </span>
        @endif
    </div>
    <div class="w-full flex flex-col justify-center items-center text-center gap-2">
        @if(!$disableLoadMore)
            <button type="button" wire:click="loadMore" wire:loading.attr="disabled"
                    class="bg-slate-100 disabled:bg-slate-50 px-3 py-2 text-slate-500 border-slate-100 rounded hover:cursor-pointer w-fit hover:bg-slate-200">
                {{ trans('forumium.load_more') }}
            </button>
        @endif
        @if($totalCount)
            <span class="text-xs text-slate-600">
                {{ trans_choice('forumium.showing_number_of_discussions', $totalCount, compact('limitPerPage', 'totalCount')) }}
            </span>
        @endif
    </div>
</div>
