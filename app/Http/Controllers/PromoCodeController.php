<?php

namespace App\Http\Controllers;

use App\Models\PromoCode;
use App\Models\PromoCodeUser;
use App\Models\Setting;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PromoCodeController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index() {
        $data['title'] = __('lang.promo_codes');
        $data['promo_codes'] = PromoCode::all();
        $data['is_active'] = Setting::first()->allow_promo_code;

        return view('pages.promo-codes.index')->with($data);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create() {
        $data['title'] = __('lang.add_option', ['field' => __('lang.promo_code')]);
        $data['users'] = User::where(['role' => 'b2c', 'is_verified' => 1, 'is_active' => 1])->get();

        return view('pages.promo-codes.create')->with($data);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request) {
        try {
            $input = $request->except('_token');
            $validity_dates = explode('-', $input['validity_date']);
            $input['validity_from'] = Carbon::parse($validity_dates[0])->format('Y-m-d');
            $input['validity_to'] = Carbon::parse($validity_dates[1])->format('Y-m-d');
            $input['code'] = $input['promo_code'];
            $result = PromoCode::create($input);

            if ($result) {
                if (empty($input['for_all_users'])) {
                    $users = $input['users'];
                    foreach ($users as $id) {
                        $user['user_id'] = $id;
                        $user['promo_code_id'] = $result->id;
                        PromoCodeUser::create($user);
                    }
                }

                return redirect()->route('promo-codes.index')->with('message', 'success=' . __('lang.saved_success', ['field' => __('lang.promo_code')]));
            } else {
                return back()->with('message', 'error=' . __('lang.illegal_error'));
            }
        } catch (\Exception $exception) {
            return back()->with('message', 'error=' . __('lang.illegal_error'));
        }
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit($id) {
        $data['title'] = __('lang.edit_option', ['field' => __('lang.promo_code')]);
        $data['users'] = User::where(['role' => 'b2c', 'is_verified' => 1, 'is_active' => 1])->get();
        $data['promo'] = PromoCode::where('id', $id)->with('users')->first();
        $promo_users = [];
        if (!$data['promo']->for_all_users && $data['promo']->users->count()) {
            $promo_users = $data['promo']->users;
            $promo_users = $promo_users->pluck('user_id')->toArray();
        }
        $data['promo_users'] = $promo_users;

        return view('pages.promo-codes.edit')->with($data);
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update (Request $request, $id) {
        try {
            $input = $request->except('_token');
            $validity_dates = explode('-', $input['validity_date']);
            $update = [
                'title' => $input['title'],
                'validity_from' => Carbon::parse($validity_dates[0])->format('Y-m-d'),
                'validity_to' => Carbon::parse($validity_dates[1])->format('Y-m-d'),
                'description' => $input['description'],
                'is_active' => $input['is_active'],
                'consumption' => $input['consumption'],
                'for_all_users' => empty($input['for_all_users']) ? 0 : 1,
                'promo_code_type' => $input['promo_code_type'],
                'value' => $input['value']
            ];
            $result = PromoCode::where('id', $id)->update($update);

            if ($result) {
                if (empty($input['for_all_users'])) {
                    PromoCodeUser::where('promo_code_id', $id)->delete();
                    $users = $input['users'];
                    foreach ($users as $user_id) {
                        $user['user_id'] = $user_id;
                        $user['promo_code_id'] = $id;
                        PromoCodeUser::create($user);
                    }
                }

                return back()->with('message', 'success=' . __('lang.saved_success', ['field' => __('lang.promo_code')]));
            } else {
                return back()->with('message', 'error=' . __('lang.illegal_error'));
            }
        } catch (\Exception $exception) {
            dd($exception);
            return back()->with('message', 'error=' . __('lang.illegal_error'));
        }
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete($id) {
        $promo = PromoCode::where('id', $id)->first();
        $promo->users()->delete();
        $promo->delete();

        return back()->with('message', 'success=' . __('lang.delete_success', ['field' => __('lang.promo_code')]));
    }
}
