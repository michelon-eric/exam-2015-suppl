<?php
/** @var \Lib\Systems\Views\View $this */
$this->navbar = true;
$this->navbar_title = 'Frequenty Asked Questions';
$this->title = 'Faq';
?>

<?= $this->extend('layout/base') ?>

<?= $this->section('content') ?>

<div class="max-w-[85rem] px-4 py-10 sm:px-6 lg:px-8 lg:py-14 mx-auto">
    <div class="grid md:grid-cols-5 gap-10">
        <div class="md:col-span-2">
            <div class="max-w-xs">
                <h2 class="text-2xl font-bold md:text-4xl md:leading-tight dark:text-white">Frequently<br>asked
                    questions</h2>
                <p class="mt-1 hidden md:block text-gray-600 dark:text-gray-400">Answers to the most frequently asked
                    questions.</p>
            </div>
        </div>

        <div class="md:col-span-3">
            <div class="hs-accordion-group divide-y divide-gray-200 dark:divide-gray-700">
                <div class="hs-accordion pt-6 pb-3" id="hs-basic-with-title-and-arrow-stretched-heading-three">
                    <button class="hs-accordion-toggle group pb-3 inline-flex items-center justify-between gap-x-3 w-full md:text-lg font-semibold text-start text-gray-800 rounded-lg transition hover:text-gray-500 dark:text-gray-200 dark:hover:text-gray-400 dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600"
                            aria-controls="hs-basic-with-title-and-arrow-stretched-collapse-three">
                        How can I add a new centre?
                        <svg class="hs-accordion-active:hidden block flex-shrink-0 size-5 text-gray-600 group-hover:text-gray-500 dark:text-gray-400"
                             xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                             stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="m6 9 6 6 6-6" />
                        </svg>
                        <svg class="hs-accordion-active:block hidden flex-shrink-0 size-5 text-gray-600 group-hover:text-gray-500 dark:text-gray-400"
                             xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                             stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="m18 15-6-6-6 6" />
                        </svg>
                    </button>
                    <div id="hs-basic-with-title-and-arrow-stretched-collapse-three"
                         class="hs-accordion-content hidden w-full overflow-hidden transition-[height] duration-300"
                         aria-labelledby="hs-basic-with-title-and-arrow-stretched-heading-three">
                        <p class="text-gray-600 dark:text-gray-400">
                            Only an administrator can add a new centre. If you're an administrator simply go in your
                            dashboard and click the <i>add new centre</i> button, from there just follow the
                            instructions on screen
                            <br>
                            If you're a moderator you can only manage a centre after you've been added as its moderator
                            by the administrator of said centre
                        </p>
                    </div>
                </div>

                <div class="hs-accordion pt-6 pb-3" id="hs-basic-with-title-and-arrow-stretched-heading-three">
                    <button class="hs-accordion-toggle group pb-3 inline-flex items-center justify-between gap-x-3 w-full md:text-lg font-semibold text-start text-gray-800 rounded-lg transition hover:text-gray-500 dark:text-gray-200 dark:hover:text-gray-400 dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600"
                            aria-controls="hs-basic-with-title-and-arrow-stretched-collapse-three">
                        How can I add a new resource?
                        <svg class="hs-accordion-active:hidden block flex-shrink-0 size-5 text-gray-600 group-hover:text-gray-500 dark:text-gray-400"
                             xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                             stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="m6 9 6 6 6-6" />
                        </svg>
                        <svg class="hs-accordion-active:block hidden flex-shrink-0 size-5 text-gray-600 group-hover:text-gray-500 dark:text-gray-400"
                             xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                             stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="m18 15-6-6-6 6" />
                        </svg>
                    </button>
                    <div id="hs-basic-with-title-and-arrow-stretched-collapse-three"
                         class="hs-accordion-content hidden w-full overflow-hidden transition-[height] duration-300"
                         aria-labelledby="hs-basic-with-title-and-arrow-stretched-heading-three">
                        <p class="text-gray-600 dark:text-gray-400">
                            Select a centre in the dashboard and then click on the <i>add new resource</i> button that
                            comes up in the next page
                        </p>
                    </div>
                </div>

                <div class="hs-accordion pt-6 pb-3" id="hs-basic-with-title-and-arrow-stretched-heading-three">
                    <button class="hs-accordion-toggle group pb-3 inline-flex items-center justify-between gap-x-3 w-full md:text-lg font-semibold text-start text-gray-800 rounded-lg transition hover:text-gray-500 dark:text-gray-200 dark:hover:text-gray-400 dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600"
                            aria-controls="hs-basic-with-title-and-arrow-stretched-collapse-three">
                        How can I book a resource?
                        <svg class="hs-accordion-active:hidden block flex-shrink-0 size-5 text-gray-600 group-hover:text-gray-500 dark:text-gray-400"
                             xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                             stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="m6 9 6 6 6-6" />
                        </svg>
                        <svg class="hs-accordion-active:block hidden flex-shrink-0 size-5 text-gray-600 group-hover:text-gray-500 dark:text-gray-400"
                             xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                             stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="m18 15-6-6-6 6" />
                        </svg>
                    </button>
                    <div id="hs-basic-with-title-and-arrow-stretched-collapse-three"
                         class="hs-accordion-content hidden w-full overflow-hidden transition-[height] duration-300"
                         aria-labelledby="hs-basic-with-title-and-arrow-stretched-heading-three">
                        <p class="text-gray-600 dark:text-gray-400">
                            To book a resource you need to login as a regular user from the initial page.
                            Hover over <i>Account</i> in the navbar and click on <i>Log out</i> from there login as a
                            regular user.
                            <br>
                            Remember that the accounts used for managing and booking are different so you might need to
                            register as regular user as well.
                            <br>
                            To make it easier for you you can use the same email for both accounts
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->end_section() ?>