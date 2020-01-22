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
                    <div class="col-sm-12 ">
                        <p><strong>Questions</strong></p>
                        <table class="table table-condensed table-striped">
                            <tbody class="questionContainer">
                                @php $count = 0; $lastQuestion = null; @endphp
                                @foreach($data['questionList'] as $queList)
                                    <tr>
                                        <td style="width: 10%;">{{ ++$count }}</td>
                                        <td>
                                            @php $lastQuestion = $queList; @endphp
                                            {{ $queList->question }}
                                            <div style="display: none;">
                                                <input class="data1" name="question[]" value="{{ $queList->question }}" type="hidden">
                                            </div>
                                        </td>
                                        <td class="text-right" style="width: 10%;">
                                            <input name="questionListId[]" value="{{ $queList->id }}" type="hidden">
                                            <a href="#" class="editQuestionOnly"><i class="fa fa-edit"></i></a>
                                            | <a href="#" class="removeQuestion text-danger"><i class="fa fa-remove"></i></a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div style="display: none;">
                    <input type="hidden" name="id" value="{{ $data['id'] }}" />
                    <input type="hidden" name="type" value="{{ $data['type'] }}" />
                    <input type="hidden" name="key" value="{{ $data['key'] }}" />
                    <input type="hidden" name="part" value="{{ $data['part'] }}" />
                </div>
                <hr />
                @if(isset($data['show_message']) && $data['show_message'])
                    <label class="control-label">Compare text</label>
                    <textarea name="question_note" class="form-control" placeholder="Text that shows after comparision of data">{!! $lastQuestion ? $lastQuestion->question_note : null !!}</textarea>
                    <div class="row alert alert-info" style="margin: 5px 0;"><i class="fa fa-fw fa-info-circle"></i> {!! $data['show_message'] !!}</div>
                @endif
                <div class="row bg-info add-question-form" style="padding: 10px;">
                    <p><strong>Question Add Form</strong></p>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Question</label>
                            <textarea class="form-control" name="questionData" placeholder="Question" rows="3"></textarea>
                            <span class="help-block text-danger" style="display: none;">This field is required</span>
                        </div>
                        <div class="form-group text-right">
                            <a href="#" class="btn btn-xs btn-primary addQuestionOnlyToList" style="margin-top: 10px;">
                                <i class="fa fa-plus"></i> Add
                            </a>
                            <div class="updateButtons"  style="display: none;">
                                <a href="#" class="btn btn-xs btn-danger cancelQuestionUpdate" style="margin-top: 10px;">
                                    <i class="fa fa-trash"></i> Cancel
                                </a>
                                <a href="#" class="btn btn-xs btn-primary updateQuestionOnlyToList" style="margin-top: 10px;">
                                    <i class="fa fa-upload"></i> Update
                                </a>
                            </div>
                        </div>
                    </div>
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