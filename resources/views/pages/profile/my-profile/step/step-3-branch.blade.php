
<form id="formBranch">
    <div class="mb-3">
        <h5>Branch</h5>
        <hr>
        <div class="row mb-2 align-items-center">
            <div class="col-md-4">
            <label for="company_select" class="form-label mb-0">Select Branch</label>
            </div>
            <div class="col-md-8">
                <select id="branch_select" class="form-control" name="branch_id">
                    <option value="">-- Select Branch --</option>
                    @foreach(get_branch() as $branch)
                        <option 
                            value="{{ $branch->id }}"
                            {{ isset($employee) && $employee->branch_id == $branch->id ? 'selected' : '' }}>
                            {{ $branch->name }}
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
            $('#branch_select').select2({
                placeholder: "-- Select --",
                width: '100%'
            }).trigger('change');
        });

        
    </script>
@endpush

