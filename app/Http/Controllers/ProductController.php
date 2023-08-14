<?php

namespace App\Http\Controllers;

use App\Models\Attribute;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductUnit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use SebastianBergmann\CodeCoverage\Report\Xml\Unit;

class ProductController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $data['title'] = __('lang.products');
        $data['products'] = Product::where('is_archive', 0)->with(['category', 'brand', 'unit'])->get();

        return view('pages.products.index')->with($data);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function add()
    {
        $data['title'] = __('lang.products');
        $data['categories'] = Category::where('is_active', 1)->latest()->get();
        $data['units'] = ProductUnit::all();
        $data['brands'] = Brand::where('is_active', 1)->latest()->get();

        return view('pages.products.create')->with($data);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'sku_code' => 'unique:products'
            ]);

            if ($validator->fails()) {
                return back()->withErrors($validator);
            }
            $inputs = $request->except('_token');
            $slug = Str::slug($inputs['product_title']);
            $inputs['slug'] = $slug;
            $inputs['product_type'] = 'simple';
            $inputs['is_active'] = 1;
            $images = $inputs['images'];
            unset($inputs['images']);
            $result = Product::create($inputs);
            if ($result) {
                $file_image = '';
                foreach ($images as $key => $image) {
                    $file_image = $slug . ('_' . ($key + 1));
                    $logo_path = 'site/images/products/' . $slug;
                    $file_image = uploadSingleImage($image, $file_image, $logo_path);
                    ProductImage::create(['images' => $file_image, 'product_id' => $result->id]);
                }

                $result->default_image = $file_image;
                $result->save();
            }

            return back()->with('message', 'success=' . __('lang.saved_success', ['field' => __('lang.product')]));
        } catch (\Exception $e) {
            return back()->with('message', 'error=' . __('lang.illegal_error'));
        }
    }

    /**
     * @param $slug
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View'
     */
    public function edit($slug)
    {
        $data['title'] = __('lang.products');
        $data['categories'] = Category::where('is_active', 1)->latest()->get();
        $data['units'] = ProductUnit::all();
        $data['brands'] = Brand::where('is_active', 1)->latest()->get();
        $data['product'] = Product::where('slug', $slug)->with('images')->first();

        return view('pages.products.edit')->with($data);
    }

    /**
     * @param Request $request
     * @param $slug
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $slug)
    {
        try {
            $inputs = $request->except('_token');
            $images = !empty($inputs['images']) ? $inputs['images'] : [];
            unset($inputs['images']);
            $product = Product::where('slug', $slug)->first();
            foreach ($images as $key => $image) {
                $file_image = $slug . ('_' . ($key + 1));
                $logo_path = 'site/images/products/' . $slug;
                $file_image = uploadSingleImage($image, $file_image, $logo_path);
                ProductImage::create(['images' => $file_image, 'product_id' => $product->id]);
            }

            if (!isset($inputs['allow_add_to_cart_when_out_of_stock'])) {
                $inputs['allow_add_to_cart_when_out_of_stock'] = 0;
            }

            if (!isset($inputs['is_active'])) {
                $inputs['is_active'] = 0;
            }

            if (!isset($inputs['is_everyday_essential'])) {
                $inputs['is_everyday_essential'] = 0;
            }

            if (!isset($inputs['apply_discount'])) {
                $inputs['apply_discount'] = 0;
                $inputs['discount_value'] = 0;
                $inputs['discount_type'] = null;
            }

            Product::where('slug', $slug)->update($inputs);

            return back()->with('message', 'success=' . __('lang.saved_success', ['field' => __('lang.product')]));
        } catch (\Exception $e) {
            dd($e);
            return back()->with('message', 'error=' . __('lang.illegal_error'));
        }

    }

    /**
     * @param $slug
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete($slug)
    {
        try {
            Product::where('slug', $slug)->update(['is_archive' => 1]);

            return back()->with('message', 'success=' . __('lang.delete_success', ['field' => __('lang.product')]));
        } catch (\Exception $e) {
            return back()->with('message', 'error=' . __('lang.illegal_error'));
        }
    }

    /**
     * @param Request $request
     * @return string
     */
    public function getVariations(Request $request)
    {
        $i = $request->get('i');
        $j = $request->get('j');
        $attributes = Attribute::with('options')->get();
        $html = '';
        $html .= "<h5>Variation $i</h5>";
        $html .= "<div class='d-flex flex-wrap'>";
        foreach ($attributes as $key => $attribute) {
            $html .= "<input type='hidden' name='variants[attributes][$j][$attribute->id]'>";
            $html .= "<div class='mx-2'>";
            $html .= "<label for=''>$attribute->attribute</label>";
            $html .= "<select name='variants[attributes][$j][options][]' id='' class='form-control'>";
            $html .= " <option value=''>" . __('lang.select_option') . "</option>";
            foreach ($attribute->options as $key1 => $option) {
                $html .= " <option value='$option->id'>$option->option</option>";
            }
            $html .= "</select>";
            $html .= "</div>";
        }
        $html .= "<div class='mx-2'>";
        $html .= "<label for=''>Price</label>";
        $html .= "<input type='text' name='variants[attributes][$j][price]' class='form-control' />";
        $html .= "</div>";
        $html .= "</div><hr>";

        return $html;
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function deleteImage($id)
    {
        ProductImage::where('id', $id)->delete();

        return back()->with('message', 'success=' . __('lang.delete_success', ['field' => __('lang.image')]));
    }
}
