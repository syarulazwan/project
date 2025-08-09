@push('styles')

<style>
    #tablerequest thead th {
        text-align: center !important;
        vertical-align: middle !important;
        text-transform: uppercase;
    }
    #customPermissionContainer {
        max-height: 300px;
        overflow-y: auto;
    }

    #permissionTable th:nth-child(9),
    #permissionTable td:nth-child(9) {
    display: none;
    }

</style>

   
@endpush

@extends('main')
@section('pages')

    <div class="container-fluid">
        <div class="d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
            <div class="">
                <nav>
                    <ol class="breadcrumb mb-0" style="--bs-breadcrumb-divider: '/'; color: rgb(0, 0, 0);">
                        <li class="breadcrumb-item d-flex align-items-center">
                            <a href="javascript:void(0);" class="mb-0 fw-semibold d-flex align-items-center">
                                <i class="bi bi-house-door-fill me-1"></i>
                            </a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="javascript:void(0);" class="mb-0 fw-semibold">Profile</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="javascript:void(0);" class="mb-0 fw-semibold">Request Access</a>
                        </li>
                        <li class="breadcrumb-item active mb-0 fw-semibold" aria-current="page">User</li>
                    </ol>
                </nav>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-12">
                <div class="card custom-card">
                    <div class="card-body">
                        <div class="text-end">
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                    data-bs-target="#addRequestAccessModal">
                                    Add
                            </button>
                        </div>
                        <br>
                        <div class="table-responsive">
                            <table id="tablerequest" class="table table-bordered text-nowrap w-100">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>User Name</th>
                                        <th>Request Type</th>
                                        <th>Request Role Name</th>
                                        <th>Status</th>
                                        <th>Approved By</th>
                                        <th>Approved Time</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    @include('pages.profile.request-access.modal-user.add-modal')

@endsection

