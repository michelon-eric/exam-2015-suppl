<?php

/** @var \Lib\Systems\Views\View $this */
$this->nav_title = 'Dashboard';
$this->title = 'Dashboard';
?>

<?= $this->extend('layout/page') ?>

<?= $this->section('content') ?>

<!-- Table Section -->
<div class="max-w-full w-full px-4 py-10 sm:px-6 lg:px-8 lg:py-14 mx-auto">
    <!-- Card -->
    <div class="flex flex-col">
        <div class="-m-1.5 overflow-x-auto">
            <div class="p-1.5 min-w-full inline-block align-middle">
                <div
                     class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden dark:bg-slate-900 dark:border-gray-700">
                    <!-- Header -->
                    <div
                         class="px-6 py-4 grid gap-3 md:flex md:justify-between md:items-center border-b border-gray-200 dark:border-gray-700">
                        <!-- Input -->
                        <div class="sm:col-span-1">
                            <label for="hs-as-table-product-review-search" class="sr-only">Search</label>
                            <div class="relative">
                                <input type="text" id="hs-as-table-product-review-search"
                                       name="hs-as-table-product-review-search"
                                       class="py-2 px-3 ps-11 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400 dark:focus:ring-gray-600"
                                       placeholder="Search">
                                <div class="absolute inset-y-0 start-0 flex items-center pointer-events-none ps-4">
                                    <svg class="size-4 text-gray-400" xmlns="http://www.w3.org/2000/svg" width="16"
                                         height="16" fill="currentColor" viewBox="0 0 16 16">
                                        <path
                                              d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z" />
                                    </svg>
                                </div>
                            </div>
                        </div>
                        <!-- End Input -->

                        <div class="sm:col-span-2 md:grow">
                            <div class="flex justify-end gap-x-2">
                                <div class="hs-dropdown relative inline-block [--placement:bottom-right]"
                                     data-hs-overlay="#add-centre-modal">
                                    <button id="hs-as-table-table-filter-dropdown" type="button"
                                            class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-700 dark:text-white dark:hover:bg-gray-800 dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600">
                                        <svg class="flex-shrink-0 size-3.5" xmlns="http://www.w3.org/2000/svg"
                                             width="24" height="24" viewBox="0 0 24 24" fill="none"
                                             stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                             stroke-linejoin="round">
                                            <line x1="12" y1="5" x2="12" y2="19"></line>
                                            <line x1="5" y1="12" x2="19" y2="12"></line>
                                        </svg>
                                        Add
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End Header -->

                    <!-- Table -->
                    <table class="min-w-full w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-slate-800">
                            <tr>
                                <th scope="col" class="px-6 py-1 text-end"></th>

                                <th scope="col" class="px-6 py-3 text-start">
                                    <div class="flex items-center gap-x-2">
                                        <span
                                              class="text-xs font-semibold uppercase tracking-wide text-gray-800 dark:text-gray-200">
                                            Centre
                                        </span>
                                    </div>
                                </th>

                                <th scope="col" class="px-6 py-3 text-start">
                                    <div class="flex items-center gap-x-2">
                                        <span
                                              class="text-xs font-semibold uppercase tracking-wide text-gray-800 dark:text-gray-200">
                                            Total Resources
                                        </span>
                                    </div>
                                </th>

                                <th scope="col" class="px-6 py-3 text-start">
                                    <div class="flex items-center gap-x-2">
                                        <span
                                              class="text-xs font-semibold uppercase tracking-wide text-gray-800 dark:text-gray-200">
                                            Booked Resources
                                        </span>
                                    </div>
                                </th>

                                <th scope="col" class="px-6 py-3 text-start">
                                    <div class="flex items-center gap-x-2">
                                        <span
                                              class="text-xs font-semibold uppercase tracking-wide text-gray-800 dark:text-gray-200">
                                            Broken Resources
                                        </span>
                                    </div>
                                </th>

                                <th scope="col" class="px-6 py-3 text-start">
                                    <div class="flex items-center gap-x-2">
                                        <span
                                              class="text-xs font-semibold uppercase tracking-wide text-gray-800 dark:text-gray-200">
                                            Customers Count
                                        </span>
                                    </div>
                                </th>

                                <th scope="col" class="px-6 py-3 text-start">
                                    <div class="flex items-center gap-x-2">
                                        <span
                                              class="text-xs font-semibold uppercase tracking-wide text-gray-800 dark:text-gray-200">
                                            Moderators Count
                                        </span>
                                    </div>
                                </th>

                                <th scope="col" class="px-6 py-3 text-start">
                                    <div class="flex items-center gap-x-2">
                                        <span
                                              class="text-xs font-semibold uppercase tracking-wide text-gray-800 dark:text-gray-200">
                                            Actions
                                        </span>
                                    </div>
                                </th>

                                <th scope="col" class="px-6 py-1 text-end"></th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                            <?php foreach ($centres as $key => $centre): ?>
                                <tr>
                                    <!-- <th scope="col" class="px-6 py-3 text-start">
                                </th> -->
                                    <td class="size-px whitespace-nowrap"></td>
                                    <td class="size-px whitespace-nowrap">
                                        <div class="px-6 py-2">
                                            <a class="text-sm text-blue-600 decoration-2 hover:underline dark:text-blue-500"
                                               href="#"><?= $centre['CTR_Address'] ?></a>
                                        </div>
                                    </td>

                                    <td class="size-px whitespace-nowrap">
                                        <div class="px-6 py-2">
                                            <span
                                                  class="text-sm text-gray-600 dark:text-gray-400"><?= $centre['CTR_TotalResourcesCount'] ?></span>
                                        </div>
                                    </td>

                                    <td class="size-px whitespace-nowrap">
                                        <div class="px-6 py-2">
                                            <span
                                                  class="text-sm text-gray-600 dark:text-gray-400"><?= $centre['CTR_BookedResourcesCount'] ?></span>
                                        </div>
                                    </td>

                                    <td class="size-px whitespace-nowrap">
                                        <div class="px-6 py-2">
                                            <span
                                                  class="text-sm text-gray-600 dark:text-gray-400"><?= $centre['CTR_BrokenResourcesCount'] ?></span>
                                        </div>
                                    </td>

                                    <td class="size-px whitespace-nowrap">
                                        <div class="px-6 py-2">
                                            <span
                                                  class="text-sm text-gray-600 dark:text-gray-400"><?= $centre['CTR_CustomersCount'] ?></span>
                                        </div>
                                    </td>

                                    <td class="size-px whitespace-nowrap">
                                        <div class="px-6 py-2">
                                            <span
                                                  class="text-sm text-gray-600 dark:text-gray-400"><?= $centre['CTR_ModeratorsCount'] ?></span>
                                        </div>
                                    </td>

                                    <td class="size-px whitespace-nowrap text-start">
                                        <div class="px-6 py-2">
                                            <button type="button"
                                                    class="min-w-16 max-w-20 w-16 py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-green-50 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-700 dark:text-white dark:hover:bg-green-800 dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-green-600">
                                                <a class="max-w-full w-full text-center" href="#">Edit</a>
                                            </button>
                                            <button type="button"
                                                    class="min-w-16 max-w-20 w-16 py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-red-50 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-700 dark:text-white dark:hover:bg-red-800 dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-red-600">
                                                <a class="max-w-full w-full text-center" href="#">Delete</a>
                                            </button>
                                        </div>
                                    </td>

                                    <td class="size-px whitespace-nowrap">
                                        <div class="px-6 py-2">
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                    <!-- End Table -->

                    <!-- Footer -->
                    <div
                         class="px-6 py-4 grid gap-3 md:flex md:justify-between md:items-center border-t border-gray-200 dark:border-gray-700">
                        <div class="max-w-sm space-y-3">
                            <select
                                    class="py-2 px-3 pe-9 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400">
                                <option selected>1</option>
                                <option>2</option>
                            </select>
                        </div>

                        <div>
                            <div class="inline-flex gap-x-2">
                                <button type="button"
                                        class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-700 dark:text-white dark:hover:bg-gray-800 dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600"
                                        style="display: none;">
                                    <svg class="flex-shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24"
                                         height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                         stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="m15 18-6-6 6-6" />
                                    </svg>
                                    Prev
                                </button>

                                <button type="button"
                                        class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-700 dark:text-white dark:hover:bg-gray-800 dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600">
                                    Next
                                    <svg class="flex-shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24"
                                         height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                         stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="m9 18 6-6-6-6" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                    <!-- End Footer -->
                </div>
            </div>
        </div>
    </div>
    <!-- End Card -->
