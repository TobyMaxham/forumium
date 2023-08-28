@php
    $routePrefix = (auth()->user()->id == $user->id ? 'profile' : 'user');
    $routeParams = [];
    if ($routePrefix == 'user') {
        $routeParams['user'] = $user;
        $routeParams['slug'] = Str::slug($user->name);
    }
@endphp
<div class="w-full flex lg:flex-col flex-row lg:overflow-hidden overflow-auto lg:text-base text-xs">

    <a href="{{ route($routePrefix . '.index', $routeParams) }}" class="lg:min-w-full min-w-[130px] lg:w-full w-fit lg:p-0 p-3 lg:bg-transparent lg:mb-5 mb-0 lg:border-y-0 border-y lg:border-r-0 border-r border-slate-200 flex lg:justify-start justify-center lg:text-left text-center items-center gap-1 {{ Route::is($routePrefix . '.index') ? 'lg:text-blue-500 lg:bg-transparent text-white bg-blue-500' : 'lg:hover:text-blue-500 lg:text-slate-500 lg:hover:bg-transparent hover:bg-blue-500 hover:text-white' }}">
        <i class="fa-regular fa-user"></i>
        <span>
            @if(auth()->user()->id == $user->id)
                {{ trans('forumium.my_profile') }}
            @else
                {{ trans('forumium.profile') }}
            @endif
        </span>
    </a>

    <a href="{{ route($routePrefix . '.discussions', $routeParams) }}" class="lg:min-w-full min-w-[130px] lg:w-full w-fit lg:p-0 p-3 lg:bg-transparent lg:mb-5 mb-0 lg:border-y-0 border-y lg:border-x-0 border-x border-slate-200 flex lg:justify-start justify-center lg:text-left text-center items-center gap-1 {{ Route::is($routePrefix . '.discussions') ? 'lg:text-blue-500 lg:bg-transparent text-white bg-blue-500' : 'lg:hover:text-blue-500 lg:text-slate-500 lg:hover:bg-transparent hover:bg-blue-500 hover:text-white' }} @if(auth()->user()->id == $user->id) lg:mt-5 mt-0 @endif">
        <i class="fa-solid fa-bars"></i>
        <span>{{ trans('forumium.discussions') }}</span>
    </a>
    @if(auth()->user()->id == $user->id)
        <a href="{{ route($routePrefix . '.following-discussions', $routeParams) }}" class="lg:min-w-full min-w-[130px] lg:w-full w-fit lg:p-0 p-3 lg:bg-transparent lg:mb-5 mb-0 lg:border-y-0 border-y lg:border-x-0 border-x border-slate-200 flex lg:justify-start justify-center lg:text-left text-center items-center gap-1 {{ Route::is($routePrefix . '.following-discussions') ? 'lg:text-blue-500 lg:bg-transparent text-white bg-blue-500' : 'lg:hover:text-blue-500 lg:text-slate-500 lg:hover:bg-transparent hover:bg-blue-500 hover:text-white' }}">
            <i class="fa-solid fa-star"></i>
            <span>{{ trans('forumium.following') }}</span>
        </a>
        <a href="{{ route($routePrefix . '.not-following-discussions', $routeParams) }}" class="lg:min-w-full min-w-[130px] lg:w-full w-fit lg:p-0 p-3 lg:bg-transparent lg:mb-5 mb-0 lg:border-y-0 border-y lg:border-x-0 border-x border-slate-200 flex lg:justify-start justify-center lg:text-left text-center items-center gap-1 {{ Route::is($routePrefix . '.not-following-discussions') ? 'lg:text-blue-500 lg:bg-transparent text-white bg-blue-500' : 'lg:hover:text-blue-500 lg:text-slate-500 lg:hover:bg-transparent hover:bg-blue-500 hover:text-white' }}">
            <i class="fa-regular fa-star"></i>
            <span>{{ trans('forumium.not_following') }}</span>
        </a>
        <a href="{{ route($routePrefix . '.ignoring-discussions', $routeParams) }}" class="lg:min-w-full min-w-[130px] lg:w-full w-fit lg:p-0 p-3 lg:bg-transparent lg:mb-5 mb-0 lg:border-y-0 border-y lg:border-x-0 border-x border-slate-200 flex lg:justify-start justify-center lg:text-left text-center items-center gap-1 {{ Route::is($routePrefix . '.ignoring-discussions') ? 'lg:text-blue-500 lg:bg-transparent text-white bg-blue-500' : 'lg:hover:text-blue-500 lg:text-slate-500 lg:hover:bg-transparent hover:bg-blue-500 hover:text-white' }}">
            <i class="fa-regular fa-eye-slash"></i>
            <span>{{ trans('forumium.ignoring') }}</span>
        </a>
    @endif
    <a href="{{ route($routePrefix . '.replies', $routeParams) }}" class="lg:min-w-full min-w-[130px] lg:w-full w-fit lg:p-0 p-3 lg:bg-transparent lg:mb-5 mb-0 lg:border-y-0 border-y lg:border-r-0 border-r border-slate-200 flex lg:justify-start justify-center lg:text-left text-center items-center gap-1 {{ Route::is($routePrefix . '.replies') ? 'lg:text-blue-500 lg:bg-transparent text-white bg-blue-500' : 'lg:hover:text-blue-500 lg:text-slate-500 lg:hover:bg-transparent hover:bg-blue-500 hover:text-white' }} lg:mt-5 mt-0">
        <i class="fa-regular fa-comment"></i>
        <span>{{ trans_choice('forumium.replies', 2) }}</span>
    </a>
    <a href="{{ route($routePrefix . '.best-replies', $routeParams) }}" class="lg:min-w-full min-w-[130px] lg:w-full w-fit lg:p-0 p-3 lg:bg-transparent lg:mb-5 mb-0 lg:border-y-0 border-y lg:border-r-0 border-r border-slate-200 flex lg:justify-start justify-center lg:text-left text-center items-center gap-1 {{ Route::is($routePrefix . '.best-replies') ? 'lg:text-blue-500 lg:bg-transparent text-white bg-blue-500' : 'lg:hover:text-blue-500 lg:text-slate-500 lg:hover:bg-transparent hover:bg-blue-500 hover:text-white' }}">
        <i class="fa-solid fa-check-to-slot"></i>
        <span>{{ trans_choice('forumium.best_replies', 2) }}</span>
    </a>
    <a href="{{ route($routePrefix . '.comments', $routeParams) }}" class="lg:min-w-full min-w-[130px] lg:w-full w-fit lg:p-0 p-3 lg:bg-transparent lg:mb-5 mb-0 lg:border-y-0 border-y lg:border-r-0 border-r border-slate-200 flex lg:justify-start justify-center lg:text-left text-center items-center gap-1 {{ Route::is($routePrefix . '.comments') ? 'lg:text-blue-500 lg:bg-transparent text-white bg-blue-500' : 'lg:hover:text-blue-500 lg:text-slate-500 lg:hover:bg-transparent hover:bg-blue-500 hover:text-white' }}">
        <i class="fa-regular fa-comments"></i>
        <span>{{ trans_choice('forumium.comments', 2) }}</span>
    </a>
    <a href="{{ route($routePrefix . '.likes', $routeParams) }}" class="lg:min-w-full min-w-[130px] lg:w-full w-fit lg:p-0 p-3 lg:bg-transparent lg:mb-5 mb-0 lg:border-y-0 border-y lg:border-r-0 border-r border-slate-200 flex lg:justify-start justify-center lg:text-left text-center items-center gap-1 {{ Route::is($routePrefix . '.likes') ? 'lg:text-blue-500 lg:bg-transparent text-white bg-blue-500' : 'lg:hover:text-blue-500 lg:text-slate-500 lg:hover:bg-transparent hover:bg-blue-500 hover:text-white' }}">
        <i class="fa-regular fa-thumbs-up"></i>
        <span>{{ trans_choice('forumium.likes', 2) }}</span>
    </a>

    @if(auth()->user()->id == $user->id)
        <a href="{{ route($routePrefix . '.settings', $routeParams) }}" class="lg:min-w-full min-w-[130px] lg:w-full w-fit lg:p-0 p-3 lg:bg-transparent lg:mb-5 mb-0 lg:border-y-0 border-y lg:border-r-0 border-r border-slate-200 flex lg:justify-start justify-center lg:text-left text-center items-center gap-1 {{ Route::is($routePrefix . '.settings') ? 'lg:text-blue-500 lg:bg-transparent text-white bg-blue-500' : 'lg:hover:text-blue-500 lg:text-slate-500 lg:hover:bg-transparent hover:bg-blue-500 hover:text-white' }} lg:mt-5 mt-0">
            <i class="fa-solid fa-cog"></i>
            <span>{{ trans('forumium.settings') }}</span>
        </a>
    @endif
</div>
