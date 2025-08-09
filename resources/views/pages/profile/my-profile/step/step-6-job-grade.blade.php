<form id="formJobGrade">
    <div class="mb-3">
        <h5>Job Grade</h5>
        <hr>
        <div class="row mb-2 align-items-center">
            <div class="col-md-4">
            <label for="company_select" class="form-label mb-0">Select Job Grade</label>
            </div>
            <div class="col-md-8">
                <select id="job_grade_select" class="form-control" name="job_grade_id">
                    <option value="">-- Select --</option>
                    @foreach(get_job_grade() as $jobGrade)
                        <option 
                            value="{{ $jobGrade->id }}"
                            {{ isset($employee) && $employee->job_grade_id == $jobGrade->id ? 'selected' : '' }}>
                            {{ $jobGrade->name }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
</form>

@push('scripts')
    <script>

        $(document).ready(function() {

            $('#job_grade_select').select2({
                placeholder: "-- Select --",
                width: '100%'
            }).trigger('change');
        });
        
    </script>
@endpush

