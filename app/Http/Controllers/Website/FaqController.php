<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Services\Website\FaqService;
use Illuminate\Http\Request;

class FaqController extends Controller
{
    protected $faqService;
    public function __construct(FaqService $faqService)
    {
        $this->faqService = $faqService;
    }
    public function showFaqPage()
    {
        $faqs = $this->faqService->getFaqs();
        return view('website.faq' , ['faqs'=>$faqs]);
    }
}
