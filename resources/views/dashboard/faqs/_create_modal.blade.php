<div class="modal fade" id="createfaqModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document"> <!-- Larger modal -->
        <div class="modal-content">

            <!-- Header -->
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">
                    <i class="la la-plus-circle"></i> {{ __('dashboard.create_faq') }}
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <!-- Body -->
            <div class="modal-body pt-1 pb-2">

                {{-- validations error --}}
                <div class="alert alert-danger" id="error_div" style="display: none;">
                    <ul id="error_list"></ul>
                </div>

                <form action="{{ route('dashboard.faqs.store') }}" method="POST" id="createfaq">
                    @csrf

                    <div class="row">

                        <!-- faq  -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="font-weight-bold">{{ __('dashboard.question_ar') }}</label>
                                <input type="text" name="question[ar]" class="form-control"
                                    placeholder="{{ __('dashboard.question_ar') }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="font-weight-bold">{{ __('dashboard.question_en') }}</label>
                                <input type="text" name="question[en]" class="form-control"
                                    placeholder="{{ __('dashboard.question_en') }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="font-weight-bold">{{ __('dashboard.answer_ar') }}</label>
                                <textarea class="form-control" name="answer[ar]">
                        </textarea>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="font-weight-bold">{{ __('dashboard.answer_en') }}</label>
                                <textarea class="form-control" name="answer[en]">
                        </textarea>
                            </div>
                        </div>


                    </div> <!-- row -->

                </form>
            </div>

            <!-- Footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    <i class="ft-x"></i> {{ __('dashboard.close') }}
                </button>

                <button type="submit" form="createfaq" class="btn btn-primary">
                    <i class="la la-check-square-o"></i> {{ __('dashboard.save') }}
                </button>
            </div>

        </div>
    </div>
</div>
