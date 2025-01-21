<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\Category;
use App\Models\City;
use App\Models\Feedback;
use App\Models\Product;
use App\Models\Setting;
use Illuminate\Http\Request;
use Response;

class SiteController extends Controller
{
    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function homeFeeds () {
        try {
//            $categories = Category::with(['sub_categories' => function ($q) {
//                    return $q->with('sub_categories');
//                }])
//                ->where(['parent_id' => null, 'is_active' => 1])->get();
            $banners = Banner::where(['home_page_banner' => 1, 'show_on_home' => 1, 'slider_banner' => 1])->get();
            $homeDeals = Banner::where(['home_page_banner' => 1])->limit(3)->get();
            $categories = Category::where(['is_active' => 1, 'level' => 1])->whereNotNull('image')->latest()->limit(12)->get();
            $discounted_products = Product::select('product_title', 'price', 'slug', 'id', 'discount_type', 'discount_value', 'unit_id', 'unit_value', 'default_image', 'apply_discount')
                ->with(['unit' => function ($q) {
                    return $q->select('unit', 'prefix', 'id', 'id');
                }])
                ->with('images')
                ->where(['is_active' => 1, 'apply_discount' => 1, 'is_archive' => 0])
                ->latest()
                ->limit(6)
                ->get();
            $fruits_vegetables_products = Category::where('slug', 'fruits-and-vegetables')->with(['products' => function ($q) {
                $q->select('product_title', 'price', 'slug', 'discount_type', 'discount_value', 'unit_id', 'id', 'unit_value', 'default_image', 'allow_add_to_cart_when_out_of_stock', 'category_id', 'apply_discount');
                $q->with(['unit' => function ($q) {
                    return $q->select('unit', 'prefix', 'id');
                }]);
                $q->with('images');
                return $q->latest()->limit(12);
            }])->first();
            $everyday_products = Product::select('product_title', 'price', 'slug', 'discount_type', 'id', 'discount_value', 'unit_id', 'unit_value', 'default_image', 'allow_add_to_cart_when_out_of_stock', 'apply_discount')
                ->with(['unit' => function ($q) {
                    return $q->select('unit', 'prefix', 'id');
                }])
                ->where(['is_everyday_essential' => 1, 'is_active' => 1, 'is_archive' => 0])
                ->with('images')
                ->latest()
                ->limit(8)
                ->get();

            $feedbacks = Feedback::with('user')->where('published', 1)->latest()->get();

            $data['categories'] = $categories;
            $data['discounted_products'] = $discounted_products;
            $data['fruits_vegetables_products'] = $fruits_vegetables_products;
            $data['everyday_products'] = $everyday_products;
            $data['feedbacks'] = $feedbacks;
            $data['banners'] = $banners;
            $data['homeDeals'] = $homeDeals;

            return Response::json([
                'success' => true,
                'data' => $data,
                'status_code' => 200,
                'message' => 'Data fetched'
            ]);
        } catch (\Exception $exception) {
            return Response::json([
                'success' => true,
                null,
                'status_code' => 500,
                'message' => $exception->getMessage()
            ]);
        }
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function siteSetting () {
        try {
            $setting = Setting::with(['banners' => function ($q) {
                    $q->where(['show_on_home' => 1, 'home_page_banner' => 0]);
                }])
                ->first();
            $navigation_menus = Category::select('category', 'slug')->where(['parent_id' => null, 'is_active' => 1, 'is_nav' => 1])->latest()->limit(5)->get();
            $categories = Category::with(['sub_categories' => function ($q) {
                return $q->with('sub_categories');
            }])
                ->where(['parent_id' => null, 'is_active' => 1])->get();

            $data['site_data'] = $setting;
            $data['navigation_menus'] = $navigation_menus;
            $data['categories'] = $categories;

            return Response::json([
                'success' => true,
                'data' => $data,
                'status_code' => 200,
                'message' => 'Data fetched'
            ]);
        } catch (\Exception $exception) {
            return Response::json([
                'success' => true,
                null,
                'status_code' => 500,
                'message' => $exception->getMessage()
            ]);
        }
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function getCities () {
        try {
            $cities = City::where(['is_active' => 1])->get();
            $option_array = [];
            foreach ($cities as $key => $city) {
                $option_array[$key] = [];
                $option_array[$key]['value'] = $city->id;
                $option_array[$key]['label'] = $city->city;
            }

            $data['cities'] = $option_array;

            return Response::json([
                'success' => true,
                'data' => $data,
                'status_code' => 200,
                'message' => 'Data fetched'
            ]);

        }  catch (\Exception $exception) {
            return Response::json([
                'success' => true,
                null,
                'status_code' => 500,
                'message' => $exception->getMessage()
            ]);
        }
    }

    public function generateHMAC (Request $request) {
        $input = $request->all();
        $input = json_encode($input['payload']);

        return hash_hmac('sha256', $input, env('HMAC_SECERET_KEY'));
    }
}
