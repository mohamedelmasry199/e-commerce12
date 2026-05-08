<div class="form-group">
    <div class="btn-group" role="group" aria-label="Button group with nested dropdown">

        <a href="javascript:void(0)" question-id="{{ $item->id }}"  class="delete_confirm_btn btn btn-outline-danger">
            {{ __('dashboard.delete') }} <i class="la la-trash"></i>
        </a>
        <a href="{{ route('dashboard.faq.question.replyForm',$item->id) }}" question-id="{{ $item->id }}"  class="reply_btn btn btn-outline-danger">
            {{ __('dashboard.reply') }} <i class="la la-reply"></i>
        </a>

    </div>
</div>
