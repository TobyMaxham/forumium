@if(
    (auth()->user() && auth()->user()->hasVerifiedEmail()) &&
    auth()->user()->can(Permissions::START_DISCUSSIONS->value)
)
    <button type="button" data-modal-toggle="add-discussion-modal" class="bg-blue-500 hover:bg-blue-600 hover:cursor-pointer px-3 py-2 rounded shadow hover:shadow-lg text-white font-medium text-center">
        {{ trans('forumium.start_a_discussion') }}
    </button>
@endif
<div class="w-full flex flex-col gap-5">
    <a href="{{ route('home') }}" class="w-full flex items-center {{ Route::is('home') ? 'text-blue-500 font-medium' : 'hover:text-blue-500 text-slate-500' }}">
        <span class="w-[30px]"><i class="fa-regular fa-comments"></i></span>
        <span>{{ trans('forumium.all_discussions') }}</span>
    </a>
    <a href="{{ route('tags') }}" class="w-full flex items-center {{ Route::is('tags') ? 'text-blue-500 font-medium' : 'hover:text-blue-500 text-slate-500' }}">
        <span class="w-[30px]"><i class="fa-solid fa-table-cells-large"></i></span>
        <span>{{ trans('forumium.tags') }}</span>
    </a>
</div>
<div class="w-full flex flex-col gap-5">
    <x-home.tags :tag="$tag ?? null" />
</div>
