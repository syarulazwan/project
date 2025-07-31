@push('styles')
    <style>
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
                            <a href="javascript:void(0);" class="mb-0 fw-semibold">Project</a>
                        </li>
                            <li class="breadcrumb-item">
                            <a href="javascript:void(0);" class="mb-0 fw-semibold">ZARA</a>
                        </li>
                        <li class="breadcrumb-item active mb-0 fw-semibold" aria-current="page">Chat</li>
                    </ol>
                </nav>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-12">
                <div class="card custom-card">
                    <div class="container mt-4">
                        <div class="container mt-5">
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Upload PDF Document</h5>
        </div>
        <div class="card-body">
            @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
            @endif

            <form method="POST" action="{{ route('chatai.pdf.upload') }}" enctype="multipart/form-data">
                @csrf

                <div class="mb-3">
                    <label for="pdf" class="form-label">Select PDF File</label>
                    <input type="file" name="pdf" id="pdf" class="form-control" accept="application/pdf" required>
                </div>

                <button type="submit" class="btn btn-success">
                    <i class="bi bi-upload"></i> Upload PDF
                </button>
            </form>
        </div>
    </div>

    @if($documents->count())
    <div class="card shadow-sm">
        <div class="card-header bg-secondary text-white">
            <h5 class="mb-0">Uploaded PDFs</h5>
        </div>
        <div class="card-body p-0">
            <table class="table table-striped table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Title</th>
                        <th>Readyness</th>
                        <th>Uploaded At</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($documents as $doc)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $doc->title }}</td>
                        <td>
                            @php
                            $statusClass = [
                            'pending' => 'warning',
                            'processed' => 'success',
                            ][$doc->status] ?? 'secondary';
                            @endphp

                            <span class="badge bg-{{ $statusClass }} text-capitalize">
                                {{ $doc->status }}
                            </span>
                        </td>
                        <td>{{ $doc->created_at->format('d M Y, H:i') }}</td>
                        <td>
                            <a href="{{ asset('storage/' . $doc->file_path) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                <i class="bi bi-eye"></i> View
                            </a>
                            <a href="{{ asset('storage/' . $doc->file_path) }}" download class="btn btn-sm btn-outline-success">
                                <i class="bi bi-download"></i> Download
                            </a>
                            <form action="{{ route('chatai.pdf.delete', $doc->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this PDF?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger">
                                    <i class="bi bi-trash"></i> Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endif
</div>
                    </div>                 
                </div>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script>
    </script>
@endpush