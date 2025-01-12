@php($user = $user ?? auth()->user())
<x-layout-profile :user="$user">

    <x-slot name="title">{{ trans('forumium.profile') }} - {{ trans('forumium.ignoring_discussions') }}</x-slot>

    <div class="w-full">
        <livewire:profile.discussions :user="$user" :follow="Followers::IGNORING->value" />
    </div>

</x-layout-profile>
