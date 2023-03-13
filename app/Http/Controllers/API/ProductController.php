<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Response;

class ProductController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getProducts(Request $request) {
        try {
            $category = null;
            $input = $request->except(['token', 'secure_pass']);
            if ($request->has('category')) {
                $category = Category::where('slug', $request->get('category'))->first();
            }

            $query = '';
            if ($request->has('q')) {
                $query = $request->get('q');
            }

            $limit = 12;
            $page = $request->get('page_number');
            $offset = ($page - 1) * $limit;
            $products = Product::select('product_title', 'price', 'slug', 'discount_type', 'discount_value', 'unit_id', 'unit_value', 'id', 'default_image', 'allow_add_to_cart_when_out_of_stock', 'apply_discount', 'category_id', 'brand_id')
                ->with(['unit' => function ($q) {
                    return $q->select('unit', 'prefix', 'id');
                }])
                ->when($category, function ($q) use ($category) {
                    return $q->where('category_id', $category->id);
                })
                ->when($query, function ($q) use ($query) {
                    return $q->where('product_title', 'LIKE', '%' . $query . '%');
                })
                ->when(!empty($input['brand']), function ($q) use ($input) {
                    return $q->where('brand_id', $input['brand']);
                })
                ->when(!empty($input['order']), function ($q) use ($input) {
                    return $q->orderBy('price', $input['order']);
                })
                ->when(!empty($input['min_price']) && !empty($input['max_price']), function ($q) use ($input) {
                    return $q->whereBetween('price', [$input['min_price'], $input['max_price']]);
                })
                ->where(['is_active' => 1, 'is_archive' => 0])
                ->skip($offset)
                ->limit($limit)
                ->get();

            $categories = Category::with('products')
                ->with(['sub_categories' => function ($q) {
                    return $q->with('sub_categories');
                }])
                ->where('is_active', 1)
                ->where('level', 1)
                ->get();

            $brands = Brand::with('products')->where(['is_active' => 1])->get();

            $min_price = $max_price = 0;
            if ($products->count()) {
                $prices = $products->pluck('price')->toArray();
                $min_price = min($prices);
                $max_price = max($prices);
                if ($min_price === $max_price) {
                    $min_price = 0;
                }
            }

            $data['products'] = $products;
            $data['categories'] = $categories;
            $data['brands'] = $brands;
            $data['minPrice'] = $min_price;
            $data['maxPrice'] = $max_price;
            $data['total_products'] = Product::where(['is_active' => 1, 'is_archive' => 0])
                ->when($category, function ($q) use ($category) {
                    return $q->where('category_id', $category->id);
                })
                ->when($query, function ($q) use ($query) {
                    return $q->where('product_title', 'LIKE', '%' . $query . '%');
                })
                ->when(!empty($input['brand']), function ($q) use ($input) {
                    return $q->where('brand_id', $input['brand']);
                })
                ->when(!empty($input['min_price']) && !empty($input['max_price']), function ($q) use ($input) {
                    return $q->whereBetween('price', [$input['min_price'], $input['max_price']]);
                })
                ->count();

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
     * @param $slug
     * @return \Illuminate\Http\JsonResponse
     */
    public function getProduct($slug) {
        try {
            $product = Product::where(['slug' => $slug, 'is_active' => 1])->with(['category', 'unit'])->first();
            $similar_products = Product::where('category_id', $product->category_id)
                ->with(['unit' => function ($q) {
                    return $q->select('unit', 'prefix', 'id');
                }])
                ->where('id', '!=', $product->id)->get();

            if ($product) {
                $data['product'] = $product;
                $data['similar_products'] = $similar_products;

                return Response::json([
                    'success' => true,
                    'data' => $data,
                    'status_code' => 200,
                    'message' => 'Data fetched'
                ]);
            } else {
                return Response::json([
                    'success' => false,
                    null,
                    'status_code' => 400,
                    'message' => 'Product not found'
                ]);
            }
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
     * @param Request $request
     * @return mixed
     */
    public function getCategoryProducts(Request $request) {
        try {
            $input = $request->except(['token', 'secure_pass']);
            $category = Category::where('slug', $input['category'])
                ->with(['parent_category' => function ($q) {
                    return $q->with('parent_category');
                }])
                ->with('products')
                ->first();
            $limit = 12;
            $page = $request->get('page_number');
            $offset = ($page - 1) * $limit;
            $products = Product::select('product_title', 'price', 'slug', 'discount_type', 'discount_value', 'unit_id', 'unit_value', 'id', 'default_image', 'allow_add_to_cart_when_out_of_stock', 'apply_discount', 'category_id', 'brand_id')
                ->with(['unit' => function ($q) {
                    return $q->select('unit', 'prefix', 'id');
                }])
                ->when(!empty($input['brand']), function ($q) use ($input) {
                    return $q->where('brand_id', $input['brand']);
                })
                ->when(!empty($input['min_price']) && !empty($input['max_price']), function ($q) use ($input) {
                    return $q->whereBetween('price', [$input['min_price'], $input['max_price']]);
                })
                ->where(['is_active' => 1, 'is_archive' => 0, 'category_id' => $category->id])
                ->skip($offset)
                ->limit($limit)
                ->get();

            $min_price = $max_price = 0;
            if ($products->count()) {
                $prices = $products->pluck('price')->toArray();
                $min_price = min($prices);
                $max_price = max($prices);
                if ($min_price === $max_price) {
                    $min_price = 0;
                }
            }

            $brands = Brand::with('products')
                ->with('products')
                ->where(['is_active' => 1, 'category_id' => $category->id])->get();

            $data['products'] = $products;
            $data['category'] = $category;
            $data['brands'] = $brands;
            $data['minPrice'] = $min_price;
            $data['maxPrice'] = $max_price;
            $data['total_products'] = Product::where(['is_active' => 1, 'is_archive' => 0, 'category_id' => $category->id])
                ->when(!empty($input['brand']), function ($q) use ($input) {
                    return $q->where('brand_id', $input['brand']);
                })
                ->when(!empty($input['min_price']) && !empty($input['max_price']), function ($q) use ($input) {
                    return $q->whereBetween('price', [$input['min_price'], $input['max_price']]);
                })
                ->count();

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
     * @param Request $request
     * @return mixed
     */
    public function getRecentProducts (Request $request) {
        try {
            $input = $request->all();
            $products = Product::whereIn('id', $input)->get();
            $data['products'] = $products;

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
}
