<div class="modal fade" id="updateMenuModal" tabindex="-1" aria-labelledby="modalTitle3" data-bs-keyboard="false">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title" id="modalTitle3">Update Menu</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="updateMenuForm">
                @csrf
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="name" class="form-label">Menu Name</label>
                            <input type="text" class="form-control" id="name_update" name="name_update">
                        </div>
                        <div class="col-md-6">
                            <label for="code_update" class="form-label">Code</label>
                            <input type="text" class="form-control" id="code_update" name="code_update">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="url_update" class="form-label">URL</label>
                            <input type="text" class="form-control" id="url_update" name="url_update">
                        </div>
                        <div class="col-md-6">
                            <label for="route" class="form-label">Route</label>
                            <input type="text" class="form-control" id="route_update" name="route_update">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="icon" class="form-label">Icon</label>
                            <input type="text" class="form-control" id="icon_update" name="icon_update">
                        </div>
                        <div class="col-md-6">
                            <label for="priority" class="form-label">Priority</label>
                            <input type="number" class="form-control" id="priority_update" name="priority_update" min="1">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
