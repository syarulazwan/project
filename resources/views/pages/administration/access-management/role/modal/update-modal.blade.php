<div class="modal fade" id="updateRoleModal" tabindex="-1" aria-labelledby="modalTitle3" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title" id="modalTitle3">Update Role</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <form id="updateRoleForm">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="role_update" class="form-label">Role Name</label>
                        <input type="text" class="form-control" id="role_update" name="role_update">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary"
                        data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
