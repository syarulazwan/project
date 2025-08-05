<div class="modal fade" id="updateJobGradeModal" tabindex="-1" aria-labelledby="modalTitle3" data-bs-keyboard="false">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title" id="modalTitle3">Add Job Grade</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="updateJobGradeForm">
                @csrf
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="name_update" class="form-label">Name Job Grade</label>
                            <input type="text" class="form-control" id="name_update" name="name_update">
                        </div>
                        <div class="col-md-6">
                            <label for="code_update" class="form-label">Code</label>
                            <input type="text" class="form-control" id="code_update" name="code_update">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="level_update" class="form-label">Level</label>
                            <input type="text" class="form-control" id="level_update" name="level_update">
                        </div>
                        <div class="col-md-6">
                            <label for="seniority_update" class="form-label">Seniority</label>
                            <input type="text" class="form-control" id="seniority_update" name="seniority_update">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Add</button>
                </div>
            </form>
        </div>
    </div>
</div>
