<?php

namespace App\Http\Controllers\Frontend;

use App\Helpers\PaginatorHelper;
use App\Http\Controllers\Controller;
use App\Models\MenuCategory;
use Illuminate\Http\Request;
use App\Http\Requests\MenuCategoryRequest;
use Illuminate\Support\Str;

class MenuController extends Controller {



    public function index() {
        echo "menu index";
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

        $request->session()->flash('success', 'Successful save');
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
        $request->session()->flash('success', 'Successful delete');
        return redirect()->route('menu.categories');
    }
}