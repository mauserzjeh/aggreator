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
            // TODO 
        ],
        UserType::TYPE_CUSTOMER => [
            [
                'route' => 'restaurants',
                'icon' => 'fas fa-store-alt',
                'text' => 'Restaurants',
                'active_page' => 'restaurants'
            ]
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
                'route' => 'orders',
                'icon' => 'fas fa-shipping-fast',
                'text' => 'Orders',
                'active_page' => 'orders'
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