<?php

namespace App\Http\Controllers;

use App\Models\Deal;
use App\Models\DealsProduct;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DealsController extends Controller
{
    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index() {
        $data['title'] = __('lang.deals');
        $data['deals'] = Deal::all();

        return view('pages.deals.index')->with($data);
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create() {
        $data['title'] = __('lang.add_option', ['field' => __('lang.deal')]);
        $data['products'] = Product::where(['is_active' => 1, 'is_archive' => 0])->orderBy('product_title')->get();

        return view('pages.deals.create')->with($data);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request) {
        try {
            $input = $request->except('_token');
            $products = $input['products'];
            $date = explode('-', $input['validity_date']);
            $input['validity_from'] = Carbon::parse($date[0])->format('Y-m-d');
            $input['validity_to'] = Carbon::parse($date[1])->format('Y-m-d');
            $deal = Deal::create($input);
            if ($deal) {
                foreach ($products as $product) {
                    DealsProduct::create(['deal_id' => $deal->id, 'product_id' => $product]);
                }
            }

            return redirect()->route('deals.index')->with('message', 'success=' . __('lang.saved_success', ['field' => __('lang.deal')]));
        } catch (\Exception $exception) {
            return back()->with('message', 'error=' . __('lang.illegal_error'));
        }
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit($id) {
        $data['title'] = __('lang.edit_option', ['field' => __('lang.deal')]);
        $data['products'] = Product::where(['is_active' => 1, 'is_archive' => 0])->orderBy('product_title')->get();
        $deal = Deal::where('id', $id)->with('products')->first();
        $products = $deal->products->pluck('product_id');
        $data['deal'] = $deal;
        $data['selectedProducts'] = $products->toArray();

        return view('pages.deals.edit')->with($data);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update($id, Request $request) {
        try {
            $input = $request->except('_token');
            $products = $input['products'];
            $date = explode('-', $input['validity_date']);
            $input['validity_from'] = Carbon::parse($date[0])->format('Y-m-d');
            $input['validity_to'] = Carbon::parse($date[1])->format('Y-m-d');
            unset($input['products'], $input['validity_date']);
            $deal = Deal::where('id', $id)->update($input);
            if ($deal) {
                DealsProduct::where('deal_id', $id)->delete();
                foreach ($products as $product) {
                    DealsProduct::create(['deal_id' => $id, 'product_id' => $product]);
                }
            }

            return redirect()->route('deals.index')->with('message', 'success=' . __('lang.saved_success', ['field' => __('lang.deal')]));
        } catch (\Exception $exception) {
            return back()->with('message', 'error=' . __('lang.illegal_error'));
        }
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete($id) {
        DealsProduct::where('deal_id', $id)->delete();
        Deal::where('id', $id)->delete();

        return back()->with('message', 'success=' . __('lang.delete_success', ['field' => __('lang.deal')]));
    }

    /**
     * @param $id
     * @param $status
     * @return \Illuminate\Http\RedirectResponse
     */
    public function changeStatus($id, $status) {
        Deal::where('id', $id)->update(['is_active' => $status]);

        return back()->with('message', 'success=' . __('lang.saved_success', ['field' => __('lang.deal')]));
    }
}
