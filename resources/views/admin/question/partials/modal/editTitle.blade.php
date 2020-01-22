<!-- Modal dialog-->
<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                &times;
            </button>
            <h4 class="modal-title">Edit: {{ $question['name'] }}</h4>
        </div>
        {!! Form::open( ['route' => [$base_route . '.updateTitle'], 'method' => 'POST', 'id' => 'form_edit_question_title'] ) !!}
            <div class="modal-body">

                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Title</label>
                            <input type="text" name="name" class="form-control" placeholder="Title" value="{{ $question['name'] }}" required />
                        </div>
                        <div class="form-group">
                            <label>Description</label>
                            <textarea class="form-control" name="description" placeholder="Description" rows="5">{{ $question['description'] }}</textarea>
                        </div>
                    </div>
                    <div style="display: none;">
                        <input type="hidden" name="type" value="{{ $question['type'] }}" />
                        <input type="hidden" name="key" value="{{ $question['key'] }}" />
                        <input type="hidden" name="part" value="{{ $question['part'] }}" />
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