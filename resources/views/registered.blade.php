<x-layout>

    <x-slot name="title">{{ trans('forumium.registered') }}</x-slot>

    <!-- Page content -->
    <div class="w-full flex justify-center items-center px-2 sm:px-4 py-10">
        <div class="container flex items-center justify-center py-10">
            <livewire:just-registered :user="session()->get('registered')" />
        </div>
    </div>

</x-layout>
