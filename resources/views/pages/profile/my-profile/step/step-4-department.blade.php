<form id="formDepartment">
    <div class="mb-3">
        <h5>Department</h5>
        <hr>
        <div class="row mb-2 align-items-center">
            <div class="col-md-4">
            <label for="company_select" class="form-label mb-0">Select Department</label>
            </div>
            <div class="col-md-8">
                <select id="department_select" class="form-control" name="department_id">
                    <option value="">-- Select --</option>
                    @foreach(get_department() as $department)
                        <option 
                            value="{{ $department->id }}"
                            {{ isset($employee) && $employee->department_id == $department->id ? 'selected' : '' }}>
                            {{ $department->name }}
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

            $('#department_select').select2({
                placeholder: "-- Select --",
                width: '100%'
            }).trigger('change');
        });
        
    </script>
@endpush

