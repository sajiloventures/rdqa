<aside id="left-panel">
	<!-- User info -->
	<div class="login-info">
				<span> <!-- User image size is adjusted inside CSS, it should stay as is -->
					<a href="javascript:void(0);" id="show-shortcut" data-action="toggleShortcut">

						<span>
							{{ Auth::user()->fullName}}
						</span>
						<i class="fa fa-angle-down"></i>
					</a>

				</span>
	</div>
	<!-- end user info -->

	<!-- NAVIGATION : This navigation is also responsive

    To make this navigation dynamic please make sure to link the node
    (the reference to the nav > ul) after page load. Or the navigation
    will not initialize.
    -->

	<nav>
		{!! AdminMenuHelper::getMenu() !!}
	</nav>
	<span class="minifyme" data-action="minifyMenu"> <i class="fa fa-arrow-circle-left hit"></i> </span>

</aside>
