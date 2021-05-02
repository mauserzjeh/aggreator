<?php

namespace App\Http\View\Composers;

use App\Models\UserType;
use Illuminate\View\View;

class SidebarComposer {

    /**
     * Menu items constant
     * 
     * @var array
     */
    const MENU_ITEMS = [
        UserType::TYPE_COURIER => [
            [
                'route' => 'availability',
                'icon' => 'far fa-clock',
                'text' => 'Availability',
                'active_page' => 'availability'
            ],
            [
                'route' => 'courier.orders',
                'icon' => 'fas fa-shipping-fast',
                'text' => 'Deliveries',
                'active_page' => 'courier.orders'
            ],
        ],
        UserType::TYPE_CUSTOMER => [
            [
                'route' => 'deliveryinfo',
                'icon' => 'fas fa-info',
                'text' => 'Delivery information',
                'active_page' => 'deliveryinfo'
            ],
            [
                'route' => 'restaurants',
                'icon' => 'fas fa-store-alt',
                'text' => 'Restaurants',
                'active_page' => 'restaurants'
            ],
        ],
        UserType::TYPE_MANAGER => [
            [
                'route' => 'restaurant.details',
                'icon' => 'fas fa-store-alt',
                'text' => 'Restaurant details',
                'active_page' => 'restaurant.details',
            ],
            [
                'route' => 'menu',
                'icon' => 'fas fa-pizza-slice ',
                'text' => 'Menu',
                'active_page' => 'menu'
            ],
            [
                'route' => 'menu.categories',
                'icon' => 'fas fa-utensils',
                'text' => 'Menu categories',
                'active_page' => 'menu.categories'
            ],
            [
                'route' => 'restaurant.orders',
                'icon' => 'fas fa-shipping-fast',
                'text' => 'Orders',
                'active_page' => 'restaurant.orders'
            ],
        ]
    ];

    /**
     * Bind data to the view.
     *
     * @param  \Illuminate\Viw\View  $view
     * @return void
     */
    public function compose(View $view) {
        $menu_items = [];
        $user_type_id = auth()->user()->user_type_id ?? null;
        if($user_type_id && array_key_exists($user_type_id, self::MENU_ITEMS)) {
            $menu_items = self::MENU_ITEMS[$user_type_id];
        }
        $view->with('menu_items', $menu_items);
    }
}