
<form id="formCompany">
    <div class="mb-3">
        <h5>Company Information</h5>
        <hr>
        <div class="row mb-2 align-items-center">
            <div class="col-md-4">
                <label for="company_select" class="form-label mb-0">Select Company</label>
            </div>
            <div class="col-md-8">
                <select id="company_select" class="form-control" name="company_id">
                    <option value="">-- Select Company --</option>
                    @foreach(get_companies() as $company)
                        <option 
                            value="{{ $company->id }}" 
                            data-email="{{ $company->email }}" 
                            data-website="{{ $company->website }}"
                            {{ isset($employee) && $employee->company_id == $company->id ? 'selected' : '' }}>
                            {{ $company->name }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="row mb-2 align-items-center">
            <div class="col-md-4">
                <label for="company_email" class="form-label mb-0">Email</label>
            </div>
            <div class="col-md-8">
                <input type="email" id="company_email" name="company_email" class="form-control" disabled>
            </div>
        </div>
        <div class="row mb-2 align-items-center">
            <div class="col-md-4">
                <label for="company_website" class="form-label mb-0">Website</label>
            </div>
            <div class="col-md-8">
                <input type="text" id="company_website" name="company_website" class="form-control" disabled>
            </div>
        </div>
    </div>
</form>


@push('scripts')
    <script>
        
        $(document).ready(function() {

            $('#company_select').select2({
                placeholder: "-- Select Company --",
                width: '100%'
            });

            $('#company_select').on('change', function() {
                const selectedOption = this.options[this.selectedIndex];
                const email = selectedOption.getAttribute('data-email') || '';
                const website = selectedOption.getAttribute('data-website') || '';

                $('#company_email').val(email);
                $('#company_website').val(website);
            });

            $('#company_select').trigger('change');

            $('#company_select').val('{{ $employee->company_id ?? '' }}').trigger('change');

        });
    </script>
@endpush
