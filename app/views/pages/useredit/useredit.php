<?php

/** @var \Lib\Systems\Views\View $this */
$this->title = 'Edit Account Data';
$this->navbar = true;
$this->navbar_title = 'Edit Account Data';
?>

<?= $this->extend('layout/base') ?>

<?= $this->section('content') ?>

<div class="relative">
    <div class="max-w-[85rem] px-4 py-10 sm:px-6 lg:px-8 lg:py-14 mx-auto">
        <div class="grid items-center md:grid-cols-2 gap-8 lg:gap-12">
            <div>
                <p class="inline-block text-sm font-medium bg-clip-text bg-gradient-to-l from-blue-600 to-violet-500 text-transparent dark:from-blue-400 dark:to-violet-400">
                    <? //TODO: insert funny name of project                                                                                
                    ?>
                    Insert Funny Name Of Project
                </p>

                <div class="mt-4 md:mb-12 max-w-2xl">
                    <h1 class="mb-4 font-semibold text-gray-800 text-4xl lg:text-5xl dark:text-gray-200">
                        Edit your profile
                    </h1>
                    <p class="text-gray-600 dark:text-gray-400">
                        Here you can edit your personal data.
                        <br>
                        We won't share it with anyone.
                        <br>
                        We don't ask for things like gender cause gender is dumb
                    </p>
                </div>

                <?php if ($role !== 'Administrator' && $role !== 'Root') : ?>
                    <div class="mt-4 md:mb-12 max-w-2xl">
                        <button type="button" class="w-full py-3 px-4 inline-flex justify-center items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-700 dark:text-white dark:hover:bg-gray-800 dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600" hx-get="<?= base_url() ?>partials/useredit/upgradetoadmin" hx-target="#form-content" hx-swap="innerHTML" hx-get:after="<?= base_url() ?>partials/useredit/upgradegobackbutton" hx-target:after="#upgrade-btn-htmx" hx-swap:after="outerHtml">
                            Upgrade to Administrator
                        </button>
                        <div class="text-sm text-center text-gray-500">by upgrading to administrator you'll be able to manage your own centre</div>
                    </div>
                <?php endif; ?>
            </div>

            <div id="form-content" hx-get="<?= base_url() ?>partials/useredit/useredit" hx-trigger="load" hx-swap="innerHTML">

            </div>
        </div>
    </div>
</div>

<button class="hidden" data-hs-overlay="#update-output"></button>
<div id="update-output" class="hs-overlay hidden size-full fixed top-0 start-0 z-[80] overflow-x-hidden overflow-y-auto">
    <div class="hs-overlay-open:mt-7 hs-overlay-open:opacity-100 hs-overlay-open:duration-500 mt-0 opacity-0 ease-out transition-all sm:max-w-lg sm:w-full m-3 sm:mx-auto">
        <div class="relative flex flex-col bg-white shadow-lg rounded-xl dark:bg-gray-800">
            <div class="absolute top-2 end-2">
                <button type="button" class="flex justify-center items-center size-7 text-sm font-semibold rounded-lg border border-transparent text-gray-800 hover:bg-gray-100 disabled:opacity-50 disabled:pointer-events-none dark:text-white dark:border-transparent dark:hover:bg-gray-700 dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600" data-hs-overlay="#update-output">
                    <span class="sr-only">Close</span>
                    <svg class="flex-shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M18 6 6 18" />
                        <path d="m6 6 12 12" />
                    </svg>
                </button>
            </div>

            <div class="p-4 sm:p-10 text-center overflow-y-auto">
                <span class="mb-4 inline-flex justify-center items-center size-[46px] rounded-full border-4 border-green-50 bg-green-100 text-green-500 dark:bg-green-700 dark:border-green-600 dark:text-green-100">
                    <svg class="flex-shrink-0 size-5" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                        <path d="M11.251.068a.5.5 0 0 1 .227.58L9.677 6.5H13a.5.5 0 0 1 .364.843l-8 8.5a.5.5 0 0 1-.842-.49L6.323 9.5H3a.5.5 0 0 1-.364-.843l8-8.5a.5.5 0 0 1 .615-.09z" />
                    </svg>
                </span>

                <h3 class="mb-2 text-xl font-bold text-gray-800 dark:text-gray-200">
                    Profile successfully updated!
                </h3>
                <div class="mt-6 flex justify-center gap-x-4">
                    <button type="button" class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-700 dark:text-white dark:hover:bg-gray-800 dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600" data-hs-overlay="#update-output">
                        Thank you
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->end_section() ?>