<div class="modal fade" id="editfaqModal{{ $faq->id }}" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">

            <!-- Header -->
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">
                    <i class="la la-edit"></i> {{ __('dashboard.edit_faq') }}
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>

            <!-- Body -->
            <div class="modal-body">

                <div class="alert alert-danger" id="error_div_{{ $faq->id }}" style="display: none;">
                    <ul id="error_list_{{ $faq->id }}"></ul>
                </div>

                <form  faq-id="{{ $faq->id }}" id="updatefaq">
                    @csrf
                    <input type="hidden" name="_method" value="PUT">
                    <input type="hidden" name="id" id="edit_id">

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="font-weight-bold">{{ __('dashboard.question_ar') }}</label>
                                <input type="text" name="question[ar]" value="{{ $faq->getTranslation('question','ar') }}" class="form-control"
                                    placeholder="{{ __('dashboard.question_ar') }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="font-weight-bold">{{ __('dashboard.question_en') }}</label>
                                <input type="text" name="question[en]" class="form-control" value="{{ $faq->getTranslation('question','en') }}"
                                    placeholder="{{ __('dashboard.question_en') }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="font-weight-bold">{{ __('dashboard.answer_ar') }}</label>
                                <textarea class="form-control" name="answer[ar]">
                                    {{ $faq->getTranslation('answer','ar') }}
                        </textarea>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="font-weight-bold">{{ __('dashboard.answer_en') }}</label>
                                <textarea class="form-control" name="answer[en]">
                                    {{ $faq->getTranslation('answer','en') }}
                        </textarea>
                            </div>
                        </div>


                    </div>
                </form>
            </div>

            <!-- Footer -->
            <div class="modal-footer">
                <button class="btn btn-secondary" data-dismiss="modal">
                    {{ __('dashboard.close') }}
                </button>
                <button type="submit" form="updatefaq" class="update_faq_btn btn btn-primary" faq-id="{{ $faq->id }}">
                    {{ __('dashboard.save') }}
                </button>
            </div>

        </div>
    </div>
</div>
