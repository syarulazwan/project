@push('styles')
@endpush

@extends('main')
@section('pages')

    <div class="container-fluid">
        <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
            <div class="">
                <nav>
                    <ol class="breadcrumb mb-0" style="--bs-breadcrumb-divider: '>'; color: rgb(0, 0, 0);">
                        <li class="breadcrumb-item">
                            <a href="javascript:void(0);" class="text-black">
                                <i class="bi bi-house-door-fill"></i>
                            </a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="javascript:void(0);" class="text-black">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="javascript:void(0);" class="text-black">More Sub</a>
                        </li>
                        <li class="breadcrumb-item active text-black" aria-current="page">More Sub</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
@endpush