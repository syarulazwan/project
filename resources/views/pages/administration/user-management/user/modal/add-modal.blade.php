<div class="modal fade" id="exampleModalScrollable3" tabindex="-1" aria-labelledby="modalTitle3" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title" id="modalTitle3">Add Role User</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <form id="addAccessRoleForm">
                @csrf
                <div class="modal-body">
                    <div class="card shadow-sm p-3">
                        <div class="row g-2 align-items-end">
                            <input type="hidden" id="user_id">
                            <input type="hidden" name="roles" id="selectedRoles">
                            <div class="col-md-8">
                                <label for="role" class="form-label">Select Role</label>
                                <select class="form-select" id="role">
                                    <option value="">-- Select Role --</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <button type="button" id="addRoleBtn" class="btn btn-success w-100">
                                    <i class="bi bi-plus-circle me-1"></i> Add Role
                                </button>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-sm table-bordered align-middle text-center" id="roleTable">
                                <thead class="table-light">
                                    <tr>
                                        <th style="width: 80%;">Role Name</th>
                                        <th style="width: 20%;">Action</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary"
                        data-bs-dismiss="modal">Close</button>
                    <input type="hidden" name="selected_roles[]" id="selectedRoles">
                    <button class="btn btn-primary" id="saveBtn">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
