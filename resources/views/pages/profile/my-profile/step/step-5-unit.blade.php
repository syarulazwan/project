
<form id="formUnit">
    <div class="mb-3">
        <h5>Unit</h5>
        <hr>
        <div class="row mb-2 align-items-center">
            <div class="col-md-4">
            <label for="company_select" class="form-label mb-0">Select Unit</label>
            </div>
            <div class="col-md-8">
                <select id="unit_select" class="form-control" name="unit_id">
                    <option value="">-- Select --</option>
                    @foreach(get_unit() as $unit)
                        <option 
                            value="{{ $unit->id }}"
                            {{ isset($employee) && $employee->unit_id == $unit->id ? 'selected' : '' }}>
                            {{ $unit->name }}
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

            $('#unit_select').select2({
                placeholder: "-- Select --",
                width: '100%'
            }).trigger('change');
        });
        
    </script>
@endpush

