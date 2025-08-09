<form id="formStaff">
        <div class="mb-3">
            <h5>Personal Information</h5>
            <hr>
            <div class="row mb-2 align-items-center">
                <div class="col-md-4">
                    <label for="full_name" class="form-label mb-0">Full Name</label>
                </div>
                <div class="col-md-8">
                    <input type="text" id="full_name" name="full_name" class="form-control" value="{{ $profile->full_name ?? '' }}">
                </div>
            </div>
            <div class="row mb-2 align-items-center">
                <div class="col-md-4">
                    <label for="ic_number" class="form-label mb-0">IC Number</label>
                </div>
                <div class="col-md-8">
                    <input type="text" id="ic_number" name="ic_number" class="form-control" value="{{ $profile->ic_no ?? '' }}">
                </div>
            </div>
            <div class="row mb-2 align-items-center">
                <div class="col-md-4">
                    <label for="birthday" class="form-label mb-0">Birthday</label>
                </div>
                <div class="col-md-8">
                    <input type="date" id="birthday" name="birthday" class="form-control" value="{{ $profile->date_of_birth ?? '' }}">
                </div>
            </div>
            <div class="row mb-2 align-items-center">
                <div class="col-md-4">
                    <label for="gender" class="form-label mb-0">Gender</label>
                </div>
               <div class="col-md-8">
                    <select id="gender" name="gender" class="form-control">
                        <option value="">-- Select Gender --</option>
                        <option value="male" {{ ($profile->gender ?? '') == 'male' ? 'selected' : '' }}>Male</option>
                        <option value="female" {{ ($profile->gender ?? '') == 'female' ? 'selected' : '' }}>Female</option>
                    </select>
                </div>
            </div>
            <div class="row mb-2 align-items-center">
                <div class="col-md-4">
                    <label for="address" class="form-label mb-0">Address</label>
                </div>
                <div class="col-md-8">
                    <textarea id="address" name="address" class="form-control">{{ $profile->address ?? '' }}</textarea>
                </div>
            </div>
        </div>

        <br>

        <div class="mb-3">
            <h5>Contact Information</h5>
            <hr>
            <div class="row mb-2 align-items-center">
                <div class="col-md-4">
                    <label for="email" class="form-label mb-0">Email</label>
                </div>
                <div class="col-md-8">
                    <input type="email" id="email" name="email" class="form-control" value="{{ $profile->email ?? '' }}">
                </div>
            </div>
            <div class="row mb-2 align-items-center">
                <div class="col-md-4">
                    <label for="phone" class="form-label mb-0">Phone Number</label>
                </div>
                <div class="col-md-8">
                    <input type="tel" id="phone" name="phone" class="form-control" value="{{ $profile->phone_no ?? '' }}">
                </div>
            </div>
        </div>

        <br>

        <div class="mb-3">
            <h5>Employment Information</h5>
            <hr>
            <div class="row mb-2 align-items-center">
                <div class="col-md-4">
                    <label for="staff_no" class="form-label mb-0">Staff Number</label>
                </div>
                <div class="col-md-8">
                    <input type="text" id="staff_no" name="staff_no" class="form-control" value="{{ $employee->number_staf ?? '' }}" disabled>
                </div>
            </div>
            <div class="row mb-2 align-items-center">
                <div class="col-md-4">
                    <label for="staff_type" class="form-label mb-0">Staff Type</label>
                </div>
                <div class="col-md-8">
                    <input type="text" id="staff_type" name="staff_type" class="form-control" value="{{ $employee->employment_type ?? '' }}">
                </div>
            </div>
            <div class="row mb-2 align-items-center">
                <div class="col-md-4">
                    <label for="status" class="form-label mb-0">Status</label>
                </div>
                <div class="col-md-8">
                    <select id="status" name="status" class="form-control">
                        <option value="">-- Select Status --</option>
                        <option value="active" {{ ($employee->employment_status ?? '') == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ ($employee->employment_status ?? '') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                        <option value="on_leave" {{ ($employee->employment_status ?? '') == 'on_leave' ? 'selected' : '' }}>On Leave</option>
                        <option value="resigned" {{ ($employee->employment_status ?? '') == 'resigned' ? 'selected' : '' }}>Resigned</option>
                    </select>
                </div>
            </div>
            <div class="row mb-2 align-items-center">
                <div class="col-md-4">
                    <label for="join_date" class="form-label mb-0">Join Date</label>
                </div>
                <div class="col-md-8">
                    <input type="date" id="join_date" name="join_date" class="form-control" value="{{ $employee->joined_date ?? '' }}">
                </div>
            </div>
            <div class="row mb-2 align-items-center">
                <div class="col-md-4">
                    <label for="effective_date" class="form-label mb-0">Effective Date</label>
                </div>
                <div class="col-md-8">
                    <input type="date" id="effective_date" name="effective_date" class="form-control" value="{{ $employee->effective_date ?? '' }}">
                </div>
            </div>
            <div class="row mb-2 align-items-center">
                <div class="col-md-4">
                    <label for="resign_date" class="form-label mb-0">Resign Date</label>
                </div>
                <div class="col-md-8">
                    <input type="date" id="resign_date" name="resign_date" class="form-control" value="{{ $employee->resign_date ?? '' }}">
                </div>
            </div>
        </div>
</form>
