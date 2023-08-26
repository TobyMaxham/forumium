<div class="bg-white shadow-lg rounded-lg p-10 border border-slate-200 flex flex-col text-center justify-center items-center space-y-6">
    <span class="text-lg text-slate-700 font-medium max-w-[80%]">
        {{ trans('forumium.thanks_for_signing_up_for') }} {{ config('app.name') }}
    </span>
    <i class="fa-regular fa-envelope text-blue-500 fa-3x"></i>
    <span class="text-slate-600 max-w-[80%]">
        {{ trans('forumium.were_happy_youre_here_check_your_inbox_to_verify') }}
    </span>
    <button type="button" wire:click="resend()" wire:loading.attr="disabled" class="w-fit mt-6 text-white bg-blue-700 disabled:bg-slate-300 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
        {{ trans('forumium.resent_verification_email') }}
    </button>
    <span class="text-slate-600 text-sm max-w-[80%]">
        {{ trans('forumium.if_youve_not_received_the_verification_email_click_above') }}
    </span>
</div>