@push('scripts')
    <script>
        const getUserRolesUrl = "{{ route('user-management.getUserRoles.ajax', ['userId' => '__id__']) }}";
        const deleteRequestAccessUrl = "{{ route('profile.delete-request-access.ajax', ['userId' => '__id__']) }}";
    </script>
    <script>

        $(document).ready(function () {


           $('#tablerequest').DataTable({

                paging: false,
                searching: true, 
                ordering: true, 
                ajax: '{{ route("profile.request-access-to-document.ajax") }}',
                columns: [
                    { data: 'no'},
                    { data: 'user_name'},
                    { data: 'request_type'},
                    { data: 'requested_role_name'},
                    { data: 'status'},
                    { data: 'approved_by'},
                    { data: 'approved_at'},
                    { data: 'action'},
                ],
                columnDefs: [
                    {
                        targets: 0,
                        className: 'text-center',
                        width: '5%' 
                    },
                     {
                        targets: 5,
                        className: 'text-center',
                    },
                    {
                        targets: 6,
                        className: 'text-center',
                    },
                    {
                        targets: 7,
                        className: 'text-center',
                        width: '20%' 
                    }
                ]
            });


        });


    $(document).ready(function () {
        let selectedRoles = [];
        let userRoles = [];
        let currentSelectedRoleId = null;
        let customRolePermissions = {}; 


        function updateRoleOptionsVisibility() {
            $('#role option').each(function () {
            let val = $(this).val();
            if (selectedRoles.some(r => r.roleId === val)) {
                $(this).hide();
            } else {
                $(this).show();
            }
            });
        }

        function resetPermissionTable() {
            $('#customRoleTitle').text('');
            $('#permissionTable tbody').empty();
            $('#customPermissionContainer').hide();
        }

        function loadPermissionTable(roleId) {
            if (!roleId) {
            resetPermissionTable();
            return;
            }
            $.ajax({
            url: '{{ route("access-management.permission-user.ajax") }}',
            method: 'GET',
            data: { role_id: roleId },
            success: function (res) {
                let tbody = $('#permissionTable tbody');
                tbody.empty();
                res.data.forEach(function (row) {
                tbody.append(`
                    <tr>
                    <td>${row.no}</td>
                    <td>${row.name_menu}</td>
                    <td>${row.is_menu}</td>
                    <td>${row.read_all}</td>
                    <td>${row.read_single}</td>
                    <td>${row.add}</td>
                    <td>${row.edit}</td>
                    <td>${row.delete}</td>
                    <td>${row.id_menu}</td>
                    </tr>
                `);
                });
                $('#customPermissionContainer').show();
            },
            error: function () {
                alert('Gagal ambil permission.');
                resetPermissionTable();
            }
            });
        }

        function loadCustomRolePermissions(roleId) {
            $.ajax({
            url: '{{ route("access-management.permission-user.ajax") }}', 
            method: 'GET',
            success: function (res) {
                let tbody = $('#permissionTable tbody');
                tbody.empty();

                res.data.forEach((row, i) => {

                let savedPerms = (customRolePermissions[roleId] && customRolePermissions[roleId][i]) || {};
                tbody.append(`
                    <tr>
                    <td>${row.no}</td>
                    <td>${row.name_menu}</td>
                    <td><input type="checkbox" class="perm-checkbox" data-perm="is_menu" data-row-id="${i}" ${savedPerms.is_menu ? 'checked' : ''} /></td>
                    <td><input type="checkbox" class="perm-checkbox" data-perm="read_all" data-row-id="${i}" ${savedPerms.read_all ? 'checked' : ''} /></td>
                    <td><input type="checkbox" class="perm-checkbox" data-perm="read_single" data-row-id="${i}" ${savedPerms.read_single ? 'checked' : ''} /></td>
                    <td><input type="checkbox" class="perm-checkbox" data-perm="add" data-row-id="${i}" ${savedPerms.add ? 'checked' : ''} /></td>
                    <td><input type="checkbox" class="perm-checkbox" data-perm="edit" data-row-id="${i}" ${savedPerms.edit ? 'checked' : ''} /></td>
                    <td><input type="checkbox" class="perm-checkbox" data-perm="delete" data-row-id="${i}" ${savedPerms.delete ? 'checked' : ''} /></td>
                    <td><input type="hidden" class="id_menu" value="${row.id_menu}" /></td>
                    </tr>
                `);
                });
                $('#customPermissionContainer').show();
            },
            error: function () {
                alert('Gagal ambil permission untuk custom role.');
                resetPermissionTable();
            }
            });
        }

        $(document).on('change', '.perm-checkbox', function () {
            let perm = $(this).data('perm');
            let rowId = $(this).data('row-id');
            let roleId = currentSelectedRoleId;

            if (!roleId || !roleId.toString().startsWith('custom-')) return;

            if (!customRolePermissions[roleId]) customRolePermissions[roleId] = {};
            if (!customRolePermissions[roleId][rowId]) customRolePermissions[roleId][rowId] = {};

            customRolePermissions[roleId][rowId][perm] = $(this).is(':checked');
        });

        $('#addRequestAccessModal').on('show.bs.modal', function () {
            let userId = {{ auth()->id() }};
            let url = getUserRolesUrl.replace('__id__', userId);

            $('#user_id').val(userId);
            selectedRoles = [];
            userRoles = [];
            currentSelectedRoleId = null;
            customRolePermissions = {};

            $('#roleTable tbody').html('');
            $('#role').html('<option value="">-- Select Role --</option>');
            resetPermissionTable();

            $('#requestType').val('');
            $('#existingRoleContainer').hide();
            $('#customRoleContainer').hide();
            $('#addRoleBtn').prop('disabled', true);

            $.ajax({
            url: url,
            method: 'GET',
            success: function (resUserRoles) {
                userRoles = resUserRoles;

                $.ajax({
                url: '{{ route("user-management.getRole.ajax") }}',
                method: 'GET',
                success: function (roles) {
                    roles.forEach(role => {
                    if (!userRoles.some(r => r.id === role.id)) {
                        $('#role').append(`<option value="${role.id}">${role.name}</option>`);
                    }
                    });
                    updateRoleOptionsVisibility();
                },
                error: function () {
                    alert('Gagal ambil senarai role.');
                }
                });
            },
            error: function () {
                alert('Gagal ambil role user.');
            }
            });
        });

        $('#requestType').on('change', function () {
            let val = $(this).val();
            if (val === 'existing') {
            $('#existingRoleContainer').show();
            $('#customRoleContainer').hide();
            $('#addRoleBtn').prop('disabled', false);
            resetPermissionTable();
            } else if (val === 'custom') {
            $('#existingRoleContainer').hide();
            $('#customRoleContainer').show();
            $('#addRoleBtn').prop('disabled', false);
            resetPermissionTable();
            } else {
            $('#existingRoleContainer').hide();
            $('#customRoleContainer').hide();
            $('#addRoleBtn').prop('disabled', true);
            resetPermissionTable();
            }
        });

        $('#addRoleBtn').on('click', function () {
            let requestType = $('#requestType').val();

            if (requestType === 'existing') {
            let selectedOption = $('#role option:selected');
            let roleId = selectedOption.val();
            let roleName = selectedOption.text();

            if (!roleId) {
                alert('Sila pilih role.');
                return;
            }

            if (selectedRoles.some(r => r.roleId === roleId)) {
                alert('Role telah ditambah.');
                return;
            }

            selectedRoles.push({ roleId: roleId, requestType: requestType, roleName: roleName });
            $('#roleTable tbody').append(`
                <tr data-role-id="${roleId}" data-request-type="${requestType}" data-role-name="${roleName}">
                <td>${roleName}</td>
                <td>Existing</td>
                <td><button type="button" class="btn btn-danger btn-sm remove-role">Delete</button></td>
                </tr>
            `);

            updateRoleOptionsVisibility();
            $('#role').val('');
            currentSelectedRoleId = roleId;
            loadPermissionTable(roleId);

            } else if (requestType === 'custom') {
            let customRoleName = $('#customRoleName').val().trim();
            if (!customRoleName) {
                alert('Sila isi nama role custom.');
                return;
            }

            if (selectedRoles.some(r => r.requestType === 'custom' && r.roleName.toLowerCase() === customRoleName.toLowerCase())) {
                alert('Role custom telah ditambah.');
                return;
            }

            let customRoleId = 'custom-' + Date.now();

            selectedRoles.push({ roleId: customRoleId, requestType: requestType, roleName: customRoleName });
            $('#roleTable tbody').append(`
                <tr data-role-id="${customRoleId}" data-request-type="${requestType}" data-role-name="${customRoleName}">
                <td>${customRoleName}</td>
                <td>Custom</td>
                <td><button type="button" class="btn btn-danger btn-sm remove-role">Delete</button></td>
                </tr>
            `);

            $('#customRoleName').val('NUMBER STAFF');
            currentSelectedRoleId = customRoleId;
            loadCustomRolePermissions(customRoleId);
            $('#customRoleTitle').text(customRoleName);

            } else {
            alert('Sila pilih Request Type terlebih dahulu.');
            return;
            }
        });

        $('#roleTable').on('click', 'tbody tr', function () {
            let roleId = $(this).data('role-id');
            let requestType = $(this).data('request-type');
            let roleName = $(this).data('role-name');

            if (requestType === 'existing') {
            currentSelectedRoleId = roleId;
            $('#customRoleTitle').text('');
            loadPermissionTable(roleId);
            } else if (requestType === 'custom') {
            currentSelectedRoleId = roleId;
            $('#customRoleTitle').text(roleName);
            loadCustomRolePermissions(roleId);
            }
        });

        $(document).on('click', '.remove-role', function (e) {
            e.stopPropagation();
            let row = $(this).closest('tr');
            let roleId = row.data('role-id').toString();

            selectedRoles = selectedRoles.filter(r => r.roleId !== roleId);
            if (roleId.startsWith('custom-')) {
            delete customRolePermissions[roleId];
            }
            updateRoleOptionsVisibility();
            row.remove();

            if (roleId === currentSelectedRoleId) {
            currentSelectedRoleId = null;
            resetPermissionTable();
            }
        });

        $('#saveBtn').on('click', function (e) {
            e.preventDefault();
            let userId = $('#user_id').val();

            // Kumpul permission untuk semua custom roles yg ada
            selectedRoles.forEach(role => {
                if (role.requestType === 'custom') {
                collectCustomPermissions(role.roleId);
                }
            });

            $.ajax({
                url: '{{ route("profile.request-access-to-document.request.store") }}',
                method: 'POST',
                data: {
                _token: '{{ csrf_token() }}',
                user_id: userId,
                roles: JSON.stringify(selectedRoles),
                custom_permissions: JSON.stringify(customRolePermissions)
                },
                success: function (response) {
                Swal.fire({
                    icon: 'success',
                    title: 'Berjaya!',
                    text: response.message,
                    confirmButtonText: 'OK'
                }).then(() => {
                    $('#addRequestAccessModal').modal('hide');
                    $('#tablerequest').DataTable().ajax.reload(null, false);
                });
                },
                error: function () {
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal!',
                    text: 'Gagal simpan roles.',
                    confirmButtonText: 'Cuba Lagi'
                });
                }
            });
        });


        function collectCustomPermissions(roleId) {
            let perms = [];

            $('#permissionTable tbody tr').each(function(index) {
                let $tr = $(this);

                let id_menu = $tr.find('input.id_menu').val(); // hidden input id_menu
                let is_menu = $tr.find('input.perm-checkbox[data-perm="is_menu"]').is(':checked') ? 1 : 0;
                let read_all = $tr.find('input.perm-checkbox[data-perm="read_all"]').is(':checked') ? 1 : 0;
                let read_single = $tr.find('input.perm-checkbox[data-perm="read_single"]').is(':checked') ? 1 : 0;
                let add = $tr.find('input.perm-checkbox[data-perm="add"]').is(':checked') ? 1 : 0;
                let edit = $tr.find('input.perm-checkbox[data-perm="edit"]').is(':checked') ? 1 : 0;
                let del = $tr.find('input.perm-checkbox[data-perm="delete"]').is(':checked') ? 1 : 0;

                perms.push({
                id_menu: id_menu,
                is_menu: is_menu,
                read_all: read_all,
                read_single: read_single,
                add: add,
                edit: edit,
                delete: del
                });
            });

            customRolePermissions[roleId] = perms;
        }


        $('#requestType, #role, #customRoleName').on('input change', function () {
            let requestType = $('#requestType').val();
            if (requestType === 'existing') {
            $('#addRoleBtn').prop('disabled', !$('#role').val());
            } else if (requestType === 'custom') {
            $('#addRoleBtn').prop('disabled', !$('#customRoleName').val().trim());
            } else {
            $('#addRoleBtn').prop('disabled', true);
            }
        });

    });

     $(document).ready(function () {

            $(document).on('click', '.btn-delete', function () {
                let userId = $(this).data('id');
                let url = deleteRequestAccessUrl.replace('__id__', userId); 

                Swal.fire({
                    title: 'Are you sure?',
                    text: 'This action will permanently delete the Request Access!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Yes, delete it!',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: url,
                            method: 'DELETE',
                            data: {
                                _token: '{{ csrf_token() }}'
                            },
                            success: function (response) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berjaya!',
                                    text: response.message,
                                    confirmButtonColor: '#3085d6',
                                    confirmButtonText: 'OK'
                                }).then(() => {
                                    $('#tablerequest').DataTable().ajax.reload(null, false);
                                });
                            },
                            error: function (xhr) {
                                let message = 'Something went wrong!';

                                if (xhr.responseJSON) {

                                    if (xhr.responseJSON.message) {
                                        message = xhr.responseJSON.message;
                                    }

                                    if (xhr.responseJSON.error) {
                                        message += `\n\nError: ${xhr.responseJSON.error}`;
                                    }
                                }

                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops!',
                                    text: message,
                                    confirmButtonColor: '#d33',
                                    confirmButtonText: 'Close'
                                });
                            }
                        });
                    }
                });
            });

        });







    </script>
    
@endpush