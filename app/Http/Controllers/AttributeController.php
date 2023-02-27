<?php

namespace App\Http\Controllers;

use App\Models\Attribute;
use App\Models\AttributeOption;
use Illuminate\Http\Request;

class AttributeController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index () {
        $data['title'] = __('lang.product_attributes');
        $data['attributes'] = Attribute::latest()->get();

        return view('pages.attributes.index')->with($data);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store (Request $request) {
        try {
            $inputs = $request->except('_token');
            $attribute['attribute'] = $inputs['attribute'];
            $attribute_obj = Attribute::create($attribute);
            if ($attribute_obj && isset($inputs['options'])) {
                foreach ($inputs['options'] as $option) {
                    $option_obj['option'] = $option;
                    $option_obj['attribute_id'] = $attribute_obj->id;

                    AttributeOption::create($option_obj);
                }
            }

            return back()->with('message', 'success=' . __('lang.saved_success', ['field' => __('lang.attr_and_options')]));
        } catch (\Exception $e) {
            return back()->with('message', 'error=' . __('lang.illegal_error'));
        }
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit ($id) {
        $attribute = Attribute::where('id', $id)->with('options')->first();
        $data['title'] = $attribute->title;
        $data['attribute'] = $attribute;

        return view('pages.attributes.edit')->with($data);
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update (Request $request, $id) {
        try {
            $inputs = $request->except('token');
            $attribute_obj = [
                'attribute' => $inputs['attribute']
            ];
            $attribute = Attribute::findOrFail($id);
            $attribute->update($attribute_obj);
            $options = $inputs['options'];
            $attribute->options()->delete();

            foreach ($options as $option) {
                AttributeOption::create(['option' => $option, 'attribute_id' => $id]);
            }

            return back()->with('message', 'success=' . __('lang.saved_success', ['field' => __('lang.attr_and_options')]));
        } catch (\Exception $e) {
            return back()->with('message', 'error=' . __('lang.illegal_error'));
        }
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete ($id) {
        try {
            $attribute = Attribute::findOrFail($id);
            $attribute->options()->delete();
            $attribute->delete();

            return back()->with('message', 'success=' . __('lang.delete_success', ['field' => __('lang.attr_and_options')]));
        } catch (\Exception $e) {
            return back()->with('message', 'error=' . __('lang.illegal_error'));
        }
    }
}
