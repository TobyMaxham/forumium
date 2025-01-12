<!-- Sign up modal -->
<div id="sign-up-modal" tabindex="-1" aria-hidden="true" data-modal-backdrop="static" class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-modal md:h-full">
    <div class="relative w-full h-full max-w-md md:h-auto">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow dark:bg-slate-700">
            <button type="button" class="absolute top-3 right-2.5 text-slate-400 bg-transparent hover:bg-slate-200 hover:text-slate-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-slate-800 dark:hover:text-white" data-modal-toggle="sign-up-modal">
                <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                <span class="sr-only">{{ trans('forumium.close_modal') }}</span>
            </button>
            <div class="px-6 py-6 lg:px-8">
                <h3 class="mb-8 text-xl font-medium text-slate-900 dark:text-white">{{ trans('forumium.sign_up_to') }} {{ config('app.name') }}</h3>
                <livewire:layout.dialogs.register />
                @include('partials.dialogs.socials')
            </div>
        </div>
    </div>
</div>
