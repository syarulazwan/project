<!-- Modal -->
<div class="modal fade" id="addRequestAccessModal" tabindex="-1" aria-labelledby="modalTitle3" data-bs-keyboard="false">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title" id="modalTitle3">Add Request Access</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <form id="addRequestAccessForm">
                @csrf
                <div class="modal-body">
                    <div class="card shadow-sm p-3">
                        <div class="row g-2 align-items-end">
                            <input type="hidden" id="user_id" name="user_id">

                            <div class="col-md-3">
                                <label for="requestType" class="form-label">Request Type</label>
                                <select class="form-select" id="requestType">
                                    <option value="">-- Select Request Type --</option>
                                    <option value="existing">Existing</option>
                                    <option value="custom">Custom</option>
                                </select>
                            </div>

                            <div class="col-md-5" id="existingRoleContainer" style="display:none;">
                                <label for="role" class="form-label">Select Role</label>
                                <select class="form-select" id="role">
                                    <option value="">-- Select Role --</option>
                                </select>
                            </div>

                            <div class="col-md-5" id="customRoleContainer" style="display:none;">
                                <label for="customRoleName" class="form-label">Custom Role Name</label>
                                <input type="text" class="form-control" id="customRoleName" value="NUMBER STAFF" />
                            </div>

                            <div class="col-md-2">
                                <button type="button" id="addRoleBtn" class="btn btn-success w-100" disabled>
                                    <i class="bi bi-plus-circle me-1"></i> Add Role
                                </button>
                            </div>
                        </div>

                        <div class="table-responsive mt-3">
                            <table class="table table-sm table-bordered align-middle text-center" id="roleTable">
                                <thead class="table-light">
                                    <tr>
                                        <th style="width: 50%;">Role Name</th>
                                        <th style="width: 30%;">Request Type</th>
                                        <th style="width: 20%;">Action</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card shadow-sm p-3">
                        <div id="customPermissionContainer" style="margin-top: 1rem;">
                            <h6>Assign Permission for Custom Role: <span id="customRoleTitle"></span></h6>
                            <table class="table table-bordered" id="permissionTable">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Menu</th>
                                        <th>Is Menu</th>
                                        <th>Read All</th>
                                        <th>Read Single</th>
                                        <th>Add</th>
                                        <th>Edit</th>
                                        <th>Delete</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- AJAX render permission rows -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary"
                        data-bs-dismiss="modal">Close</button>
                    <button class="btn btn-primary" id="saveBtn">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
