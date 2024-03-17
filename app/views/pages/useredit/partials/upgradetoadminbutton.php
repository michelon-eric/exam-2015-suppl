<?php //
?>

<div class="mt-4 md:mb-12 max-w-2xl" id="rename-later-button">
    <button type="button" id="hx-upgrade-button" class="w-full py-3 px-4 inline-flex justify-center items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-700 dark:text-white dark:hover:bg-gray-800 dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600">
        <div hx-trigger="click from:#hx-upgrade-button" hx-get="{{base_url()}}partials/useredit/upgradetoadmin" hx-target="#form-content" hx-swap="innerHTML"></div>
        <div hx-trigger="click from:#hx-upgrade-button" hx-get="{{base_url()}}partials/useredit/upgradegobackbutton" hx-target="#rename-later-button" hx-swap="outerHtml"></div>
        Upgrade to Administrator
    </button>
    <div class="text-sm text-center text-gray-500">by upgrading to administrator you'll be able to manage your own centre</div>
</div>