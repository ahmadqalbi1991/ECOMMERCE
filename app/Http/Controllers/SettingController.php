<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\City;
use App\Models\Deal;
use App\Models\Setting;
use Illuminate\Http\Request;
use function Symfony\Component\String\b;
use Storage;

class SettingController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index () {
        $data['title'] = __('lang.settings');
        $data['setting'] = Setting::with('banners')->first();
        $data['cities'] = City::all();
        $data['deals'] = Deal::where('is_active', 1)->doesntHave('banner')->get();

        return view('pages.setting.index')->with($data);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store (Request $request) {
        try {
            $inputs = $request->all();
            if (!isset($inputs['dark_mode'])) {
                $inputs['dark_mode'] = 0;
            }

            if (!isset($inputs['allow_brands'])) {
                $inputs['allow_brands'] = 0;
            }

            if ($request->hasFile('logo')) {
                $file_logo_name = 'logo';
                $logo_path = 'site/images';
                $file_logo_name = uploadSingleImage($request->file('logo'), $file_logo_name, $logo_path);
                $inputs['logo'] = $file_logo_name;
            }

            if ($request->hasFile('favicon')) {
                $file_favicon_name = 'favicon';
                $logo_path = 'site/images/';
                $file_favicon_name = uploadSingleImage($request->file('favicon'), $file_favicon_name, $logo_path);
                $inputs['favicon'] = $file_favicon_name;
            }

            $result = Setting::updateOrCreate(['id' => $inputs['id']], $inputs);
            if ($result) {
                return back()->with('message', 'success=' . __('lang.saved_success', ['field' => __('lang.settings')]));
            } else {
                return back()->with('message', 'error=' . __('lang.illegal_error'));
            }
        } catch (\Exception $e) {
            return back()->with('message', 'error=' . __('lang.illegal_error'));
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function saveBannerImages (Request $request) {
        try {
            if ($request->hasFile('banner')) {
                $file_banner_name = 'banner_' . time();
                $path = 'site/images/banners/';
                $result = uploadSingleImage($request->file('banner'), $file_banner_name, $path);
                if ($result) {
                    $banner['title'] = $file_banner_name . '.' . $request->file('banner')->getClientOriginalExtension();
                    $banner['path'] = $path;
                    $banner['setting_id'] = $request->get('id');
                    $banner['show_on_home'] = 1;
                    $banner['deal_id'] = $request->get('deal_id');
                    $banner['content_heading'] = $request->get('content_heading');
                    $banner['content'] = $request->get('content');
                    $banner['position'] = $request->get('position');
                    $banner['redirect_to_deal'] = 1;
                    $banner['home_page_banner'] = 1;
                    $banner['slider_banner'] = $request->get('slider_banner');

                    Banner::create($banner);

                    return back()->with('message', 'success=' . __('lang.saved_success', ['field' => __('lang.banner_img')]));
                }
            }
        } catch (\Exception $e) {
            return back()->with('message', 'error=' . __('lang.illegal_error'));
        }
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function changeStatus ($id) {
        $banner = Banner::where('id', $id)->first();
        $banner->show_on_home = $banner->show_on_home === 1 ? 0 : 1;
        $banner->save();

        return back()->with('message', 'success=' . __('lang.saved_success', ['field' => __('lang.banner_img')]));
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function deleteBanner ($id) {
        $banner = Banner::where('id', $id)->first();
        \Storage::delete($banner->path . $banner->title);
        $banner->delete();

        return back()->with('message', 'success=' . __('lang.delete_success', ['field' => __('lang.banner_img')]));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function saveCity (Request $request) {
        $input = $request->except('_token');
        if ($request->has('image')) {
            $file_city_name = $input['city'];
            $path = 'site/images/cities';
            $result = uploadSingleImage($request->file('image'), $file_city_name, $path);
            $input['image'] = $result;
        }

        $input['is_active'] = 1;
        City::create($input);

        return back()->with('message', 'success=' . __('lang.saved_success', ['field' => __('lang.city')]));
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function deleteCity($id) {
        $city = City::where('id', $id)->first();
        if (Storage::disk('local')->exists('public/' . $city->image)) {
            unlink(storage_path('app/public/' . $city->image));
        }
        $city->delete();

        return back()->with('message', 'success=' . __('lang.delete_success', ['field' => __('lang.city')]));
    }
}
