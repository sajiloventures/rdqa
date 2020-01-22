<div class="box-body">
    <div>
        <div>
            <div class="row">
                <div ui-tree id="tree1-root" dataValue="<%menuId%>">
                    <ol ui-tree-nodes="" ng-model="tree1" dataValue="<%menuId%>">
                        <li ng-repeat="node in tree1" dataValue="<%menuId%>" ui-tree-node
                            ng-include="'MenuTree'"></li>
                    </ol>
                </div>
            </div>

            <div class="container">
                <div class="col-sm-12">
                    <!-- Nested node template -->
                    <script type="text/ng-template" id="MenuTree">
                        <div ui-tree-handle class="tree-node tree-node-content">
                            <i class="fa fa-bars" style="padding: 6px 9px;"></i>
                                            <span ng-if="(node.page_title != null || node.page_title != '')">
                                                <%node.page_title%>
                                            </span>
                                            <span ng-if="node.page_title == null || node.page_title == ''">
                                                <%node.title%>
                                            </span>
                            {{--<%(node.page_title != null || node.page_title != "")?node.page_title:node.title%>--}}
                            <span ng-if="node.status==0" class="text-muted fa fa-chain-broken"></span>
                            <a href="#" class="btn btn-xs enableDisable pull-right" data-nodrag
                               ng-click="enableDisablePage(menuId, node.pivot_id, node.page_status)">
                                <span class="text-<%node.page_status==0?'danger':'success'%> fa fa-<%node.page_status==0?'ban':'check'%>"></span>
                            </a>
                            <a href="#" ng-click="updateModalFormDetail(node)"
                               class="btn btn-success btn-xs pull-right" data-nodrag>
                                <span class="fa fa-pencil-square-o"></span> Update Title
                            </a>
                        </div>
                        <ol ui-tree-nodes="" ng-model="node.nodes" dataValue="<%menuId%>">
                            <li ng-repeat="node in node.nodes" dataValue="<%menuId%>" ui-tree-node
                                ng-include="'MenuTree'">
                            </li>
                        </ol>
                    </script>
                </div>
            </div>
        </div>
    </div>
</div>