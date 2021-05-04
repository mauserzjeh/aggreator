<?php

namespace App\Http\Controllers\Frontend;

use App\Helpers\PaginatorHelper;
use App\Http\Controllers\Controller;
use App\Models\Discount;
use Illuminate\Http\Request;

class DiscountController extends Controller {

    public function index(Request $request) {
        $filter = $request->only([
            'filter-id',
            'filter-name',
            'filter-percent',
            'filter-relation-percent',
            'filter-start_timestamp',
            'filter-relation-start_timestamp',
            'filter-end_timestamp',
            'filter-relation-end_timestamp'
        ]);

        $user = auth()->user();
        $data = Discount::where('user_id', $user->id);
        //TODO filters

        $current_page = $request->input('page') ?? 1;
        $offset = PaginatorHelper::offset($current_page);

        $data->offset($offset)
            ->limit(PaginatorHelper::ITEMS_PER_PAGE);

        $data_count_all = Discount::where('user_id', $user->id)->count();
        $discounts = PaginatorHelper::paginate($data->get(), $data_count_all, $current_page, $request);

        return view('discounts.index', [
            'discounts' => $discounts
        ]);
    }
}