<?php

namespace App\Helpers;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class PaginatorHelper {

    const ITEMS_PER_PAGE = 10;

    /**
     * Paginate a collection
     * 
     * @param Collection $data The data
     * @param int $data_count_all The number of all data
     * @param int $current_page The current page number
     * @param Request $request The request object
     * @param int $items_per_page The amount of items per page
     * 
     * @return LengthAwarePaginator
     */
    public static function paginate(Collection $data, int $data_count_all, int $current_page, Request $request, int $items_per_page = self::ITEMS_PER_PAGE) {
        return new LengthAwarePaginator($data, $data_count_all, $items_per_page, $current_page, [
            'path' => $request->url(),
            'query' => $request->query()
        ]);
    }

    public static function offset(int $current_page, int $items_per_page = self::ITEMS_PER_PAGE) {
        return (($current_page - 1) * $items_per_page);
    }
}