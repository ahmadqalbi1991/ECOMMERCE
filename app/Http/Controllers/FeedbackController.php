<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use Illuminate\Http\Request;

class FeedbackController extends Controller
{
    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index () {
        $feedbacks = Feedback::with('user')->latest()->get();
        $data['title'] = __('lang.feedbacks');
        $data['feedbacks'] = $feedbacks;

        return view('pages.feedbacks.index')->with($data);
    }

    /**
     * @param $id
     * @param $status
     * @return \Illuminate\Http\RedirectResponse
     */
    public function handlePublished($id, $status) {
        Feedback::where('id', $id)->update(['published' => $status]);
        return back();
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete($id) {
        Feedback::where('id', $id)->delete();
        return back();
    }
}
