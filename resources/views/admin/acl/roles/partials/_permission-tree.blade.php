<div class="tree smart-form">
    <ul role="tree">

        @if (count($permission_groups) > 0)
            <li role="treeitem" class="parent_li">
            <span title="Collapse this branch">
                <i class="fa fa-lg fa-minus-circle"></i>
            </span>
                <label class="checkbox inline-block">
                    {!! Form::checkbox('parent_checkbox', '', false, ['class' => 'checkbox-inline parent_checkbox'] ) !!}
                    <i></i> Full Permissions</label>
                <ul role="group">

                    @foreach($permission_groups as $route_section_key => $group_section_config)

                        <li role="treeitem" class="parent_li">
                            <span title="Collapse this branch">
                                <i class="fa fa-lg fa-minus-circle"></i>
                            </span>
                            <label class="checkbox inline-block">
                                {!! Form::checkbox('parent_checkbox', '', false, ['class' => 'checkbox-inline parent_checkbox'] ) !!}
                                <i></i> {{ $group_section_config['section']['name'] }}</label>

                            <ul role="group">

                                @foreach($group_section_config['groups'] as $route_group_key => $route_group_config)

                                    <li role="treeitem" class="parent_li">
                                    <span title="Collapse this branch">
                                        <i class="fa fa-lg fa-minus-circle"></i>
                                    </span>
                                        <label class="checkbox inline-block">
                                            {!! Form::checkbox('parent_checkbox', '', false, ['class' => 'checkbox-inline parent_checkbox'] ) !!}
                                            <i></i>{{ $route_group_config['section']['name'] }}
                                        </label>

                                        <ul role="group">

                                            @foreach($route_group_config['section']['routes'] as $manager_section_key => $manager_section)

                                                <li>
                                                <span>
                                                    <?php
                                                    $permission_identifier = $route_section_key . '.' . $route_group_key . '.' . $manager_section_key;
                                                    ?>
                                                    <label class="checkbox inline-block">
                                                        {!! Form::checkbox('perms[]', $permission_identifier, AclHelper::hasPermission($permission_identifier, $role), ['class' => 'checkbox-inline'] ) !!}
                                                        <i></i>{{ $manager_section }}
                                                    </label>
                                                </span>
                                                </li>

                                            @endforeach
                                        </ul>


                                    </li>

                                @endforeach
                            </ul>
                        </li>

                    @endforeach

                </ul>
            </li>
        @endif
    </ul>
</div>