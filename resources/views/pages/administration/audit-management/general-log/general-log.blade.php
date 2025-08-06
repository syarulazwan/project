@push('styles')

<link rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/styles/github-dark.min.css">

<style>
    #tablegeneral thead th {
    text-align: center !important;
    vertical-align: middle !important;
    text-transform: uppercase;
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
                            <a href="javascript:void(0);" class="mb-0 fw-semibold">Administration</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="javascript:void(0);" class="mb-0 fw-semibold">Audit Management</a>
                        </li>
                        <li class="breadcrumb-item active mb-0 fw-semibold" aria-current="page">General Log</li>
                    </ol>
                </nav>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-12">
                <div class="card custom-card">
                    {{-- <div class="card-header">
                        <div class="card-title">
                            Filter Datatable
                        </div>
                    </div> --}}
                    <div class="card-body">
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-12">
                <div class="card custom-card">
                    {{-- <div class="card-header">
                        <div class="card-title">
                            Basic Datatable
                        </div>
                    </div> --}}
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="tablegeneral" class="table table-bordered text-nowrap w-100">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Log Type</th>
                                        <th>Table</th>
                                        <th>After</th>
                                        <th>User</th>
                                        <th>IP Address</th>
                                        <th>User Agent</th>
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

    

    <div class="modal fade" id="logAfterModal" tabindex="-1" aria-labelledby="modalTitle3" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title" id="modalTitle3">Sql Detail</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
                <div class="modal-body">
                   <div class="modal-body">
                     <div id="afterContentHeader"></div>
                    <div id="afterContentBindings" class="mt-3"></div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Add</button>
                </div>
        </div>
    </div>
</div>




@endsection

<script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/highlight.min.js"></script>
<script>hljs.highlightAll();</script>

@push('scripts')
    <script>

        $(document).ready(function () {

           $('#tablegeneral').DataTable({
                // responsive: true,
                lengthMenu: [
                                [10, 25, 50, -1],
                                [10, 25, 50, 'All']
                            ],
                ajax: '{{ route("audit-management.general-log.ajax") }}',
                columns: [
                    { data: 'no' },
                    { data: 'log_type' },
                    { data: 'table' },
                    { data: 'after' },
                    { data: 'user_id' },
                    { data: 'ip_address' },
                    { data: 'user_agent' }
                ],
                columnDefs: [
                    {
                        targets: 0,
                        className: 'text-center',
                        width: '5%' 
                    },
                    {
                        targets: 1,
                        className: 'text-center',
                    },
                    {
                        targets: 2,
                        className: 'text-center',
                    },
                     {
                        targets: 3,
                        className: 'text-center',
                    },
                    {
                        targets: 4,
                        className: 'text-center',
                    },
                    {
                        targets: 5,
                        className: 'text-center',
                        width: '20%' 
                    }
                ]
            });

            $(document).on('click', '.view-after-btn', function () {
                const content = $(this).data('after');

                let jsonData;
                try {
                    jsonData = typeof content === 'string' ? JSON.parse(content) : content;

                    // Extract table name
                    let tableName = '';
                    const match = jsonData.sql.match(/into\s+`?(\w+)`?/i);
                    if (match) {
                    tableName = match[1];
                    }

                    // Extract columns
                    const columnsMatch = jsonData.sql.match(/\(([^)]+)\)\s+values/i);
                    const columns = columnsMatch
                    ? columnsMatch[1].replace(/`/g, '').split(',').map(c => c.trim())
                    : [];

                    const bindings = jsonData.bindings || [];

                    // SQL Header section
                    $('#afterContentHeader').html(`
                    <div class="card border-primary mb-3">
                        <div class="card-body p-3">
                        <p class="card-title mb-2">Table: <strong>${tableName}</strong></p>
                        <p class="mb-2"><strong>Execution Time:</strong> ${jsonData.time} ms</p>
                        <div class="bg-light p-2 border rounded">
                            <pre class="mb-0 text-dark small" style="max-height: 150px; overflow:auto;"><code>${jsonData.sql}</code></pre>
                        </div>
                        </div>
                    </div>
                    `);

                    // Bindings table
                    if (columns.length === bindings.length) {
                    let tableHtml = `
                        <div class="table-responsive">
                        <table class="table table-bordered table-sm">
                            <thead class="table-secondary">
                            <tr>
                                <th style="width: 40%">Column</th>
                                <th>Value</th>
                            </tr>
                            </thead>
                            <tbody>
                    `;
                    for (let i = 0; i < columns.length; i++) {
                        const value = bindings[i] === null
                        ? '<span class="text-muted fst-italic">null</span>'
                        : bindings[i];
                        tableHtml += `
                        <tr>
                            <td><strong>${columns[i]}</strong></td>
                            <td>${value}</td>
                        </tr>
                        `;
                    }
                    tableHtml += `</tbody></table></div>`;
                    $('#afterContentBindings').html(tableHtml);
                    } else {
                    $('#afterContentBindings').html('<div class="text-danger">Mismatch in columns and bindings.</div>');
                    }

                } catch (e) {
                    $('#afterContentHeader').html('<div class="alert alert-danger">Format JSON tidak sah atau rosak.</div>');
                    $('#afterContentBindings').empty();
                }

                $('#logAfterModal').modal('show');
            });

        });

    </script>
    
@endpush