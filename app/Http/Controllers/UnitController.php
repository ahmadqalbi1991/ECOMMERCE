<?php

namespace App\Http\Controllers;

use App\Models\ProductUnit;
use Illuminate\Http\Request;
use SebastianBergmann\CodeCoverage\Report\Xml\Unit;

class UnitController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index () {
        $data['title'] = __('lang.units');
        $data['units'] = ProductUnit::all();
        return view('pages.units.index')->with($data);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request) {
        $inputs = $request->all();
        ProductUnit::create($inputs);

        return back()->with('message', 'success=' . __('lang.saved_success', ['field' => __('lang.brand')]));
    }
}
