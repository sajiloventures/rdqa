<div class="dd" id="faqNestable">
    <ol class="dd-list">
        @foreach($data['faq'] as $faq)
            <li class="dd-item dd3-item" data-id="{{ $faq->id }}">
                <div class="dd-handle dd3-handle">&nbsp;</div>
                <div class="dd3-content">
                    <div class="row">
                        <div class="col-xs-10">
                            {{ $faq->question }}
                        </div>
                        <div class="col-xs-2">
                            <div class="btn-group text-right">
                                @if (AclHelper::isRouteAccessable($base_route . '.edit:GET'))
                                    <a href="{{ route($base_route . '.edit', $faq->id) }}" class="btn btn-xs editFaq"  rel="tooltip" data-placement="right" data-original-title="Edit FAQ" data-html="true"><i class="fa fa-edit"></i></a>
                                @endif
                                @if (AclHelper::isRouteAccessable($base_route . '.enable:GET') &&
                                    AclHelper::isRouteAccessable($base_route . '.disable:GET'))
                                    <a href="{{ route($base_route . '.' . ($faq->status == 1?'disable':'enable'), $faq->id) }}" class="btn btn-xs enableFaq"  rel="tooltip" data-placement="right" data-original-title="{{ ($faq->status == 1?'Disable':'Enable') }} FAQ" data-html="true"><i class="fa fa-{{ ($faq->status == 1 ? 'check-circle-o text-success': 'ban text-warning') }}"></i></a>
                                @endif

                                @if (AclHelper::isRouteAccessable($base_route . '.delete:GET'))
                                    <a href="#" class="btn btn-xs deleteFaq text-danger"  rel="tooltip" data-placement="right" data-original-title="Delete FAQ" data-html="true" data-delete-url="{{ route($base_route . '.delete', $faq->id) }}" data-name="{{ $faq->question }}"><i class="fa fa-remove"></i></a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </li>
        @endforeach
    </ol>
</div>