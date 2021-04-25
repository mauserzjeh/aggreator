<?php

namespace App\Http\Controllers\Frontend;

use App\Helpers\PaginatorHelper;
use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use App\Models\Availability;

class OrderController extends Controller {

    public function orders_index(Request $request) {
        $filter = $request->only([
            'filter-status',
            'filter-city',
            'filter-zip'
        ]);

        $user = auth()->user();

        $data = Order::where('restaurant_id', $user->restaurant->id);
        if(array_key_exists('filter-status', $filter) && $filter['filter-status']) {
            $data->where('status', $filter['filter-status']);
        }
        if(array_key_exists('filter-city', $filter) && $filter['filter-city']) {
            $data->where('city', 'LIKE', '%' . $filter['filter-city'] . '%');
        }
        if(array_key_exists('filter-zip', $filter) && $filter['filter-zip']) {
            $data->where('zip_code', $filter['filter-zip']);
        }

        $current_page = $request->input('page') ?? 1;
        $offset = PaginatorHelper::offset($current_page);

        $data->offset($offset)
            ->limit(PaginatorHelper::ITEMS_PER_PAGE);

        $data_count_all = Order::where('restaurant_id', $user->restaurant->id)->count();
        $orders = PaginatorHelper::paginate($data->get(), $data_count_all, $current_page, $request);
        
        foreach($orders as $order) {
            if(array_key_exists($order->status, Order::STATUSES)) {
                $order->status = Order::STATUSES[$order->status];
            }

            $order->total = $order->total_price() . ' €';
        }

        return view('restaurant.orders', [
            'orders' => $orders,
            'statuses' => Order::STATUSES
        ]);
    }

    public function order_info(Request $request, $orderId) {
        $user = auth()->user();

        $order = Order::find($orderId);
        if(!$order) {
            $request->session()->flash('error', 'No such order');
            return redirect()->route('restaurant.orders');
        }

        if($order->restaurant_id != $user->restaurant->id) {
            $request->session()->flash('error', 'This order does not belong to your restaurant');
            return redirect()->route('restaurant.orders');
        }

        $in = false;
        $couriers = Availability::get_available_couriers();
        foreach($couriers as $c) {
            if($order->courier && $c->id == $order->courier->id) {
                $in = true;
                break;
            }
        }

        if(!$in && $order->courier) {
            $couriers[] = $order->courier;
        }

        return view('restaurant.order-info', [
            'order' => $order,
            'statuses' => Order::STATUSES,
            'couriers' => Availability::get_available_couriers()
        ]);
    }

    public function order_update(Request $request, $orderId) {
        $user = auth()->user();

        $order = Order::find($orderId);
        if(!$order) {
            $request->session()->flash('error', 'No such order');
            return redirect()->route('restaurant.orders');
        }

        if($order->restaurant_id != $user->restaurant->id) {
            $request->session()->flash('error', 'This order does not belong to your restaurant');
            return redirect()->route('restaurant.orders');
        }

        $input = $request->only([
            'courier',
            'status',
            'expected_delivery_time'
        ]);

        $order->courier_id = $input['courier'];
        $order->status = $input['status'];
        $order->expected_delivery_time = $input['expected_delivery_time'];
        $order->save();

        $request->session()->flash('success', 'Order successfully updated');
        return redirect()->route('restaurant.orders');

    }
}