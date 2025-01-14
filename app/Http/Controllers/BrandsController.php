<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BrandsController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index () {
        $data['title'] = __('lang.brands');
        $data['brands'] = Brand::all();
        $categories = Category::with(['sub_categories' => function ($q) {
                return $q->with('sub_categories');
            }])
            ->where('level', 1)->get();

        $data['categories'] = $categories;

        return view('pages.brands.index')->with($data);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request) {
        $inputs = $request->all();
        $inputs['slug'] = Str::slug($inputs['title']);
        $inputs['is_active'] = 1;
        if ($request->hasFile('image')) {
            $file_image = 'brand_logo_' . time();
            $logo_path = 'site/images/brands';
            $file_image = uploadSingleImage($request->file('image'), $file_image, $logo_path);
            $inputs['image'] = $file_image;
        }

        Brand::create($inputs);

        return back()->with('message', 'success=' . __('lang.saved_success', ['field' => __('lang.brand')]));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request) {
        $inputs = $request->except('_token');
        $brand = Brand::findOrFail($inputs['id']);
        if ($request->hasFile('image')) {
            unlink(public_path($brand->image));
            $file_image = 'brand_logo_' . time();
            $logo_path = 'site/images/brands';
            $file_image = uploadSingleImage($request->file('image'), $file_image, $logo_path);
            $inputs['image'] = $file_image;
        }

        $brand->update($inputs);
        return back()->with('message', 'success=' . __('lang.saved_success', ['field' => __('lang.brand')]));
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete ($id) {
        $brand = Brand::findOrFail($id);
        unlink(public_path($brand->image));
        $brand->delete();

        return back()->with('message', 'success=' . __('lang.delete_success', ['field' => __('lang.brand')]));
    }
}
