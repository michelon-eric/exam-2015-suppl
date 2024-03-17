<?php //
?>

@foreach ($centres as $key => $centre)
<tr>
    <td class="size-px whitespace-nowrap"></td>
    <td class="size-px whitespace-nowrap">
        <div class="px-6 py-2">
            <a class="text-sm text-blue-600 decoration-2 hover:underline dark:text-blue-500" href="#"><?= $centre['CTR_Name'] ?></a>
        </div>
    </td>

    <td class="size-px whitespace-nowrap">
        <div class="px-6 py-2">
            <span class="text-sm text-gray-600 dark:text-gray-400"><?= $centre['CTR_TotalResourcesCount'] ?></span>
        </div>
    </td>

    <td class="size-px whitespace-nowrap">
        <div class="px-6 py-2">
            <span class="text-sm text-gray-600 dark:text-gray-400"><?= $centre['CTR_BookedResourcesCount'] ?></span>
        </div>
    </td>

    <td class="size-px whitespace-nowrap">
        <div class="px-6 py-2">
            <span class="text-sm text-gray-600 dark:text-gray-400"><?= $centre['CTR_BrokenResourcesCount'] ?></span>
        </div>
    </td>

    <td class="size-px whitespace-nowrap">
        <div class="px-6 py-2">
            <span class="text-sm text-gray-600 dark:text-gray-400"><?= $centre['CTR_CustomersCount'] ?></span>
        </div>
    </td>

    <td class="size-px whitespace-nowrap">
        <div class="px-6 py-2">
            <span class="text-sm text-gray-600 dark:text-gray-400"><?= $centre['CTR_ModeratorsCount'] ?></span>
        </div>
    </td>

    <td class="size-px whitespace-nowrap text-start">
        <div class="px-6 py-2">
            <?php $role = $centre['ROL_Role']; ?>
            <?php if ($role === 'Administrator' || $role === 'Root'): ?>
                <button type="button" class="min-w-20 max-w-20 w-20 py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-green-50 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-700 dark:text-white dark:hover:bg-green-800 dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-green-600">
                    <a class="max-w-full w-full text-center" hx-get="<?= base_url() ?>centres/centre/dashboard" hx-vals='{"centre": "<?= encrypt($centre['CTR_Id']) ?>"}'>Manage</a>
                </button>
                <button type="button" class="min-w-20 max-w-20 w-20 py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-red-50 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-700 dark:text-white dark:hover:bg-red-800 dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-red-600">
                    <a class="max-w-full w-full text-center" href="#">Delete</a>
                </button>
            <?php elseif ($role === 'Moderator'): ?>
                <button type="button" class="min-w-20 max-w-20 w-20 py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-green-50 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-700 dark:text-white dark:hover:bg-green-800 dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-green-600">
                    <a class="max-w-full w-full text-center" href="#">Manage</a>
                </button>
            <?php endif; ?>
        </div>
    </td>

    <td class="size-px whitespace-nowrap">
        <div class="px-6 py-2">
        </div>
    </td>
</tr>
@endforeach