<footer class="mt-auto py-6 px-8 border-t border-gray-200 dark:border-slate-800 bg-white dark:bg-slate-900">
    <div class="flex flex-col md:flex-row justify-between items-center gap-4">
        <p class="text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-widest">
            &copy; {{ date('Y') }} {{ $siteSettings['name'] }}. All rights reserved.
        </p>
        <div class="flex items-center gap-4">
            <span class="text-[10px] font-black text-red-600 uppercase tracking-[0.2em]">v1.0.0</span>
        </div>
    </div>
</footer>
