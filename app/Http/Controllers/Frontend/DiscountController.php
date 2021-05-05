<?php

namespace App\Http\Controllers\Frontend;

use App\Helpers\PaginatorHelper;
use App\Http\Controllers\Controller;
use App\Models\Discount;
use Illuminate\Http\Request;
use App\Http\Requests\DiscountRequest;

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
        if(array_key_exists('filter-id', $filter) && $filter['filter-id']) {
            $data->where('id', $filter['filter-id']);
        }
        if(array_key_exists('filter-name', $filter) && $filter['filter-name']) {
            $data->where('name', 'LIKE', '%' . $filter['filter-name'] . '%');
        }
        if(array_key_exists('filter-percent', $filter) && $filter['filter-percent'] != '') {
            $data->where('amount_percent', $filter['filter-relation-percent'], $filter['filter-percent']);
        }
        if(array_key_exists('filter-start_timestamp', $filter) && $filter['filter-start_timestamp']) {
            $data->where('start_timestamp', $filter['filter-relation-start_timestamp'], $filter['filter-start_timestamp']);
        }
        if(array_key_exists('filter-end_timestamp', $filter) && $filter['filter-end_timestamp']) {
            $data->where('end_timestamp', $filter['filter-relation-end_timestamp'], $filter['filter-end_timestamp']);
        }
        
        $current_page = $request->input('page') ?? 1;
        $offset = PaginatorHelper::offset($current_page);

        $data->offset($offset)
            ->limit(PaginatorHelper::ITEMS_PER_PAGE);

        $data_count_all = Discount::where('user_id', $user->id)->count();
        $discounts = PaginatorHelper::paginate($data->get(), $data_count_all, $current_page, $request);

        $active_array = [
            0 => 'Inactive',
            1 => 'Active'
        ];

        foreach($discounts as $discount) {
            $discount->amount_percent = $discount->amount_percent . '%';
            $discount->active = $active_array[$discount->active];
        }

        return view('discounts.index', [
            'discounts' => $discounts
        ]);
    }

    public function edit(Request $request, $discountId) {
        $user = auth()->user();
        $discount = Discount::find($discountId);

        if($discount && $discount->user_id != $user->id) {
            $request->session()->flash('error', 'You are not allowed to do this action');
            return redirect()->route('discounts');
        }

        $discount_items = [];
        $discount_categories = [];
        if($discount) {
            $discount_items = $discount->menu_items->pluck('id')->toArray();
            $discount_categories = $discount->menu_categories->pluck('id')->toArray();
        }

        $menu_items = $user->restaurant->menu_items;
        $menu_categories = $user->restaurant->menu_categories;

        return view('discounts.edit', [
            'discount' => $discount,
            'discount_items' => $discount_items,
            'discount_categories' => $discount_categories,
            'menu_items' => $menu_items,
            'menu_categories' => $menu_categories
        ]);
    }

    public function save(DiscountRequest $request, $discountId) {
        $user = auth()->user();

        $input = $request->only([
            'discount_id',
            'name',
            'amount_percent',
            'active',
            'menu_items',
            'menu_categories',
            'start_timestamp',
            'end_timestamp'
        ]);

        $discount = Discount::find($discountId);
        if($discount && $discount->user_id != $user->id) {
            $request->session()->flash('error', 'you are not allowed to do this action');
            return redirect()->route('menu');
        }

        if(!$discount) {
            $discount = new Discount();
        }

        $discount->user_id = $user->id;
        $discount->restaurant_id = $user->restaurant->id;
        $discount->name = $input['name'];
        $discount->amount_percent = $input['amount_percent'] ?? 0;
        $discount->active = $input['active'];
        $discount->start_timestamp = $input['start_timestamp'];
        $discount->end_timestamp = $input['end_timestamp'];
        $discount->save();

        $menu_items = $input['menu_items'] ?? [];
        $discount->menu_items()->sync($menu_items);

        $menu_categories = $input['menu_categories'] ?? [];
        $discount->menu_categories()->sync($menu_categories);

        $request->session()->flash('success', 'Save successful');
        return redirect()->route('discounts');
    }

    public function delete(Request $request, $discountId) {
        $user = auth()->user();

        $discount = Discount::find($discountId);
        if(!$discount) {
            $request->session()->flash('error', 'No such discount');
            return redirect()->route('discounts');
        }

        if($discount && $discount->user_id != $user->id) {
            $request->session()->flash('error', 'You are not allowed to do this action');
            return redirect()->route('discounts');
        }

        $discount->delete();
        $request->session()->flash('success', 'Delete successful');
        return redirect()->route('discounts');
    }
}