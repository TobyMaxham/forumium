@php($user = $user ?? auth()->user())
<x-layout-profile :user="$user">

    <x-slot name="title">{{ trans('forumium.profile') }} - {{ trans('forumium.following_discussions') }}</x-slot>

    <div class="w-full">
        <livewire:profile.discussions :user="$user" :follow="Followers::FOLLOWING->value" />
    </div>

</x-layout-profile>
