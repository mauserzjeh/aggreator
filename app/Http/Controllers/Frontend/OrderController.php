<?php

namespace App\Http\Controllers\Frontend;

use App\Helpers\PaginatorHelper;
use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use App\Models\Availability;
use App\Models\Restaurant;

class OrderController extends Controller {

    public function orders_index(Request $request) {
        $filter = $request->only([
            'filter-status',
            'filter-city',
            'filter-zip',
            'filter-created_at',
            'filter-relation-created_at'
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
        if(array_key_exists('filter-created_at', $filter) && $filter['filter-created_at']) {
            $data->where('created_at', $filter['filter-relation-created_at'], $filter['filter-created_at']);
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

    public function customer_orders(Request $request) {
        $filter = $request->only([
            'filter-id',
            'filter-restaurant',
            'filter-status',
            'filter-created_at',
            'filter-relation-created_at'
        ]);

        $user = auth()->user();

        $data = Order::where('customer_id', $user->id);
        if(array_key_exists('filter-id', $filter) && $filter['filter-id']) {
            $data->where('id', $filter['filter-id']);
        }
        if(array_key_exists('filter-restaurant', $filter) && $filter['filter-restaurant']) {
            $data->where('restaurant_id', $filter['filter-restaurant']);
        }
        if(array_key_exists('filter-status', $filter) && $filter['filter-status']) {
            $data->where('status', $filter['filter-status']);
        }
        if(array_key_exists('filter-created_at', $filter) && $filter['filter-created_at']) {
            $data->where('created_at', $filter['filter-relation-created_at'], $filter['filter-created_at']);
        }

        $current_page = $request->input('page') ?? 1;
        $offset = PaginatorHelper::offset($current_page);

        $data->offset($offset)
            ->limit(PaginatorHelper::ITEMS_PER_PAGE);
        
        $data_count_all = Order::where('customer_id', $user->id)->count();
        $orders = PaginatorHelper::paginate($data->get(), $data_count_all, $current_page, $request);

        foreach($orders as $order) {
            if(array_key_exists($order->status, Order::STATUSES)) {
                $order->status = Order::STATUSES[$order->status];
            }

            $order->restaurant_name = $order->restaurant->name;
            $order->total = $order->total_price() . ' €';
        }

        $restaurants = Restaurant::all()->pluck('name', 'id');
        return view('customer.orders', [
            'orders' => $orders,
            'statuses' => Order::STATUSES,
            'restaurants' => $restaurants
        ]);
    }

    public function customer_order_info(Request $request, $orderId) {
        $user = auth()->user();

        $order = Order::find($orderId);
        if(!$order) {
            $request->session()->flash('error', 'No such order');
            return redirect()->route('customer.orders');
        }

        if($order->customer_id != $user->id) {
            $request->session()->flash('error', 'This order does not belong to you');
            return redirect()->route('customer.orders');
        }

        return view('customer.order-info', [
            'order' => $order
        ]);
    }

    public function courier_orders(Request $request) {
        $filter = $request->only([
            'filter-id',
            'filter-restaurant',
            'filter-status',
            'filter-created_at',
            'filter-relation-created_at',
            'filter-priority'
        ]);

        $user = auth()->user();
        $data = Order::where('courier_id', $user->id)
                        ->whereIn('status', [Order::STATUS_DELIVERED, Order::STATUS_TO_BE_DELIVERED])
                        ->where('delivery_type', Order::TYPE_DELIVERY);
        if(array_key_exists('filter-id', $filter) && $filter['filter-id']) {
            $data->where('id', $filter['filter-id']);
        }
        if(array_key_exists('filter-restaurant', $filter) && $filter['filter-restaurant']) {
            $data->where('restaurant_id', $filter['filter-restaurant']);
        }
        if(array_key_exists('filter-status', $filter) && $filter['filter-status']) {
            $data->where('status', $filter['filter-status']);
        }
        if(array_key_exists('filter-created_at', $filter) && $filter['filter-created_at']) {
            $data->where('created_at', $filter['filter-relation-created_at'], $filter['filter-created_at']);
        }
        if(array_key_exists('filter-priority', $filter) && $filter['filter-priority']) {
            $data->where('priority', $filter['filter-priority']);
        }
        

        $current_page = $request->input('page') ?? 1;
        $offset = PaginatorHelper::offset($current_page);

        $data->orderBy('priority', 'DESC')
            ->orderBy('id', 'ASC')
            ->offset($offset)
            ->limit(PaginatorHelper::ITEMS_PER_PAGE);
        
        $data_count_all = Order::where('courier_id', $user->id)->count();
        $orders = PaginatorHelper::paginate($data->get(), $data_count_all, $current_page, $request);

        foreach($orders as $order) {
            if(array_key_exists($order->status, Order::STATUSES)) {
                $order->status = Order::STATUSES[$order->status];
            }
            if(array_key_exists($order->priority, Order::PRIORITIES)) {
                $p = Order::PRIORITIES[$order->priority];
                $order->priority = '<b class="priority-' . strtolower($p) . '">' . $p . "</b>";
            }

            $order->full_address = $order->city . ' (' . $order->zip_code . ') ' . $order->address;
            $order->restaurant_name = $order->restaurant->name;
            $order->total = $order->total_price() . ' €';
        }

        $restaurants = Restaurant::all()->pluck('name', 'id');
        return view('courier.orders', [
            'orders' => $orders,
            'statuses' => [
                Order::STATUSES[Order::STATUS_DELIVERED],
                Order::STATUSES[Order::STATUS_TO_BE_DELIVERED],
            ],
            'restaurants' => $restaurants
        ]);
    }

    public function courier_order_delivered(Request $request, $orderId) {
        $user = auth()->user();

        $order = Order::find($orderId);
        if(!$order) {
            $request->session()->flash('error', 'No such order');
            return redirect()->route('courier.orders');
        }

        if($order->courier_id != $user->id) {
            $request->session()->flash('error', 'This order does not belong to you');
            return redirect()->route('courier.orders');
        }

        $order->status = Order::STATUS_DELIVERED;
        $order->save();

        $request->session()->flash('success', 'Status successfully updated to delivered');
        return redirect()->route('courier.orders');
    }

    public function courier_order_reject(Request $request, $orderId) {
        $user = auth()->user();

        $order = Order::find($orderId);
        if(!$order) {
            $request->session()->flash('error', 'No such order');
            return redirect()->route('courier.orders');
        }

        if($order->courier_id != $user->id) {
            $request->session()->flash('error', 'This order does not belong to you');
            return redirect()->route('courier.orders');
        }

        if($order->status == Order::STATUS_DELIVERED) {
            $request->session()->flash('error', 'Delivered orders cannot be rejected');
            return redirect()->route('courier.orders');
        }

        $order->courier_id = null;
        $order->save();

        $request->session()->flash('success', 'Delivery successfully rejected');
        return redirect()->route('courier.orders');
    }

    public function courier_order_priority(Request $request, $orderId, $priority) {

        $user = auth()->user();

        $order = Order::find($orderId);
        if(!$order) {
            $request->session()->flash('error', 'No such order');
            return redirect()->route('courier.orders');
        }

        if($order->courier_id != $user->id) {
            $request->session()->flash('error', 'This order does not belong to you');
            return redirect()->route('courier.orders');
        }

        if($priority != Order::PRIORITY_HIGHER && $priority != Order::PRIORITY_LOWER) {
            $request->session()->flash('error', 'Parameter error');
            return redirect()->route('courier.orders');
        }

        if($priority == Order::PRIORITY_HIGHER) {
            if($order->priority < 3) {
                $order->priority++;
            }
        }

        if($priority == Order::PRIORITY_LOWER) {
            if($order->priority > 1) {
                $order->priority--;
            }
        }

        $order->save();
        $request->session()->flash('success', 'Priority successfully updated');
        return redirect()->route('courier.orders');
    }
}