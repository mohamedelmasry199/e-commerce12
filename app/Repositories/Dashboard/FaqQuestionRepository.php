<?php

namespace App\Repositories\Dashboard;

use App\Models\FaqQuestion;

class FaqQuestionRepository
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }
    public function getFaqQuestionById($id)
    {
        return FaqQuestion::find($id);
    }
    public function getFaqQuestions()
    {
        return FaqQuestion::latest()->get();
    }


    public function deleteFaqQuestion($question)
    {
        return $question->delete();
    }
    public function reply($question ,$request_reply){
     $reply = $question->update(['reply' => $request_reply]);
     return $reply;

    }
}
