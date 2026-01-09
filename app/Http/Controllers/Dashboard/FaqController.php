<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use App\Services\Dashboard\FaqService;
use Illuminate\Http\Request;
use App\Http\Requests\Dashboard\FaqRequest;


class FaqController extends Controller
{
    protected $faqService;
    public function __construct(FaqService $faqService)
    {
        $this->faqService = $faqService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $faqs = $this->faqService->getAllFaqs();
        return view('dashboard.faqs.index', compact('faqs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    // public function create()
    // {
    //     return view('dashboard.faqs.create');
    // }

    /**
     * Store a newly created resource in storage.
     */
    public function store(FaqRequest $request)
    {
       $faq = $this->faqService->createFaq($request->all());
       //api
       if(!$faq){
            return response()->json(
                ['status'=>'error',
                'message'=>__('dashboard.error_msg')],
                500
            );
            }
          return response()->json(['status' => 'success', 'message' => __('dashboard.success_msg'), 'data' => $faq], 201 );
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(FaqRequest $request, string $id)
    {
        $faq = $this->faqService->updateFaq($id, $request->all());
        if(!$faq){
            return response()->json(
                ['status'=>'error',
                'message'=>__('dashboard.error_msg')],
                500
            );
            }
            $faqAfterUpdate = $this->faqService->findFaqById($id);
          return response()->json(['status' => 'success', 'message' => __('dashboard.success_msg'), 'data' => $faqAfterUpdate], 200 );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $faq = $this->faqService->deleteFaq($id);
        //api
        if(!$faq){
            return response()->json(
                ['status'=>'error',
                'message'=>__('dashboard.error_msg')],
                500
            );
            }
          return response()->json(['status' => 'success', 'message' => __('dashboard.success_msg')], 200 );
    }
}
