<?php

namespace App\Providers;

use App\Http\View\Composers\SidebarComposer;
use Illuminate\Support\Facades\View;

class ViewServiceProvider extends AppServiceProvider {

    public function boot() {
        View::composer('components.navbar-side', SidebarComposer::class);
    }
}