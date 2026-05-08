<?php

namespace App\Repositories\Website;

use App\Models\FaqQuestion;

class FaqRepository
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }
    public function createFaqQuestion($data){
       $faqQuestion = FaqQuestion::create($data);
       if(!$faqQuestion){
          return abort(404);
       }
       return $faqQuestion;
    }
}
