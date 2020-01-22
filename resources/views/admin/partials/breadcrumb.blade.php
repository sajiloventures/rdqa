
<div id="ribbon">

		<!-- breadcrumb -->
	{{ Breadcrumbs::render() }}
	<!-- end breadcrumb -->

	<!-- You can also add more buttons to the
    ribbon for further usability

    Example below:

    <span class="ribbon-button-alignment pull-right" style="margin-right:25px">
        <a href="#" id="search" class="btn btn-ribbon hidden-xs" data-title="search"><i class="fa fa-grid"></i> Change Grid</a>
        <span id="add" class="btn btn-ribbon hidden-xs" data-title="add"><i class="fa fa-plus"></i> Add</span>
        <button id="search" class="btn btn-ribbon" data-title="search"><i class="fa fa-search"></i> <span class="hidden-mobile">Search</span></button>
    </span> -->


	@if($impersonate)
		<span class="pull-right" style="margin-right:25px">
			<a href="{{ route('admin.users.stop') }}" class="btn btn-lg btn-header transparent "><i class="fa fa-sign-out fa-lg "></i> <strong><u>S</u>ignout</strong></a>(Impersonate)
		</span>
	@endif

</div>

