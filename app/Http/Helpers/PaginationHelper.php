<?php

namespace App\Helpers;

class PaginationHelper
{
    public static function generateLinks($currentPage, $pageSize, $totalItems, $baseUrl)
    {
        $lastPage = ceil($totalItems / $pageSize);

        $links = [
            'first' => $baseUrl . '?page=1',
            'last' => $baseUrl . '?page=' . $lastPage,
            'prev' => $currentPage > 1 ? $baseUrl . '?page=' . ($currentPage - 1) : null,
            'next' => $currentPage < $lastPage ? $baseUrl . '?page=' . ($currentPage + 1) : null,
        ];

        return $links;
    }
}
