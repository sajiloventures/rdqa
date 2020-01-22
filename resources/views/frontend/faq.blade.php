@extends('layouts.frontend')

@section('page_specific_styles')
    <style>
        .faq-section img {
            max-width: 100%;
            height: auto;
        }
    </style>
@endsection

@section('content')

    <div class="container" lang="ne">
        <h1> RDQA FAQ</h1>
        <div class="row">
            <div class="col-md-8 faq-section">
                <div class="panel-group smart-accordion-default" id="faqContainer">
                    @php $count = 0; @endphp
                    @if(isset($data['faq']))
                        @foreach($data['faq'] as $faq)
                            <div class="panel panel-info">
                                <div class="panel-heading">
                                    <h4 class="panel-title">
                                        <a data-toggle="collapse" data-parent="#faqContainer" href="#faq-{{ $faq->id }}" class="{{ ++$count == 1 ? null : 'collapsed'}}">
                                            <i class="fa fa-lg fa-angle-down pull-right"></i> <i class="fa fa-lg fa-angle-up pull-right"></i>
                                            {{ $faq->question }}
                                        </a>
                                    </h4>
                                </div>
                                <div id="faq-{{ $faq->id }}" class="panel-collapse collapse {{ $count == 1 ? 'in' : null}}">
                                    <div class="panel-body">
                                        {!! $faq->answer !!}
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
