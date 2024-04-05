<tr>
    <td colspan="3" class="text-sm pt-3">
        <div x-show="totalPages > 1" x-cloak="" class="flex justify-between">
            <button @click="currentPage = currentPage > 1 ? currentPage - 1 : 1">Previous</button>
            <span class="mx-2">Page <span x-text="currentPage"></span> of <span x-text="totalPages"></span></span>
            <button @click="currentPage = currentPage < totalPages ? currentPage + 1 : totalPages">Next</button>
        </div>
        <div x-show="totalPages == 1" x-cloak="" class="text-center opacity-75">
            Showing <span x-text="currentPage"></span> of <span x-text="totalPages"></span> pages
        </div>
    </td>
</tr>