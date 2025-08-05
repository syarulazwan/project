<div class="modal fade" id="updateCompanyModal" tabindex="-1" aria-labelledby="modalTitle3" data-bs-keyboard="false">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title" id="modalTitle3">Update Company</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="updateCompanyForm">
                @csrf
                <div class="modal-body">
                    <!-- Menu Info -->
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="name_update" class="form-label">Name Company</label>
                            <input type="text" class="form-control" id="name_update" name="name_update">
                        </div>
                        <div class="col-md-6">
                            <label for="email_update" class="form-label">Email</label>
                            <input type="text" class="form-control" id="email_update" name="email_update">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="website_update" class="form-label">Website</label>
                            <input type="text" class="form-control" id="website_update" name="website_update">
                        </div>
                    </div>
                </div>

                <!-- Footer Buttons -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Add</button>
                </div>
            </form>
        </div>
    </div>
</div>
