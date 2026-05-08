<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Services\Dashboard\FaqQuestionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class FaqQuestionController extends Controller
{
    protected $faqQuestionService;
    public function __construct(FaqQuestionService $faqQuestionService)
    {
        $this->faqQuestionService = $faqQuestionService;
    }
    public function index()
    {
        return view('dashboard.faq-questions.index');
    }
    public function getAll()
    {
        return $this->faqQuestionService->getFaqQuestionForDatatables();
    }
    public function destroy($id)
    {
        $question = $this->faqQuestionService->deleteFaqQuestion($id);
        if ($question) {
            return response()->json([
                'status' => 'success',
                'message' => __('dashboard.success_msg'),
            ], 200);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => __('dashboard.error_msg'),
            ], 500);
        }
    }
    public function showReplyForm($id){
        $question = $this->faqQuestionService->getFaqQuestion($id);
        return view('dashboard.faq-questions.showReplyForm',compact('question'));
    }
    public function reply(Request $request,$id){
          $request->validate([
        'reply' => 'required|string|min:3',
    ]);
    $reply =$this->faqQuestionService->reply($id,$request->reply);
    if(!$reply){
        Session::flash('error' , trans('dashboard.error_msg'));
            return redirect()->back();
    }
            Session::flash('success' , trans('dashboard.success_msg'));
 return redirect()->route('dashboard.faq.questions.index');
    }
}
