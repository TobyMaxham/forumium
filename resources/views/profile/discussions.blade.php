@php($user = $user ?? auth()->user())
<x-layout-profile :user="$user">

    <x-slot name="title">{{ trans('forumium.profile') }} - {{ trans('forumium.discussions') }}</x-slot>

    <div class="w-full">
        <livewire:profile.discussions :user="$user" />
    </div>

</x-layout-profile>
