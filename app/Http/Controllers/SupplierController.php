<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    /**
     * @return Application|Factory|View
     */
    public function index() {
        $data['title'] = __('lang.suppliers');
        $data['suppliers'] = Supplier::all();

        return view('pages.suppliers.index')->with($data);
    }

    /**
     * @return RedirectResponse
     */
    public function save(Request $request) {
        $input = $request->except('_token');
        Supplier::create($input);

        return back()->with('message', 'success=' . __('lang.saved_success', ['field' => __('lang.supplier')]));
    }

    /**
     * @return Application|Factory|View
     */
    public function edit($id) {
        $data['title'] = __('lang.suppliers');
        $data['supplier'] = Supplier::findOrFail($id);

        return view('pages.suppliers.edit')->with($data);
    }

    /**
     * @param Request $request
     * @param $id
     * @return RedirectResponse
     */
    public function update(Request $request, $id) {
        $input = $request->except('_token');
        Supplier::where('id', $id)->update($input);

        return redirect()->route('suppliers.index')->with('message', 'success=' . __('lang.saved_success', ['field' => __('lang.supplier')]));
    }

    /**
     * @param $id
     * @return RedirectResponse
     */
    public function delete($id) {
        Supplier::where('id', $id)->delete();

        return back()->with('message', 'success=' . __('lang.delete_success', ['field' => __('lang.supplier')]));
    }
}
