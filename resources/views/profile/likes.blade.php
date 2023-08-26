@php($user = $user ?? auth()->user())
<x-layout-profile :user="$user">

    <x-slot name="title">{{ trans('forumium.profile') }} - {{ trans_choice('forumium.likes', 2) }}</x-slot>

    <div class="w-full">
        <livewire:profile.likes :user="$user" />
    </div>

</x-layout-profile>
