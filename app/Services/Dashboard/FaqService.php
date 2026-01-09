<?php

namespace App\Services\Dashboard;

use App\Repositories\Dashboard\FaqRepository;

class FaqService
{
    /**
     * Create a new class instance.
     */
    protected $faqRepository;
    public function __construct(FaqRepository $faqRepository)
    {
        $this->faqRepository = $faqRepository;
    }
    public function getAllFaqs()
    {
        return $this->faqRepository->getAllFaqs();
    }
    public function findFaqById($id)
    {
        $faq = $this->faqRepository->findFaqById($id);
        if (!$faq) {
            abort(404);
        }
        return $faq;
    }
    public function createFaq($data)
    {
        $faq = $this->faqRepository->createFaq($data);
        return $faq;
    }
    public function updateFaq($id, $data)
    {
        $faq = $this->findFaqById($id);
        $faq = $this->faqRepository->updateFaq($faq, $data);
        return $faq;
    }
    public function deleteFaq($id)
    {
        $faq = $this->findFaqById($id);
        $faq = $this->faqRepository->deleteFaq($faq);
        return $faq;
    }

}
