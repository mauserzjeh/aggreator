<!-- Navbar - side  -->
<nav class="sidenav navbar navbar-vertical  fixed-left  navbar-expand-xs navbar-light bg-white" id="sidenav-main">
    <div class="scroll-wrapper scrollbar-inner" style="position: relative;">
        <div class="scrollbar-inner scroll-content" style="height: 1291px; margin-bottom: 0px; margin-right: 0px; max-height: none;">
            <!-- Brand -->
            <div class="sidenav-header  align-items-center">
                <a class="navbar-brand" href="javascript:void(0)">
                    <img src="/assets/img/brand/aggreator_primary-01.png" class="navbar-brand-img" alt="aggreator_logo">
                </a>
            </div>
            <div class="navbar-inner">
                <!-- Collapse -->
                <hr class="my-0">
                <div class="collapse navbar-collapse" id="sidenav-collapse-main">
                    <!-- Nav items -->
                    <ul class="navbar-nav">
                        @if(isset($menu_items))
                            @forelse($menu_items as $menu_item)
                                <li class="nav-item">
                                    <a class="nav-link @if(isset($active_page) && $menu_item['active_page'] == $active_page) active @endif" href="{{ route($menu_item['route']) }}">
                                        <i class="{{ $menu_item['icon'] }} text-primary"></i>
                                        <span class="nav-link-text">{{ $menu_item['text'] }}</span>
                                    </a>
                                </li>
                            @empty
                            @endforelse
                        @endif
                    </ul>
                </div>
            </div>
        </div>
        <div class="scroll-element scroll-x">
            <div class="scroll-element_outer">
                <div class="scroll-element_size"></div>
                <div class="scroll-element_track"></div>
                <div class="scroll-bar" style="width: 0px;"></div>
            </div>
        </div>
        <div class="scroll-element scroll-y">
            <div class="scroll-element_outer">
                <div class="scroll-element_size"></div>
                <div class="scroll-element_track"></div>
                <div class="scroll-bar" style="height: 0px;"></div>
            </div>
        </div>
    </div>
</nav>