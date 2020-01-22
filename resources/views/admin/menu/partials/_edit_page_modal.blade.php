<div class="modal fade modal_page" tabindex="-1" role="dialog" data-backdrop="false">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Edit <%pages.title%></h4>
            </div>
            <div class="modal-body">
                <input type="text" ng-model="pages.page_title" class="form-control" placeholder="Enter New Page Title"/>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary"
                        ng-click="updatePageDetails(menuId, pages.pivot_id, pages.page_title)" data-dismiss="modal">
                    Save changes
                </button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->