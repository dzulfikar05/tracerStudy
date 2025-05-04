<div class="row">
    <div class="col-12">
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
