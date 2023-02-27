<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index () {
        $data['title'] = __('lang.categories');
        $data['categories'] = Category::with('parent_category')->get();

        return view('pages.categories.index')->with($data);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function add () {
        $data['title'] = __('lang.add_option', ['field' => __('lang.category')]);
        $data['categories'] = Category::whereNull('parent_id')->get();
        $data['category'] = null;

        return view('pages.categories.add')->with($data);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit ($id) {
        $data['title'] = __('lang.add_option', ['field' => __('lang.category')]);
        $data['categories'] = Category::whereNull('parent_id')->get();
        $data['category'] = Category::findOrFail($id);

        return view('pages.categories.add')->with($data);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request) {
        try {
            $inputs = $request->all();
            $slug = Str::slug($inputs['category']);
            $inputs['slug'] = $slug;
            $inputs['is_active'] = 1;
            if ($request->hasFile('image')) {
                $file_image = $slug;
                $logo_path = 'site/images/categories/logos';
                $file_image = uploadSingleImage($request->file('image'), $file_image, $logo_path);
                $inputs['image'] = $file_image;
            }

            if (!isset($inputs['is_nav'])) {
                $inputs['is_nav'] = 0;
            }

            $result = Category::updateOrCreate(['id' => $inputs['id']], $inputs);
            if ($result) {
                return redirect()->route('categories.index')->with('message', 'success=' . __('lang.saved_success', ['field' => __('lang.category')]));
            }
        } catch (\Exception $e) {
            return back()->with('message', 'error=' . __('lang.illegal_error'));
        }
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete($id) {
        Category::where('id', $id)->delete();
        return back()->with('message', 'success=' . __('lang.delete_success', ['field' => __('lang.category')]));
    }
}
