<div class="table-responsive">
    <table id="tableprojectlocation" class="table table-bordered text-nowrap w-100">
        <thead>
            <tr>
                <th>No</th>
                <th>Address</th>
                <th>City</th>
                <th>State</th>
                <th>Postcode</th>
                <th>Country</th>
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

           $('#tableprojectlocation').DataTable({
                // responsive: true,
                lengthMenu: [
                                [10, 25, 50, -1],
                                [10, 25, 50, 'All']
                            ],
                ajax: {
                    url: '{{ url("project/list-of-project") }}/' + projectId + '/ajax-location',
                    data: function(d) {
                        d.project_id = projectId;
                    }
                },
                columns: [
                    { data: 'no' },
                    { data: 'address' },
                    { data: 'city' },
                    { data: 'state' },
                    { data: 'location' },
                    { data: 'country' }
                ],
            
                columnDefs: [
                    {
                        targets: 0,
                        className: 'text-center',
                        width: '5%' 
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
                        width: '20%' 
                    }
                ]
            });

        });
        
    </script>
@endpush