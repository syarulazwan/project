<form id="formInformation">
    <div class="mb-3">
        <h5>Project Information</h5>
        <hr>
        <div class="row mb-2 align-items-center">
            <div class="col-md-4">
                <label for="project_name" class="form-label mb-0">Project Name</label>
            </div>
            <div class="col-md-8">
                <input type="text" id="project_name" name="project_name" class="form-control" value="">
            </div>
        </div>
        
        <div class="row mb-2 align-items-center">
            <div class="col-md-4">
                <label for="project_code" class="form-label mb-0">Project Code</label>
            </div>
            <div class="col-md-8">
                <input type="text" id="project_code" name="project_code" class="form-control" value="">
            </div>
        </div>
        
        <div class="row mb-2 align-items-center">
            <div class="col-md-4">
                <label for="start_date" class="form-label mb-0">Project Start Date</label>
            </div>
            <div class="col-md-8">
                <input type="date" id="start_date" name="start_date" class="form-control" value="">
            </div>
        </div>
        
        <div class="row mb-2 align-items-center">
            <div class="col-md-4">
                <label for="end_date" class="form-label mb-0">Project End Date</label>
            </div>
            <div class="col-md-8">
                <input type="date" id="end_date" name="end_date" class="form-control" value="">
            </div>
        </div>
        
        <div class="row mb-2 align-items-center">
            <div class="col-md-4">
                <label for="project_description" class="form-label mb-0">Project Description</label>
            </div>
            <div class="col-md-8">
                <textarea id="project_description" name="project_description" class="form-control" rows="3"></textarea>
            </div>
        </div>
        
        <div class="row mb-2 align-items-center">
            <div class="col-md-4">
                <label for="project_objective" class="form-label mb-0">Project Objective</label>
            </div>
            <div class="col-md-8">
                <textarea id="project_objective" name="project_objective" class="form-control" rows="3"></textarea>
            </div>
        </div>
        
        <div class="row mb-2 align-items-center">
            <div class="col-md-4">
                <label for="project_budget" class="form-label mb-0">Project Budget</label>
            </div>
            <div class="col-md-8">
                <input type="number" id="project_budget" name="project_budget" class="form-control" value="" step="0.01" min="0">
            </div>
        </div>
        
        <div class="row mb-2 align-items-center">
            <div class="col-md-4">
                <label for="project_stakeholder" class="form-label mb-0">Project Stakeholder</label>
            </div>
            <div class="col-md-8">
                <input type="text" id="project_stakeholder" name="project_stakeholder" class="form-control" value="">
            </div>
        </div>
    </div>
</form>
