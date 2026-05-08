<?php

namespace App\Services\Website;

use App\Repositories\Dashboard\FaqRepository;
use App\Repositories\Website\FaqRepository as WebsiteFaqRepository;

class FaqService
{
    /**
     * Create a new class instance.
     */
    protected $faqRepository,$websiteFaqRepository;
    public function __construct(FaqRepository $faqRepository,WebsiteFaqRepository $websiteFaqRepository)
    {
        $this->faqRepository =$faqRepository;
        $this->websiteFaqRepository =$websiteFaqRepository;
    }
      public function getFaqs()
    {
       return $this->faqRepository->getAllFaqs();
    }

    public function createFaqQuestion($data)
    {
        $faqQuestion = $this->websiteFaqRepository->createFaqQuestion($data);
        if(!$faqQuestion){
            return abort(404);
        }
        return $faqQuestion;
    }

}
