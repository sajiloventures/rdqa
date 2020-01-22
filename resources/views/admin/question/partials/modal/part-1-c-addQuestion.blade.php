<!-- Modal dialog-->
<div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                &times;
            </button>
            <h4 class="modal-title">Add questions: {{ $data['name'] }}</h4>
        </div>
        {!! Form::open(['route' => [$base_route . '.addUpdateQuestions'], 'method' => 'POST', 'id' => 'form_add_question'] ) !!}
        <div class="modal-body">
            <div class="row">
                <div class="col-sm-12">
                    <div class="form-group">
                        <label>Question [A]</label>
                        <input class="form-control" name="question_a" value="{{ count($data['questionList']) > 0 ? $data['questionList'][0]->question : null }}" placeholder="Question [A]" />
                    </div>
                    <div class="form-group">
                        <label>Question [B]</label>
                        <input class="form-control" name="question_b" value="{{ count($data['questionList']) > 0 ? $data['questionList'][0]->question_note : null }}" placeholder="Question [B]" />
                    </div>
                    <div class="form-group">
                        <label>Ratio Text A/B</label>
                        <input class="form-control" name="compare" value="{{ count($data['questionList']) > 0 ? $data['questionList'][0]->if_not_question : null }}" placeholder="Ratio Text A/B" />
                    </div>
                </div>
            </div>
            <div style="display: none;">
                <input type="hidden" name="id" value="{{ $data['id'] }}" />
                <input type="hidden" name="questionListId" value="{{ count($data['questionList']) > 0 ? $data['questionList'][0]->id : 0 }}" />
                <input type="hidden" name="type" value="{{ $data['type'] }}" />
                <input type="hidden" name="key" value="{{ $data['key'] }}" />
                <input type="hidden" name="part" value="{{ $data['part'] }}" />
            </div>

        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">
                Cancel
            </button>
            <button class="btn btn-primary" type="submit">
                Update
            </button>
        </div>
        {!! Form::close(); !!}
    </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->