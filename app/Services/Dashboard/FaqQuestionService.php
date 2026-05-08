<?php

namespace App\Services\Dashboard;

use App\Mail\ReplyFaqMail;
use App\Repositories\Dashboard\FaqQuestionRepository;
use Illuminate\Support\Facades\Mail;
use Yajra\DataTables\Facades\DataTables;

class FaqQuestionService
{
    /**
     * Create a new class instance.
     */
    protected $faqQuestionRepository;
    public function __construct(FaqQuestionRepository $faqQuestionRepository)
    {
        $this->faqQuestionRepository = $faqQuestionRepository;
    }
    public function getFaqQuestion($id){
        $question = $this->faqQuestionRepository->getFaqQuestionById($id);
        if(!$question){
            return abort(404);
        }
        return $question;
    }

    public function getFaqQuestionForDatatables()
    {
        $questions = $this->faqQuestionRepository->getFaqQuestions();
        return DataTables::of($questions)
            ->addIndexColumn()
            ->addColumn('action', function ($item) {
                return view('dashboard.faq-questions.datatables.action', compact('item'))->render();
            })
            ->addColumn('message', function ($item) {
                return view('dashboard.faq-questions.datatables.content', compact('item'));
            })
            ->addColumn('reply', function ($item) {
                return view('dashboard.faq-questions.datatables.reply', compact('item'));
            })
            ->make(true);
    }

    public function deleteFaqQuestion($faqQuestionId)
    {
        $question = $this->faqQuestionRepository->getFaqQuestionById($faqQuestionId);
        if (!$question) {
            return false;
        }
        return $this->faqQuestionRepository->deleteFaqQuestion($question);
    }
    public function reply($id,$request_reply)
    {
        $question = $this->getFaqQuestion($id);
        $this->faqQuestionRepository->reply($question,$request_reply);
        Mail::to($question->email)->send(new ReplyFaqMail($question->email, $question->reply, $question->subject));
        return true;
    }

}
