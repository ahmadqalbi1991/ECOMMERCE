<?php

namespace App\Http\Controllers;

use App\Models\Faq;
use Illuminate\Http\Request;

class FaqController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index() {
        $data['faqs'] = Faq::all();
        $data['title'] = __('lang.faqs');

        return view('pages.faqs.index')->with($data);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create() {
        $data['title'] = __('lang.add_option', ['field' => __('lang.faqs')]);
        return view('pages.faqs.create')->with($data);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request) {
        try {
            $input = $request->except('_token');
            $id = isset($input['id']) && $input['id'] ? $input['id'] : null;

            Faq::updateOrCreate(['id' => $id], $input);
            return redirect()->route('faqs.index')->with('message', 'success=' . __('lang.saved_success', ['field' => __('lang.faqs')]));

        } catch (\Exception $e) {
            return back()->with('message', 'error=' . __('lang.illegal_error'));
        }
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit($id) {
        $data['title'] = __('lang.edit_option', ['field' => __('lang.faqs')]);
        $data['faq'] = Faq::where('id', $id)->first();

        return view('pages.faqs.create')->with($data);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete($id) {
        Faq::where('id', $id)->delete();
        return back()->with('message', 'success=' . __('lang.delete_success', ['field' => __('lang.faqs')]));
    }
}
