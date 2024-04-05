@props(['records', 'pageSize'])
@php
    // Insert empty padding rows to ensure consistent height
    $totalRecords = ceil(count($records) / $pageSize);
    $totalRows = $totalRecords * $pageSize;
    $remainingRows = $totalRows - count($records);
@endphp
@for ($i = 0; $i < $remainingRows; $i++)
    <tr class="select-none" role="presentation" x-show="currentPage * pageSize > {{ count($records) + $i }}" x-cloak>
        <td colspan="3">
            <div class="px-2 mb-1">&nbsp;</div>
        </td>
    </tr>
@endfor