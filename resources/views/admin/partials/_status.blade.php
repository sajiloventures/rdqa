@include('flash::message')
@if (count($errors) > 0)
    <div class="alert alert-block alert-danger">
        <a class="close" data-dismiss="alert" href="#">
            ×
        </a>
        <h4 class="alert-heading">
            <i class="fa fa-check-square-o">
            </i>
            Errors
        </h4>
        <p>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
            </p>
    </div>

@endif

@if (isset($status))

    <div class="alert alert-block alert-success">
        <a class="close" data-dismiss="alert" href="#">
            ×
        </a>
        <h4 class="alert-heading">
            <i class="fa fa-check-square-o">
            </i>
            Info
        </h4>
        <li>{{ $status }}</li>
    </div>
@endif
