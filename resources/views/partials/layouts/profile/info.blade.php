<div class="flex flex-col justify-center items-start gap-3">
    <div class="flex items-center gap-3">
        <span class="text-xl font-medium text-white">
            {{ $user->name }}
        </span>
        @include('partials.layouts.profile.roles-tags', compact('user'))
    </div>
    <div class="w-full lg:flex lg:flex-row grid grid-cols-2 justify-start items-center lg:gap-5 gap-2 text-white text-xs">
        <span class="lg:flex lg:flex-row block justify-center lg:items-center items-start gap-2">
            <i class="fa-regular fa-clock"></i> {{ $user->updated_at->diffForHumans() }}
        </span>
        <span class="lg:flex lg:flex-row block justify-center lg:items-center items-start gap-2">
            <i class="fa-solid fa-sign-in"></i> {{ trans('forumium.joined') }} {{ $user->created_at->diffForHumans() }}
        </span>
        <span class="lg:flex lg:flex-row block justify-center lg:items-center items-start gap-2">
            <i class="fa-solid fa-check"></i> {{ $bestAnswers }} {{ trans_choice('forumium.best_answers', $bestAnswers) }}
        </span>
        <span class="lg:flex lg:flex-row block justify-center lg:items-center items-start gap-2">
            <i class="fa-solid fa-medal"></i> {{ $user->total_points }} {{ trans_choice('forumium.points', $user->total_points) }}
        </span>
    </div>
</div>
