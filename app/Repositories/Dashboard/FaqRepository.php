<?php

namespace App\Repositories\Dashboard;

use App\Models\Faq;

class FaqRepository
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }
    public function getAllFaqs()
    {
        return Faq::all();
    }
    public function findFaqById($id)
    {
        $faq = Faq::find($id);
        return $faq;
    }
    public function createFaq($data)
    {
        $faq = Faq::create($data);
        return $faq;
    }
    public function updateFaq($faq, $data)
     {
          $faq = $faq->update($data);
          return $faq;
     }
    public function deleteFaq($faq)
    {
        $faq = $faq->delete();
        return $faq;
    }

}
