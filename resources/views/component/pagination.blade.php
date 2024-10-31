@props(['totalShwon', 'totalItem'])

<p class="hidden md:block text-sm text-font_secondary">Showing
    <span id="totalShown">{{ $totalShown }}</span> of
    <span id="totalItem">{{ $totalItem }}</span> results
</p>
<div class="flex gap-2">
    <button type="button" class="button p-2 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-md border border-button hover:bg-background hover:text-button focus:z-10 focus:ring-4 focus:ring-button/15 dark:focus:ring-button/15 dark:bg-background dark:text-button dark:border-button dark:hover:text-white dark:hover:bg-background text-nowrap disabled:cursor-not-allowed disabled:border-font_secondary disabled:text-font_secondary">
        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd"></path>
        </svg>
    </button>
    <button type="button" class="button p-2 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-md border border-button hover:bg-background hover:text-button focus:z-10 focus:ring-4 focus:ring-button/15 dark:focus:ring-button/15 dark:bg-background dark:text-button dark:border-button dark:hover:text-white dark:hover:bg-background text-nowrap disabled:cursor-not-allowed disabled:border-font_secondary disabled:text-font_secondary">
        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
        </svg>
    </button>
</div>
