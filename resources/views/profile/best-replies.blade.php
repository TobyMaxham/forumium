@php($user = $user ?? auth()->user())
<x-layout-profile :user="$user">

    <x-slot name="title">{{ trans('forumium.profile') }} - {{ trans_choice('forumium.best_replies', 2) }}</x-slot>

    <div class="w-full">
        <livewire:profile.replies :user="$user" :isBest="true" />
    </div>

</x-layout-profile>
