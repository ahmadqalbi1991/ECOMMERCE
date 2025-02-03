<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Jobs\ForgetPasswordJob;
use App\Jobs\RegisterSuccessEmailJob;
use App\Mail\ForgetPasswordEmail;
use App\Mail\RegisterSuccessEmail;
use App\Models\Address;
use App\Models\Feedback;
use App\Models\OrderItem;
use App\Models\OrderSession;
use App\Models\PointsHistory;
use App\Models\Profile;
use App\Models\PromoCode;
use App\Models\PromoCodeHistory;
use App\Models\Setting;
use App\Models\User;
use App\Models\UserSession;
use App\Models\WishList;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Response, Auth;

class UserController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register (Request $request) {
        try {
            $input = $request->all();
            $user = User::where('email', $input['email'])->first();
            if ($user) {
                return Response::json([
                    'success' => true,
                    null,
                    'status_code' => 500,
                    'message' => __('lang.already_taken', ['field' => __('lang.email')])
                ], 200);
            }

            $random_card_number = rand(0, 99999999999999);
            $random_card_number = '92' . $random_card_number;
            $check_billu_card = User::where('billu_card_number', $random_card_number)->first();
            if ($check_billu_card) {
                $random_card_number = rand(14);
                $random_card_number = '92' . $random_card_number;
            }

            $verification_code = \Str::random(50);
            $input['password'] = bcrypt($input['password']);
            $input['verification_code'] = $verification_code;
            $input['is_verified'] = 0;
            $input['name'] = $input['first_name'] . ' ' . $input['last_name'];
            $input['role'] = 'b2c';
            $input['billu_card_number'] = $check_billu_card;

            $user = User::create($input);
            if ($user) {
                $profile['full_name'] = $user->name;
                $profile['user_id'] = $user->id;

                Profile::create($profile);
                $data['verification_code'] = base64_encode($verification_code);
                $data['email'] = $input['email'];
                $data['id'] = $user->id;
                $data['name'] = $input['first_name'] . ' ' . $input['last_name'];
                $data['setting'] = Setting::first();

                dispatch(new RegisterSuccessEmailJob($data));
            }

            return Response::json([
                'success' => true,
                [
                    'token' => $user->createToken('MyApp')->accessToken
                ],
                'status_code' => 200,
                'message' => __('lang.register_success')
            ], 200);
        } catch (\Exception $exception) {
            return Response::json([
                'success' => true,
                null,
                'status_code' => 500,
                'message' => $exception->getMessage()
            ], 500);
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function verifyUser (Request $request) {
        try {
            $input = $request->all();
            $token = base64_decode($input['token']);
            $id = $input['secure_pass'];

            User::where(['verification_code' => $token, 'id' => $id])->update(['is_verified' => 1, 'is_active' => 1]);

            return Response::json([
                'success' => true,
                [],
                'status_code' => 200,
                'message' => __('lang.user_verified_success')
            ], 200);
        } catch (\Exception $exception) {
            return Response::json([
                'success' => true,
                null,
                'status_code' => 500,
                'message' => $exception->getMessage()
            ], 500);
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function userLogin(Request $request) {
        try {
            $input = $request->only('email', 'password');
            if (Auth::attempt($input)) {
//                if (Auth::user()->is_verified) {
                    $token = \Str::random(60);
                    $user = Auth::user();
                    UserSession::updateOrCreate(['user_id' => $user->id], ['token' => $token, 'user_id' => Auth::id()]);
                    $data['token'] = $user->createToken('token')->accessToken;
                    $data['secure_pass'] = $token;
                    $data['email'] = $input['email'];

                    return Response::json([
                        'success' => true,
                        "data" => $data,
                        'status_code' => 200,
                        'message' => __('lang.success_login')
                    ], 200);
//                } else {
//                    return Response::json([
//                        'success' => true,
//                        null,
//                        'status_code' => 500,
//                        'message' => __('lang.account_is_not_active')
//                    ], 500);
//                }
            } else {
                return Response::json([
                    'success' => true,
                    null,
                    'status_code' => 500,
                    'message' => __('lang.invalid_credentials')
                ], 500);
            }

        } catch (\Exception $exception) {
            return Response::json([
                'success' => true,
                null,
                'status_code' => 500,
                'message' => $exception->getMessage()
            ], 500);
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getUserByToken(Request $request) {
        try {
            $input = $request->all();
            $user_session = UserSession::where('token', $input['secure_pass'])->first();
            $user = User::where('id', $user_session->user_id)->with('profile')->first();

            return Response::json([
                'success' => true,
                "user" => $user,
                'status_code' => 200,
                'message' => __('lang.success_login')
            ], 200);
        } catch (\Exception $exception) {
            return Response::json([
                'success' => true,
                null,
                'status_code' => 500,
                'message' => $exception->getMessage()
            ], 500);
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function saveAddress(Request $request) {
        try {
            $input = $request->all();
            $input['user_id'] = Auth::id();
            Address::where(['active' => 1])->update(['active' => 0]);
            $input['active'] = 1;
            $address_result = Address::create($input);
            if ($address_result) {
                return Response::json([
                    'success' => true,
                    'address' => $address_result,
                    'status_code' => 200,
                    'message' => __('lang.address_added')
                ], 200);
            } else {
                return Response::json([
                    'success' => false,
                    null,
                    'status_code' => 500,
                    'message' => __('lang.something_went_wrong')
                ], 500);
            }
        } catch (\Exception $exception) {
            return Response::json([
                'success' => true,
                null,
                'status_code' => 500,
                'message' => $exception->getMessage()
            ], 500);
        }
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAddress() {
        try {
            $addresses = Address::where('user_id', Auth::id())->get();

            return Response::json([
                'success' => true,
                'addresses' => $addresses,
                'status_code' => 200,
                'message' => __('lang.result_found')
            ], 200);
        } catch (\Exception $exception) {
            return Response::json([
                'success' => true,
                null,
                'status_code' => 500,
                'message' => $exception->getMessage()
            ], 500);
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function activeAddress(Request $request) {
        try {
            $inputs = $request->all();
            Address::where('id', '!=', $inputs['address_id'])->update(['active' => 0]);
            $address = Address::where(['id' => $inputs['address_id'], 'user_id' => Auth::id()])->update(['active' => 1]);
            if ($address) {
                return Response::json([
                    'success' => true,
                    null,
                    'status_code' => 200,
                    'message' => __('lang.result_found')
                ], 200);
            } else {
                return Response::json([
                    'success' => false,
                    null,
                    'status_code' => 500,
                    'message' => __('lang.something_went_wrong')
                ], 500);
            }
        } catch (\Exception $exception) {
            return Response::json([
                'success' => true,
                null,
                'status_code' => 500,
                'message' => $exception->getMessage()
            ], 500);
        }
    }

    /*
     *
     */
    public function deleteAddress($id) {
        try {
            Address::where('id', $id)->delete();
            return Response::json([
                'success' => true,
                null,
                'status_code' => 200,
                'message' => __('lang.delete_success', ['field' => __('lang.address')])
            ], 200);
        } catch (\Exception $exception) {
            return Response::json([
                'success' => true,
                null,
                'status_code' => 500,
                'message' => $exception->getMessage()
            ], 500);
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function saveOrderSession(Request $request) {
        try {
            $input = $request->all();
            $input['user_id'] = Auth::id();
            $input['order_status'] = 'pending';
            $setting = Setting::first();

            $points_generated = 0;
            if ($setting->allow_billu_points) {
                $price_of_points = $setting->allow_points_on_price;
                if ($input['sub_total'] >= $price_of_points) {
                    $points_generated = round($input['sub_total'] / $price_of_points, 0);
                }
            }
            $input['points_earned'] = $points_generated;

            $order = OrderSession::create($input);
            if ($order) {
                $items = json_decode($input['cart_items']);
                foreach ($items as $item) {
                    $order_item['order_id'] = $order->id;
                    $order_item['product_id'] = $item->id;
                    $order_item['qty'] = $item->qty;
                    $order_item['price'] = $item->price;

                    OrderItem::create($order_item);
                }

                $user = User::find(Auth::id());

                if (!empty($input['points_applied'])) {
                    $history = [
                        'user_id' => Auth::id(),
                        'points' => $input['points'],
                        'action' => 'debit',
                        'order_session_id' => $order->id
                ];

                    PointsHistory::create($history);
                    $user->billu_points = $user->billu_points - $input['points'];
                    $user->save();
                }

                if ($points_generated > 0) {
                    $user->billu_points = $user->billu_points + $points_generated;
                    $user->save();

                    $history = [
                        'user_id' => Auth::id(),
                        'points' => $user->billu_points,
                        'action' => 'credit',
                        'order_session_id' => $order->id
                    ];

                    PointsHistory::create($history);
                }

                if (!empty($input['promoCode'])) {
                    PromoCodeHistory::where(['id' => $input['promoCodeId']])->update(['order_id' => $order->id]);
                }

                return Response::json([
                    'success' => true,
                    null,
                    'status_code' => 200,
                    'message' => __('lang.order_success')
                ], 200);
            } else {
                return Response::json([
                    'success' => true,
                    null,
                    'status_code' => 200,
                    'message' => __('lang.something_went_wrong')
                ], 500);
            }
        } catch (\Exception $exception) {
            return Response::json([
                'success' => true,
                null,
                'status_code' => 500,
                'message' => $exception->getMessage()
            ], 500);
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function applyCode (Request $request) {
        try {
            $code = $request->get('code');
            $amount = $request->get('amount');

            $promo_code = PromoCode::where('code', $code)->first();
            if (!$promo_code) {
                return Response::json([
                    'success' => false,
                    null,
                    'status_code' => 500,
                    'message' => __('lang.not_found', ['field' => __('lang.promo_code')])
                ], 500);
            }

            if (!$promo_code->is_active) {
                return Response::json([
                    'success' => false,
                    null,
                    'status_code' => 500,
                    'message' => __('lang.not_found', ['field' => __('lang.promo_code')])
                ], 500);
            }

            if (Carbon::now()->format('Y-m-d') > $promo_code->validity_to) {
                return Response::json([
                    'success' => false,
                    null,
                    'status_code' => 500,
                    'message' => __('lang.promo_code_expire')
                ], 500);
            }

            if ($promo_code->for_all_users) {
                return self::checkCodeResponse($promo_code, $amount);
            }

            if (!$promo_code->for_all_users) {
                if (!$promo_code->users()->count()) {
                    return Response::json([
                        'success' => false,
                        null,
                        'status_code' => 500,
                        'message' => __('lang.not_found', ['field' => __('lang.promo_code')])
                    ], 500);
                }

                return self::checkCodeResponse($promo_code, $amount);
            }
        } catch (\Exception $exception) {
            return Response::json([
                'success' => true,
                null,
                'status_code' => 500,
                'message' => $exception->getMessage()
            ], 500);
        }
    }

    /**
     * @param $promo_code
     * @param $amount
     * @return \Illuminate\Http\JsonResponse
     */
    public static function checkCodeResponse($promo_code, $amount) {
        $result = self::verifyCode($promo_code, $amount);
        if (!$result) {
            return Response::json([
                'success' => true,
                null,
                'status_code' => 500,
                'message' => __('lang.promo_code_consumption_exceed')
            ], 500);
        } else {
            $data['history_id'] = $result['id'];
            $data['amount'] = $result['amount'];
            $data['code'] = $promo_code;

            return Response::json([
                'success' => true,
                'result' => $data,
                'status_code' => 200,
                'message' => __('lang.promo_code_applied_success')
            ], 200);
        }
    }

    /**
     * @param $code
     * @param $amount
     * @return int|mixed
     */
    public static function verifyCode($code, $amount) {
        if ($code->consumption !== 'any') {
            $offers_consumes = PromoCodeHistory::where(['user_id' => Auth::id(), 'promo_code_id' => $code->id])->count();
            if ($offers_consumes == $code->consumption) {
                return 0;
            }
        }

        return self::applyCodeDiscount($code, $amount);
    }

    /**
     * @param $code
     * @param $amount
     * @return mixed
     */
    public static function applyCodeDiscount($code, $amount) {
        if ($code->promo_code_type === 'percentage') {
            $percentage_amount = $amount * ($code->value / 100);
            $amount = $percentage_amount;
        }

        if ($code->promo_code_type === 'price') {
            $amount = $code->value;
        }

        $history = [
            'user_id' => Auth::id(),
            'promo_code_id' => $code->id,
            'promo_code_discount' => $amount,
            'order_id' => null
        ];

        return ['id' => PromoCodeHistory::create($history)->id, 'amount' => $amount];
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getPointsHistory(Request $request) {
        try {
            $limit = 10;
            $page = $request->get('page');
            $offset = ($page - 1) * $limit;
            $data['history'] = PointsHistory::where('user_id', Auth::id())
                ->skip($offset)
                ->limit($limit)
                ->get();
            $data['total_records'] = PointsHistory::where('user_id', Auth::id())->count();
            $data['points'] = Auth::user()->billu_points;

            return Response::json([
                'success' => true,
                'data' => $data,
                'status_code' => 200,
                'message' => 'History Get',
            ], 200);
        } catch (\Exception $exception) {
            return Response::json([
                'success' => false,
                null,
                'status_code' => 500,
                'message' => $exception->getMessage()
            ], 500);
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateProfile(Request $request) {
        try {
            $input = $request->all();
            $user = User::where('id', Auth::id())->first();
            $user->name = $input['name'];
            $user->email = $input['email'];
            $user->save();
            $profile = Profile::where('user_id', Auth::id())->first();
            $profile->full_name = $input['name'];
            $profile->contact_number = $input['contact_number'];
            $profile->national_id_card_number = $input['national_id_card_number'];
            $profile->dob = Carbon::parse($input['dob'])->format('Y-m-d');
            $profile->save();

            return Response::json([
                'success' => true,
                [],
                'status_code' => 200,
                'message' => __('lang.saved_success', ['field' => __('lang.profile')]),
            ], 200);
        } catch (\Exception $exception) {
            return Response::json([
                'success' => false,
                null,
                'status_code' => 500,
                'message' => $exception->getMessage()
            ], 500);
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function myOrders(Request $request) {
        try {
            $limit = $request->get('limit');

            $orders = OrderSession::where(['user_id' => Auth::id()])
                ->where('order_status', '!=', 'returned')
                ->limit($limit)
                ->with('items')
                ->whereHas('items')
                ->get();

            $orders_count = OrderSession::where(['user_id' => Auth::id()])
                ->where('order_status', '!=', 'returned')
                ->with('items')
                ->whereHas('items')
                ->count();

            $data['orders'] = $orders;
            $data['count'] = $orders_count;

            return Response::json([
                'success' => true,
                'data' => $data,
                'status_code' => 200,
                'message' => 'Orders Get Success',
            ], 200);
        } catch (\Exception $exception) {
            return Response::json([
                'success' => false,
                null,
                'status_code' => 500,
                'message' => $exception->getMessage()
            ], 500);
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function returnOrder(Request $request) {
        try {
            $input = $request->all();
            $order = OrderSession::where(['id' => $input['id'], 'user_id' => Auth::id()])->first();

            if (!$order) {
                return Response::json([
                    'success' => false,
                    null,
                    'status_code' => 500,
                    'message' => 'You are not allowed'
                ], 500);
            }

            $order->order_status = 'returned';
            $order->save();

            return Response::json([
                'success' => true,
                null,
                'status_code' => 200,
                'message' => __('lang.order_has_been_returned')
            ], 200);
        } catch (\Exception $exception) {
            return Response::json([
                'success' => false,
                null,
                'status_code' => 500,
                'message' => $exception->getMessage()
            ], 500);
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function myReturns(Request $request) {
        try {
            $limit = $request->get('limit');

            $orders = OrderSession::where(['user_id' => Auth::id()])
                ->where('order_status', 'returned')
                ->limit($limit)
                ->with('items')
                ->whereHas('items')
                ->get();

            $orders_count = OrderSession::where(['user_id' => Auth::id()])
                ->where('order_status', 'returned')
                ->with('items')
                ->whereHas('items')
                ->count();

            $data['orders'] = $orders;
            $data['count'] = $orders_count;

            return Response::json([
                'success' => true,
                'data' => $data,
                'status_code' => 200,
                'message' => 'Returns Get Success',
            ], 200);
        } catch (\Exception $exception) {
            return Response::json([
                'success' => false,
                null,
                'status_code' => 500,
                'message' => $exception->getMessage()
            ], 500);
        }
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function myWishList() {
        try {
            $wishlist = WishList::where('user_id', Auth::id())->with('product')->get();

            return Response::json([
                'success' => true,
                'wishlist' => $wishlist,
                'status_code' => 200,
                'message' => 'Returns Get Success',
            ], 200);
        } catch (\Exception $exception) {
            return Response::json([
                'success' => false,
                null,
                'status_code' => 500,
                'message' => $exception->getMessage()
            ], 500);
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function addToWishList(Request $request) {
        try {
            $input = $request->all();
            $input['user_id'] = Auth::id();
            $check_wishlist = WishList::where(['user_id' => $input['user_id'], 'product_id' => $input['product_id']])->first();
            if ($check_wishlist) {
                return Response::json([
                    'success' => false,
                    null,
                    'status_code' => 404,
                    'message' => __('lang.product_already_exists_in_wishlist')
                ], 404);
            }

            $wishlist = WishList::create($input);
            return Response::json([
                'success' => false,
                "data" => $wishlist,
                'status_code' => 200,
                'message' => __('lang.product_added_to_wishlist')
            ], 200);
        } catch (\Exception $exception) {
            return Response::json([
                'success' => false,
                null,
                'status_code' => 500,
                'message' => $exception->getMessage()
            ], 500);
        }
    }

    /**
     * @return mixed
     */
    public function logout() {
        try {
            $user = Auth::user()->token();
            $user->revoke();
            return Response::json([
                'success' => true,
                "data" => null,
                'status_code' => 200,
                'message' => __('lang.logout_success')
            ], 200);
        } catch (\Exception $exception) {
            return Response::json([
                'success' => false,
                null,
                'status_code' => 500,
                'message' => $exception->getMessage()
            ], 500);
        }
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function saveReview (Request $request) {
        try {
            $input = $request->all();
            $input['user_id'] = Auth::id();
            $success = Feedback::create($input);
            if ($success) {
                return Response::json([
                    'success' => true,
                    "data" => null,
                    'status_code' => 200,
                    'message' => __('lang.feedback_success')
                ], 200);
            } else {
                return Response::json([
                    'success' => false,
                    null,
                    'status_code' => 500,
                    'message' => __('lang.illegal_error')
                ], 500);
            }
        } catch (\Exception $exception) {
            return Response::json([
                'success' => false,
                null,
                'status_code' => 500,
                'message' => $exception->getMessage()
            ], 500);
        }
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function sendResetPasswordLink(Request $request) {
        try {
            $input = $request->all();
            $user = User::where('email', $input['email'])->first();
            if (!$user) {
                return Response::json([
                    'success' => false,
                    null,
                    'status_code' => 500,
                    'message' => __('passwords.user')
                ], 500);
            }

            $user->password = '';
            $user->save();
            $data['email'] = $user->email;
            $data['id'] = $user->id;
            $data['name'] = $user->first_name . ' ' . $user->last_name;
            $data['setting'] = Setting::first();

            dispatch(new ForgetPasswordJob($data));

            return Response::json([
                'success' => true,
                "data" => null,
                'status_code' => 200,
                'message' => __('lang.password_reset_link_sent')
            ], 200);
        } catch (\Exception $exception) {
            return Response::json([
                'success' => false,
                null,
                'status_code' => 500,
                'message' => $exception->getMessage()
            ], 500);
        }
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function resetPassword(Request $request) {
        try {
            $input = $request->all();
            $user = User::where(['id' => $input['id'], 'email' => $input['email']])->first();
            if (!$user) {
                return Response::json([
                    'success' => false,
                    null,
                    'status_code' => 500,
                    'message' => __('passwords.user')
                ], 500);
            }

            $user->password = bcrypt($input['password']);
            $user->save();

            return Response::json([
                'success' => true,
                "data" => null,
                'status_code' => 200,
                'message' => __('lang.success_login')
            ], 200);
        } catch (\Exception $exception) {
            return Response::json([
                'success' => false,
                null,
                'status_code' => 500,
                'message' => $exception->getMessage()
            ], 500);
        }
    }

    /**
     * @param $id
     * @return mixed
     */
    public function removeFromWishList($id) {
        try {
            WishList::where('id', $id)->delete();
            return Response::json([
                'success' => false,
                null,
                'status_code' => 200,
                'message' => __('lang.product_added_to_wishlist')
            ], 200);
        } catch (\Exception $exception) {
            return Response::json([
                'success' => false,
                null,
                'status_code' => 500,
                'message' => $exception->getMessage()
            ], 500);
        }
    }
}
