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
                                @php $count = 0 @endphp
                                @foreach($data['questionList'] as $queList)
                                    <tr>
                                        <td style="width: 10%;">{{ ++$count }}</td>
                                        <td>
                                            @if($queList->question_note)
                                            (<small class="text-muted">{{ $queList->question_note }}</small>)<br />
                                            @endif
                                            {{ $queList->question }}
                                            <p style="border-top: 1px solid;">{{ $queList->if_not_question }}</p>
                                            <div style="display: none;">
                                                <input class="data1" name="question_note[]" value="{{ $queList->question_note }}" type="hidden">
                                                <input class="data2" name="question[]" value="{{ $queList->question }}" type="hidden">
                                                <input class="data3" name="if_not_question[]" value="{{ $queList->if_not_question }}" type="hidden">
                                            </div>
                                        </td>
                                        <td class="text-right" style="width: 10%;">
                                            <input name="questionListId[]" value="{{ $queList->id }}" type="hidden">
                                            <a href="#" class="editQuestion"><i class="fa fa-edit"></i></a>
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
                <div class="row bg-info add-question-form" style="padding: 10px;">
                    <p><strong>Question Add Form</strong></p>
                    <div class="col-sm-12">
                        <div class="form-group">
                            <div class="col-sm-2">
                                <label>Title note</label>
                            </div>
                            <div class="col-sm-10">
                                <input class="form-control" name="noteData" id="noteData" placeholder="Note" />
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-2">
                                <label>Title</label>
                            </div>
                            <div class="col-sm-10">
                                <input class="form-control" name="questionData" id="questionData" placeholder="Question" />
                                <span class="help-block text-danger" style="display: none;">This field is required</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-2">
                                <label>If not question</label>
                            </div>
                            <div class="col-sm-10">
                                <input class="form-control" name="if_not_questionData" id="if_not_questionData" placeholder="Remarks Question" />
                            </div>
                        </div>
                        <div class="form-group text-right">
                            <a href="#" class="btn btn-xs btn-primary addQuestionToList" style="margin-top: 10px;">
                                <i class="fa fa-plus"></i> Add
                            </a>
                            <div class="updateButtons"  style="display: none;">
                                <a href="#" class="btn btn-xs btn-danger cancelQuestionUpdate" style="margin-top: 10px;">
                                    <i class="fa fa-trash"></i> Cancel
                                </a>
                                <a href="#" class="btn btn-xs btn-primary updateQuestionToList" style="margin-top: 10px;">
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