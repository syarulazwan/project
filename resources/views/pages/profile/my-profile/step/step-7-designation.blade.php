<form id="formDesignation">
    <div class="mb-3">
        <h5>Designation</h5>
        <hr>
        <div class="row mb-2 align-items-center">
            <div class="col-md-4">
            <label for="designation_select" class="form-label mb-0">Select Designation</label>
            </div>
            <div class="col-md-8">
                <select id="designation_select" class="form-control" name="designation_id">
                    <option value="">-- Select --</option>
                    @foreach(get_designation() as $designation)
                        <option 
                             value="{{ $designation->id }}"
                            {{ isset($employee) && $employee->designation_id == $designation->id ? 'selected' : '' }}>
                            {{ $designation->name }}
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

            $('#designation_select').select2({
                placeholder: "-- Select --",
                width: '100%'
            }).trigger('change');
        });
        
    </script>
@endpush

