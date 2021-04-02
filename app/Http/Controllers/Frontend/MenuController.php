<?php

namespace App\Http\Controllers\Frontend;

use App\Helpers\PaginatorHelper;
use App\Http\Controllers\Controller;
use App\Models\MenuCategory;
use Illuminate\Http\Request;
use App\Http\Requests\MenuCategoryRequest;
use App\Models\Allergene;
use App\Models\MenuItem;
use Illuminate\Support\Str;
use App\Http\Requests\MenuRequest;

class MenuController extends Controller {



    public function index(Request $request) {
        $filter = $request->only([
            'filter-id',
            'filter-name',
            'filter-category',
            'filter-description',
        ]);

        $menu_items = [];
        $categories = [];

        $user = auth()->user();
        if($user) {
            $data = MenuItem::where('user_id', $user->id);
            if(array_key_exists('filter-id', $filter) && $filter['filter-id']) {
                $data->where('id', $filter['filter-id']);
            }
            if(array_key_exists('filter-name', $filter) && $filter['filter-name']) {
                $data->where('name', 'LIKE', '%' . $filter['filter-name'] . '%');
            }
            if(array_key_exists('filter-category', $filter) && $filter['filter-category']) {
                $data->where('menu_category_id', $filter['filter-category']);
            }
            if(array_key_exists('filter-description', $filter) && $filter['filter-description']) {
                $data->where('description', 'LIKE', '%' . $filter['filter-description'] . '%');
            }
           
            $current_page = $request->input('page') ?? 1;
            $offset = PaginatorHelper::offset($current_page);

            $data->offset($offset)
                ->limit(PaginatorHelper::ITEMS_PER_PAGE);

            $data_count_all = MenuItem::where('user_id', $user->id)->count();
            $menu_items = PaginatorHelper::paginate($data->get(), $data_count_all, $current_page, $request);
            
            $categories = MenuCategory::where('user_id', $user->id)->pluck('name', 'id');
            foreach($menu_items as $item) {
                $item->category = $categories[$item->menu_category_id] ?? $item->menu_category_id;
            }
        }

        return view('menu.index', [
            'menu_items' => $menu_items,
            'categories' => $categories
        ]);
    }

    public function edit(Request $request, $itemId) {
        $user = auth()->user();
        $item = MenuItem::find($itemId);

        if($item && $item->user_id != $user->id) {
            $request->session()->flash('error', 'You are not allowed to do this action');
            return redirect()->route('menu');
        }

        $item_allergenes = [];
        if($item) {
            $item_allergenes = $item->allergenes->pluck('id')->toArray();
        }

        $allergenes = Allergene::all();
        $categories = MenuCategory::where('user_id', $user->id)->get();
        return view('menu.edit', [
            'item' => $item,
            'item_allergenes' => $item_allergenes,
            'allergenes' => $allergenes,
            'categories' => $categories
        ]);
    }

    public function save(MenuRequest $request, $itemId) {
        $user = auth()->user();

        $input = $request->only([
            'name',
            'price',
            'category',
            'item_allergenes',
            'description'
        ]);

        $item = MenuItem::find($itemId);
        if($item && $item->user_id != $user->id) {
            $request->session()->flash('error', 'You are not allowed to do this action');
            return redirect()->route('menu');
        }

        if(!$item) {
            $item = new MenuItem();
        }

        $item->user_id = $user->id;
        $item->menu_category_id = $input['category'];
        $item->name = $input['name'];
        $item->price = $input['price'];
        $item->description = $input['description'];
        $item->save();

        $item->allergenes()->sync($input['item_allergenes']);

        $request->session()->flash('success', 'Save successful');
        return redirect()->route('menu');
    }

    public function delete(Request $request, $itemId) {
        $user = auth()->user();
        
        $item = MenuItem::find($itemId);
        if(!$item) {
            $request->session()->flash('error', 'No such item');
            return redirect()->route('menu');
        }

        if($item && $item->user_id != $user->id) {
            $request->session()->flash('error', 'You are not allowed to do this action');
            return redirect()->route('menu');
        }

        $item->delete();
        $request->session()->flash('success', 'Delete successful');
        return redirect()->route('menu');
    }

    public function categories(Request $request) {
        $filter = $request->only([
            'filter-id',
            'filter-name',
            'filter-slug'
        ]);
        

        $categories = [];

        $user = auth()->user();
        if($user) {
            $data = MenuCategory::where('user_id', $user->id);
            if(array_key_exists('filter-id', $filter) && $filter['filter-id']) {
                $data->where('id', $filter['filter-id']);
            }
            if(array_key_exists('filter-name', $filter)  && $filter['filter-name']) {
                $data->where('name', 'LIKE', '%' . $filter['filter-name'] . '%');
            }
            if(array_key_exists('filter-slug', $filter)  && $filter['filter-slug']) {
                $data->where('slug', 'LIKE', '%' . $filter['filter-slug'] . '%');
            }

            $current_page = $request->input('page') ?? 1;
            $offset = PaginatorHelper::offset($current_page);

            $data->offset($offset)
                ->limit(PaginatorHelper::ITEMS_PER_PAGE);

            $data_count_all = MenuCategory::where('user_id', $user->id)->count();
            $categories = PaginatorHelper::paginate($data->get(), $data_count_all, $current_page, $request);
        }

        return view('menu.categories', [
            'categories' => $categories
        ]);
    }

    public function edit_category(Request $request, $categoryId) {
        $user = auth()->user();
        $category = MenuCategory::find($categoryId);

        //check if category belongs to user
        if($category && $category->user_id != $user->id) {
            $request->session()->flash('error', 'You are not allowed to do this action');
            return redirect()->route('menu.categories');
        }

        return view('menu.category-edit', [
            'category' => $category
        ]);
    }

    public function save_category(MenuCategoryRequest $request, $categoryId) {
        $user = auth()->user();
        $input = $request->only([
            'name',
            'category_id'
        ]);

        $category = MenuCategory::find($categoryId);
        if($category && $category->user_id != $user->id) {
            $request->session()->flash('error', 'You are not allowed to do this action');
            return redirect()->route('menu.categories');
        }

        if(!$category) {
            $category = new MenuCategory();
        }

        $category->user_id = $user->id;
        $category->name = $input['name'];
        $category->slug = Str::slug($input['name']);
        $category->save();

        $request->session()->flash('success', 'Save successful');
        return redirect()->route('menu.categories');
    }

    public function delete_category(Request $request, $categoryId) {
        $user = auth()->user();

        $category = MenuCategory::find($categoryId);
        if(!$category) {
            $request->session()->flash('error', 'No such category');
            return redirect()->route('menu.categories');
        }

        if($category && $category->user_id != $user->id) {
            $request->session()->flash('error', 'You are not allowed to do this action');
            return redirect()->route('menu.categories');
        }

        $category->delete();
        $request->session()->flash('success', 'Delete successful');
        return redirect()->route('menu.categories');
    }
}