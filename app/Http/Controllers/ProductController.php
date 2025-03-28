<?php

namespace App\Http\Controllers;

use App\Models\Attribute;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductUnit;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use SebastianBergmann\CodeCoverage\Report\Xml\Unit;

class ProductController extends Controller
{
    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            // Server-side processing for DataTables
            $query = Product::where('is_archive', 0)
                ->with(['category', 'brand', 'unit']);

            // Search functionality
            if ($request->has('search') && !empty($request->input('search.value'))) {
                $search = $request->input('search.value');
                $query->where(function($q) use ($search) {
                    $q->where('product_title', 'LIKE', "%{$search}%")
                        ->orWhere('sku_code', 'LIKE', "%{$search}%")
                        ->orWhereHas('category', function($cat) use ($search) {
                            $cat->where('category', 'LIKE', "%{$search}%");
                        });
                });
            }

            // Pagination and ordering
            $totalRecords = $query->count();
            $products = $query->skip($request->start)
                ->take($request->length)
                ->get()
                ->map(function ($product) {
                    $discount = 0;
                    $formattedDiscount = '--';
                    $discountedPrice = '--';

                    if ($product->apply_discount) {
                        if ($product->discount_type === 'value') {
                            $discount = $product->discount_value;
                            $formattedDiscount = 'RS. ' . $product->discount_value;
                        } else {
                            $discount = ($product->price * $product->discount_value) / 100;
                            $formattedDiscount = $product->discount_value . '%';
                        }
                        $discountedPrice = 'RS. ' . ($product->price - $discount);
                    }

                    return [
                        'id' => $product->id,
                        'slug' => $product->slug,
                        'default_image' => $product->default_image,
                        'product_title' => $product->product_title,
                        'category' => $product->category ? $product->category->category : 'Others',
                        'sku_code' => $product->sku_code,
                        'price' => 'RS. ' . $product->price,
                        'quantity' => $product->quantity,
                        'unit_value' => $product->unit ? $product->unit_value . $product->unit->prefix : 'Others',
                        'formatted_discount' => $formattedDiscount,
                        'discounted_price' => $discountedPrice,
                    ];
                });

            return response()->json([
                'draw' => intval($request->input('draw')),
                'recordsTotal' => $totalRecords,
                'recordsFiltered' => $totalRecords,
                'data' => $products,
            ]);
        }

        $data['title'] = __('lang.products');
        $data['categories'] = Category::where('is_active', 1)->latest()->get();
        $data['max_price'] = Product::max('price');

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
        $data['suppliers'] = Supplier::all();
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
                'sku_code' => 'unique:products,sku_code,NULL,id,is_archive,0',
            ]);

            if ($validator->fails()) {
                return back()->withInput()->withErrors($validator);
            }
            $inputs = $request->except('_token');
            $slug = Str::slug($inputs['product_title']);
            $exist_product = Product::where('slug', $slug)->first();
            if ($exist_product) {
                if ($exist_product->is_archive == 0) {
                    $exist_product->slug = null;
                    $exist_product->save();
                } else {
                    return back()->withInput()->with('message', 'error=' . __('lang.product_already_exists_with_name'));
                }
            }
            $inputs['slug'] = $slug;
            $inputs['product_type'] = 'simple';
            $inputs['is_active'] = 1;
            $images = $inputs['images'];
            unset($inputs['images']);
            $result = Product::create($inputs);
            if ($result) {
                $file_image = '';
                foreach ($images as $key => $image) {
                    $file_image = $slug . ('_' . ($key + 1)) . '_' . time();
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
        $data['suppliers'] = Supplier::all();
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
                $file_image = $slug . ('_' . ($key + 1)) . '_' . time();
                $logo_path = 'site/images/products/' . $slug;
                $file_image = uploadSingleImage($image, $file_image, $logo_path);
                ProductImage::create(['images' => $file_image, 'product_id' => $product->id]);
                if ($key === 0) {
                    $inputs['default_image'] = $file_image;
                }
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

            $product->update($inputs);

            return back()->with('message', 'success=' . __('lang.saved_success', ['field' => __('lang.product')]));
        } catch (\Exception $e) {
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
        $image = ProductImage::where('id', $id)->first();
        unlink(public_path($image->images));
        $image->delete();

        return back()->with('message', 'success=' . __('lang.delete_success', ['field' => __('lang.image')]));
    }
}
