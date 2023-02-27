<?php

namespace App\Http\Controllers;

use App\Models\OrderSession;
use Illuminate\Http\Request;
use PDF;

class OrderController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index() {
        $orders = OrderSession::whereIn('order_status', ['pending', 'completed', 'cancelled'])
            ->with(['items', 'user'])
            ->whereHas('items')
            ->whereHas('user')
            ->get();

        $data['title'] = __('lang.orders');
        $data['orders'] = $orders;

        return view('pages.orders.index')->with($data);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function changeStatus(Request $request) {
        try {
            $input = $request->except('_token');
            OrderSession::where('id', $input['id'])->update($input);

            return back()->with('message', 'success=' . __('lang.saved_success', ['field' => __('lang.order')]));
        } catch (\Exception $exception) {
            return back()->with('message', 'danger=' . __('lang.illegal_error'));
        }
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function detail($id) {
        $invoice = explode('_', $id);
        $order = OrderSession::where('id', $invoice[1])
            ->with(['items', 'user'])->first();

        $data['title'] = __('lang.order_detail');
        $data['order'] = $order;
        return view('pages.orders.detail')->with($data);
    }

    /**
     * @param $id
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function PDF() {
        $id = request()->get('id');
        $order = OrderSession::where('id', $id)
            ->with(['items', 'user'])->first();
        view()->share('order', $order);
        $pdf = PDF::loadView('pages.orders.pdf', ['order' => $order]);
        return $pdf->download("invoice.pdf");
    }
}
