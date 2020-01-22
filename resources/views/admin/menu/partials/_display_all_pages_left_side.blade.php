<div class="box-body">
    <div>
        <div>
            <div class="row">
                <div ui-tree id="tree2-root" dataValue="0">
                    <ol ui-tree-nodes="" ng-model="tree2" dataValue="0">
                        <li ng-repeat="node in tree2" dataValue="0" ui-tree-node
                            ng-include="'MenuTree2'"></li>
                    </ol>
                </div>
            </div>

            <div class="container">
                <div class="col-sm-12">
                    <!-- Nested node template -->
                    <script type="text/ng-template" id="MenuTree2">
                        <div ui-tree-handle class="tree-node tree-node-content">
                            <i class="fa fa-bars" style="padding: 6px 9px;"></i>
                            <%node.title%>
                            <span ng-if="node.status==0" class="text-muted fa fa-chain-broken"></span>
                        </div>
                        <ol ui-tree-nodes="" ng-model="node.nodes" dataValue="0" data-nodrop-enabled>
                            <li ng-repeat="node in node.nodes" dataValue="0" ui-tree-node
                                ng-include="'MenuTree2'">
                            </li>
                        </ol>
                    </script>

                </div>

            </div>
        </div>
    </div>
</div>