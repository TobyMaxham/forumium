<div
    class="bg-white shadow-lg rounded-lg p-10 border border-slate-200 flex flex-col justify-center items-center gap-6">
    <span class="text-lg text-slate-700 font-medium max-w-[80%] text-center">
        {{ trans('forumium.reset_your_password') }}
    </span>
    <span class="text-slate-600 text-center">
        {{ trans('forumium.choose_a_new_password_to_your_account_and_submit') }}
    </span>
    <form wire:submit.prevent="change" class="w-full">
        {{ $this->form }}
        <button type="submit" wire:loading.attr="disabled"
                class="mt-6 w-full text-white bg-blue-700 disabled:bg-slate-300 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
            {{ trans('forumium.change_your_password') }}
        </button>
    </form>
</div>