</div>
<!-- End Table Section -->

<!-- Add Modal -->
<div id="add-centre-modal"
     class="hs-overlay hidden size-full fixed top-0 start-0 z-[80] overflow-x-hidden overflow-y-auto">
    <div
         class="hs-overlay-open:mt-7 hs-overlay-open:opacity-100 hs-overlay-open:duration-500 mt-0 opacity-0 ease-out transition-all sm:max-w-lg sm:w-full m-3 sm:mx-auto">
        <div
             class="relative flex flex-col bg-white border shadow-sm rounded-xl overflow-hidden dark:bg-gray-800 dark:border-gray-700">
            <!-- Close Button -->
            <div class="absolute top-2 end-2">
                <button type="button"
                        class="flex justify-center items-center size-7 text-sm font-semibold rounded-lg border border-transparent text-gray-800 hover:bg-gray-100 disabled:opacity-50 disabled:pointer-events-none dark:text-white dark:border-transparent dark:hover:bg-gray-700 dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600"
                        data-hs-overlay="#add-centre-modal">
                    <span class="sr-only">Close</span>
                    <svg class="flex-shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                         viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                         stroke-linejoin="round">
                        <path d="M18 6 6 18" />
                        <path d="m6 6 12 12" />
                    </svg>
                </button>
            </div>
            <!-- End Close Button -->

            <div class="p-4 sm:p-10 overflow-y-auto">
                <div class="mb-6 text-center">
                    <h3 class="mb-2 text-xl font-bold text-gray-800 dark:text-gray-200">
                        Add new centre
                    </h3>
                    <p class="text-gray-500">
                        Insert all required data and click on <i>'create'</i>!
                    </p>
                </div>

                <form>
                    <div class="grid gap-y-4">
                        <div class="space-y-4">
                            <!-- Card -->
                            <div
                                 class="flex flex-col bg-white border shadow-sm rounded-xl dark:bg-gray-800 dark:border-gray-700">
                                <!-- Form Group -->
                                <div class="p-4 md:p-5">
                                    <label for="address" class="block text-sm mb-2 dark:text-white">
                                        Address
                                    </label>
                                    <div class="relative w-full">
                                        <input type="text" id="address" name="address"
                                               class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400 dark:focus:ring-gray-600"
                                               required aria-describedby="address-error">
                                        <div class="hidden absolute inset-y-0 end-0 pointer-events-none pe-3">
                                            <svg class="size-5 text-red-500" width="16" height="16" fill="currentColor"
                                                 viewBox="0 0 16 16" aria-hidden="true">
                                                <path
                                                      d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8 4a.905.905 0 0 0-.9.995l.35 3.507a.552.552 0 0 0 1.1 0l.35-3.507A.905.905 0 0 0 8 4zm.002 6a1 1 0 1 0 0 2 1 1 0 0 0 0-2z" />
                                            </svg>
                                        </div>
                                    </div>
                                    <p class="hidden text-xs text-red-600 mt-2" id="email-error">
                                        Please include a valid address for your centre
                                    </p>
                                </div>
                                <!-- Form Group -->

                                <!-- Form Group -->
                                <div class="p-4 md:p-5">
                                    <label for="city" class="block text-sm mb-2 dark:text-white">
                                        City
                                    </label>
                                    <div class="relative w-full">
                                        <input type="text" id="city" name="city"
                                               class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400 dark:focus:ring-gray-600"
                                               required aria-describedby="city-error">
                                        <div class="hidden absolute inset-y-0 end-0 pointer-events-none pe-3">
                                            <svg class="size-5 text-red-500" width="16" height="16" fill="currentColor"
                                                 viewBox="0 0 16 16" aria-hidden="true">
                                                <path
                                                      d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8 4a.905.905 0 0 0-.9.995l.35 3.507a.552.552 0 0 0 1.1 0l.35-3.507A.905.905 0 0 0 8 4zm.002 6a1 1 0 1 0 0 2 1 1 0 0 0 0-2z" />
                                            </svg>
                                        </div>
                                    </div>
                                    <p class="hidden text-xs text-red-600 mt-2" id="email-error">
                                        Please include a valid city for your centre
                                    </p>
                                </div>
                                <!-- Form Group -->

                                <!-- Form Group -->
                                <div class="p-4 md:p-5">
                                    <label for="phone-number" class="block text-sm mb-2 dark:text-white">
                                        Phone Number
                                    </label>
                                    <div class="relative w-full">
                                        <input type="text" id="phone-number" name="phone-number"
                                               class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400 dark:focus:ring-gray-600"
                                               required aria-describedby="phone-number-error">
                                        <div class="hidden absolute inset-y-0 end-0 pointer-events-none pe-3">
                                            <svg class="size-5 text-red-500" width="16" height="16" fill="currentColor"
                                                 viewBox="0 0 16 16" aria-hidden="true">
                                                <path
                                                      d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8 4a.905.905 0 0 0-.9.995l.35 3.507a.552.552 0 0 0 1.1 0l.35-3.507A.905.905 0 0 0 8 4zm.002 6a1 1 0 1 0 0 2 1 1 0 0 0 0-2z" />
                                            </svg>
                                        </div>
                                    </div>
                                    <p class="hidden text-xs text-red-600 mt-2" id="email-error">
                                        Please include a valid phone number for your centre
                                    </p>
                                </div>
                                <!-- Form Group -->

                                <!-- Form Group -->
                                <div class="p-4 md:p-5">
                                    <label for="email" class="block text-sm mb-2 dark:text-white">
                                        Email Address
                                    </label>
                                    <div class="relative w-full">
                                        <input type="text" id="email" name="email"
                                               class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400 dark:focus:ring-gray-600"
                                               required aria-describedby="email-error">
                                        <div class="hidden absolute inset-y-0 end-0 pointer-events-none pe-3">
                                            <svg class="size-5 text-red-500" width="16" height="16" fill="currentColor"
                                                 viewBox="0 0 16 16" aria-hidden="true">
                                                <path
                                                      d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8 4a.905.905 0 0 0-.9.995l.35 3.507a.552.552 0 0 0 1.1 0l.35-3.507A.905.905 0 0 0 8 4zm.002 6a1 1 0 1 0 0 2 1 1 0 0 0 0-2z" />
                                            </svg>
                                        </div>
                                    </div>
                                    <p class="hidden text-xs text-red-600 mt-2" id="email-error">
                                        Please include a valid email address for your centre
                                    </p>
                                </div>
                                <!-- Form Group -->

                            </div>
                            <!-- End Card -->
                        </div>
                    </div>
                </form>
            </div>

            <div
                 class="flex justify-end items-center gap-x-2 py-3 px-4 bg-gray-50 border-t dark:bg-gray-800 dark:border-gray-700">
                <button type="button"
                        class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-700 dark:text-white dark:hover:bg-gray-800 dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600"
                        data-hs-overlay="#add-centre-modal">
                    cancel
                </button>
                <button class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600"
                        hx-post="<?= base_url() ?>centre/add" hx-trigger="click" hx-swap="none"
                        hx-include="#address, #city, #email, #phone-number" hx-on::after-request="" hx-redirect="true">
                    create
                </button>
            </div>
        </div>
    </div>
</div>
<!-- End Add Modal -->

<?= $this->end_section() ?>