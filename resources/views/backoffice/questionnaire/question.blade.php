<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <a href="{{ route('backoffice.questionnaire.index') }}" class="btn btn-primary">
                <i class="fa fa-arrow-left"></i> Back
            </a>
        </div>

        <form id="form_question" name="form_question" autocomplete="off">
            <div id="question_container">
            </div>
        </form>
        <div class="d-flex justify-content-end mb-3">
            <button type="button" onclick="onAddQuestion()" class="btn btn-primary">
                <i data-feather="plus"></i> Tambah Pertanyaan
            </button>
        </div>

    </div>
</div>
@include('backoffice.questionnaire.javascriptQuestion')
