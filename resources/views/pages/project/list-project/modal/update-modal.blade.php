<div class="modal fade" id="updateProjectModal" tabindex="-1" aria-labelledby="modalTitle3" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title" id="modalTitle3">Update Project</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="updateProjectForm">
                @csrf
                <div class="modal-body">
                    <!-- Menu Info -->
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="name_update" class="form-label">Name Project</label>
                            <input type="text" class="form-control" id="name_update" name="name_update">
                        </div>
                        <div class="col-md-6">
                            <label for="code_update" class="form-label">Code</label>
                            <input type="text" class="form-control" id="code_update" name="code_update">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="status_update" class="form-label">Status</label>
                            <select class="form-control" id="status_update" name="status_update">
                                <option value="active">Active</option>
                                <option value="completed">Completed</option>
                                <option value="on_hold">On Hold</option>
                            </select>
                        </div>
                    </div>
                     <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="start_date_update" class="form-label">Start Date</label>
                            <input type="text" class="form-control" id="start_date_update" name="start_date_update">
                        </div>
                        <div class="col-md-6">
                            <label for="end_date" class="form-label">End Date</label>
                            <input type="text" class="form-control" id="end_date_update" name="end_date_update">
                        </div>
                    </div>
                </div>

                <!-- Footer Buttons -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
