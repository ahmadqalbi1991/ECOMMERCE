<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Deal;
use App\Models\DealsProduct;
use App\Models\Product;
use Illuminate\Http\Request;
use PHPUnit\Exception;
use Response;

class ProductController extends Controller
{
    /**
     * @param Request $request
     * @return void
     */
    public function search(Request $request)
    {
        try {
            $input = $request->except(['token', 'secure_pass']);
            $search['categories'] = [];
            $search['brands'] = [];
            $search['products'] = [];

            if (!empty($input['q'])) {
                $categories = Category::where('category', 'like', '%' . $input['q'] . '%')
                    ->where('level', 3)
                    ->whereHas('products')
                    ->get();

                $brands = Brand::where('title', 'like', '%' . $input['q'] . '%')->whereHas('products')->get();

                $products = Product::select('product_title', 'price', 'slug', 'discount_type', 'discount_value', 'unit_id', 'unit_value', 'id', 'default_image', 'allow_add_to_cart_when_out_of_stock', 'apply_discount', 'category_id', 'brand_id')
                    ->with(['unit' => function ($q) {
                        return $q->select('unit', 'prefix', 'id');
                    }])
                    ->when($input['q'], function ($q) use ($input) {
                        return $q->where('product_title', 'LIKE', '%' . $input['q'] . '%');
                    })
                    ->where(['is_active' => 1, 'is_archive' => 0])
                    ->get();

                $search['categories'] = $categories;
                $search['brands'] = $brands;
                $search['products'] = $products;

            }
            return Response::json([
                'success' => true,
                'data' => $search,
                'status_code' => 200,
                'message' => 'Data Fetched'
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
     * @param $id
     * @return mixed
     */
    public function getDealProducts(Request $request, $id)
    {
        try {
            $input = $request->all();
            $deal = Deal::where('id', $id)->with('banner')->first();
            $productIds = DealsProduct::where('deal_id', $id)->get();
            if ($productIds) {
                $productIds = $productIds->pluck('product_id')->toArray();
            } else {
                $productIds = [];
            }
            $limit = 12;
            $page = $request->get('page_number');
            $offset = ($page - 1) * $limit;
            $products = Product::select('product_title', 'price', 'slug', 'discount_type', 'discount_value', 'unit_id', 'unit_value', 'id', 'default_image', 'allow_add_to_cart_when_out_of_stock', 'apply_discount', 'category_id', 'brand_id')
                ->with(['unit' => function ($q) {
                    return $q->select('unit', 'prefix', 'id');
                }])
                ->with('images')
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
                ->whereIn('id', $productIds)
                ->skip($offset)
                ->limit($limit)
                ->get();

            $categories = Category::with(['products' => function ($q) use ($productIds) {
                return $q->where(['is_active' => 1, 'is_archive' => 0])
                    ->whereIn('id', $productIds);
            }])->with(['sub_categories' => function ($q) {
                return $q->with('sub_categories');
            }])
                ->where('is_active', 1)
                ->where('level', 1)
                ->get();

            $brands = Brand::with(['products' => function ($q) use ($productIds) {
                return $q->where(['is_active' => 1, 'is_archive' => 0])
                    ->whereIn('id', $productIds);
            }])->where(['is_active' => 1])->get();

            $min_price = $max_price = 0;
            if ($products->count()) {
                $prices = $products->pluck('price')->toArray();
                $min_price = min($prices);
                $max_price = max($prices);
                if ($min_price === $max_price) {
                    $min_price = 0;
                }
            }

            $data['deal'] = $deal;
            $data['products'] = $products;
            $data['categories'] = $categories;
            $data['brands'] = $brands;
            $data['minPrice'] = $min_price;
            $data['maxPrice'] = $max_price;
            $data['total_products'] = $products->count();

            return Response::json([
                'success' => true,
                'data' => $data,
                'status_code' => 200,
                'message' => 'Data Fetched'
            ]);
        } catch (Exception $exception) {
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
     * @return \Illuminate\Http\JsonResponse
     */
    public function getProducts(Request $request)
    {
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
                ->with('images')
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

            $categories = Category::with(['products' => function ($q) {
                return $q->where(['is_active' => 1, 'is_archive' => 0]);
            }])->with(['sub_categories' => function ($q) {
                return $q->with('sub_categories');
            }])
                ->where('is_active', 1)
                ->where('level', 1);

            $brands = Brand::with(['products' => function ($q) {
                return $q->where(['is_active' => 1, 'is_archive' => 0]);
            }])->where(['is_active' => 1])->get();

            $min_price = $max_price = 0;
            if (!empty($input['min_price']) && !empty($input['max_price'])) {
                $min_price = $input['min_price'];
                $max_price = $input['max_price'];
            } else {
                $min_price = Product::where(['is_active' => 1, 'is_archive' => 0])->min('price');
                $max_price = Product::where(['is_active' => 1, 'is_archive' => 0])->max('price');
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
    public function getProduct($slug)
    {
        try {
            $product = Product::where(['slug' => $slug, 'is_active' => 1])->with(['category', 'unit', 'images'])->first();
            $similar_products = Product::where('category_id', $product->category_id)
                ->with(['unit' => function ($q) {
                    return $q->select('unit', 'prefix', 'id');
                }])
                ->with('images')
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
    public function getCategoryProducts(Request $request)
    {
        try {
            $input = $request->except(['token', 'secure_pass']);
            $category = Category::where('slug', $input['category'])
                ->with(['parent_category' => function ($q) {
                    return $q->with('parent_category');
                }])
                ->with(['products' => function ($q) {
                   return $q->where(['is_active' => 1, 'is_archive' => 0]);
                }])
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
                ->with('images')
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
                ->with(['products' => function ($q) use ($category) {
                    return $q->where(['is_active' => 1, 'is_archive' => 0, 'category_id' => $category->id]);
                }])
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
    public function getRecentProducts(Request $request)
    {
        try {
            $input = $request->all();
            $products = Product::whereIn('id', $input)->with('images')->get();
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
