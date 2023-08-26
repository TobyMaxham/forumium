@php($user = $user ?? auth()->user())
<x-layout-profile :user="$user">

    <x-slot name="title">{{ trans('forumium.settings') }}</x-slot>

    <div class="w-full flex flex-col gap-3">
        <span class="font-medium text-slate-700">{{ trans('forumium.account') }}</span>
        <div class="w-full flex flex-wrap items-center gap-2">
            <button type="button" data-modal-toggle="change-password-modal" class="bg-slate-100 px-3 py-2 text-slate-500 text-sm border-slate-100 rounded hover:cursor-pointer w-fit hover:bg-slate-200">
                {{ trans('forumium.change_password') }}
            </button>
            <button type="button" data-modal-toggle="change-email-modal" class="bg-slate-100 px-3 py-2 text-slate-500 text-sm border-slate-100 rounded hover:cursor-pointer w-fit hover:bg-slate-200">
                {{ trans('forumium.change_email') }}
            </button>
            <button type="button" data-modal-toggle="change-username-modal" class="bg-slate-100 px-3 py-2 text-slate-500 text-sm border-slate-100 rounded hover:cursor-pointer w-fit hover:bg-slate-200">
                {{ trans('forumium.change_your_name') }}
            </button>
        </div>
    </div>
    <div class="w-full flex flex-col gap-3">
        <span class="font-medium text-slate-700">{{ trans('forumium.email_address') }}</span>
        <span class="text-xs text-slate-700">
            {{ trans('forumium.your_accounts_principal_email_address_is') }}: <span class="font-medium">{{ auth()->user()->email }}</span>
        </span>
    </div>
    <div class="w-full flex flex-col gap-3">
        <span class="font-medium text-slate-700">{{ trans('forumium.profile_details') }}</span>
        <span class="text-xs text-slate-700 mb-5">
            {{ trans('forumium.update_your_profile_information') }}
        </span>
        <livewire:profile.details />
    </div>
    <div class="w-full flex flex-col gap-3">
        <span class="font-medium text-slate-700">{{ trans('forumium.linked_accounts') }}</span>
        <span class="text-xs text-slate-700">
            {{ trans('forumium.these_linked_accounts_allow_you_to_sign_in') }}
        </span>
        <livewire:profile.socials />
    </div>
    <div class="w-full flex flex-col gap-3">
        <span class="font-medium text-slate-700">{{ trans('forumium.notifications') }}</span>
        <span class="text-xs text-slate-700 mb-5">
            {{ trans('forumium.choose_how_we_should_notify_you') }}
        </span>
        <livewire:profile.notifications />
    </div>

    {{-- DIALOGS --}}
    @include('partials.profile.dialogs.password')
    @include('partials.profile.dialogs.email')
    @include('partials.profile.dialogs.username')

</x-layout-profile>
