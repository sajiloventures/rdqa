<div class="dd" id="nestable3">
    <ol class="dd-list">
        @foreach($data['question'] as $question)
            <li class="dd-item dd3-item" data-id="{{ $question['id'] }}">
                <div class="dd-handle dd3-handle">&nbsp;</div>
                <div class="dd3-content">
                    {{ strtoupper($question['key']) . ' : '}} <span class="txtTitle">{{ $question['name'] }}</span>
                    <div class="btn-group pull-right">
                        @if (AclHelper::isRouteAccessable($base_route . '.getEditModal:POST'))

                        <a href="#" class="btn btn-xs editTitle" data-type="part" data-part="{{ $question['key'] }}" data-key="{{ $question['key'] }}"  rel="tooltip" data-placement="right" data-original-title="Edit title" data-html="true"><i class="fa fa-edit"></i></a>
                        @endif
                    </div>
                </div>
                <ol class="dd-list">
                    @foreach($question['type'] as $type)
                        <li class="dd-item dd3-item" data-id="{{ count($type['type']) < 1 ? $type['id'] : null }}">
                            <div class="dd-handle dd3-handle">&nbsp;</div>
                            <div class="dd3-content">
                                {{ strtoupper($type['key']) . ' : ' }}<span class="txtTitle">{{ $type['name'] }}</span>
                                <div class="btn-group pull-right">
                                    @if(count($type['type']) < 1 && $question['key'] != 'part-3')
                                        @if (AclHelper::isRouteAccessable($base_route . '.getAddQuestionModal:POST'))
                                            <a href="javascript:void(0);" class="btn btn-xs addQuestions" data-id="{{ $type['id'] }}" rel="tooltip" data-placement="right" data-original-title="Add Questions" data-html="true">
                                                <i class="fa fa-plus-square"></i>
                                            </a>
                                        @endif
                                    @endif
                                        @if (AclHelper::isRouteAccessable($base_route . '.getEditModal:POST'))

                                        &nbsp; <a href="#" class="btn btn-xs editTitle" data-type="type" data-part="{{ $question['key'] }}" data-key="{{ $type['key'] }}" rel="tooltip" data-placement="right" data-original-title="Edit title" data-html="true"><i class="fa fa-edit"></i></a>
                                        @endif
                                </div>
                            </div>
                            @if(count($type['type']) > 0)
                                <ol class="dd-list">
                                    @foreach($type['type'] as $subType)
                                        <li class="dd-item dd3-item" data-id="{{ $subType['id'] }}">
                                            <div class="dd-handle dd3-handle">&nbsp;</div>
                                            <div class="dd3-content">
                                                <span class="txtTitle">{{ $subType['name'] }}</span>
                                                <small class="text-muted">{{ $subType['description'] }}</small>
                                                <div class="btn-group pull-right">
                                                    @if (AclHelper::isRouteAccessable($base_route . '.getAddQuestionModal:POST'))

                                                        <a href="javascript:void(0);" class="btn btn-xs addQuestions" data-id="{{ $subType['id'] }}" rel="tooltip" data-placement="right" data-original-title="Add Questions" data-html="true">
                                                            <i class="fa fa-plus-square"></i>
                                                        </a>
                                                    @endif
                                                    @if (AclHelper::isRouteAccessable($base_route . '.getEditModal:POST'))
                                                    &nbsp; <a href="#" class="btn btn-xs editTitle" data-type="sub_type" data-part="{{ $question['key'] }}" data-key="{{ $subType['key'] }}" rel="tooltip" data-placement="right" data-original-title="Edit title" data-html="true"><i class="fa fa-edit"></i></a>
                                                    @endif
                                                </div>
                                            </div>
                                        </li>
                                    @endforeach
                                </ol>
                            @endif
                        </li>
                    @endforeach
                </ol>
            </li>
        @endforeach
    </ol>
</div>