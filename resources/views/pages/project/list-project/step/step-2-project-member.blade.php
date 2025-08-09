<div class="table-responsive">
    <table id="tableprojectmember" class="table table-bordered text-nowrap w-100">
        <thead>
            <tr>
                <th>No</th>
                <th>Name</th>
                <th>Role</th>
                <th>Joined Date</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</div>

@push('scripts')
    <script>

        $(document).ready(function () {

            let projectId = {{ $project->id }};

           $('#tableprojectmember').DataTable({
                // responsive: true,
                lengthMenu: [
                                [10, 25, 50, -1],
                                [10, 25, 50, 'All']
                            ],
                ajax: {
                    url: '{{ url("project/list-of-project") }}/' + projectId + '/ajax-member',
                    data: function(d) {
                        d.project_id = projectId;
                    }
                },
                columns: [
                    { data: 'no' },
                    { data: 'user_id' },
                    { data: 'role' },
                    { data: 'joined_date' }
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
                        width: '20%' 
                    }
                ]
            });

        });
        
    </script>
@endpush