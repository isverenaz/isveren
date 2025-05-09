@extends('admin.layouts.app')
@section('admin.css')
@endsection
@section('admin.content')
    <div class="page-content">
        <div class="container-fluid">
            <!-- start page title -->
            @if ( Session::get('error'))
                <div class="col-12 mt-1">
                    <div class="alert alert-danger" role="alert">
                        <div class="alert-body">{{ Session::get('error') }}</div>
                    </div>
                </div>
            @endif
            @if (Session::get('success'))
                <div class="col-12 mt-1">
                    <div class="alert alert-success" role="alert">
                        <div class="alert-body">{{ Session::get('success') }}</div>
                    </div>
                </div>
            @endif
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0 font-size-18">Contact Us</h4>
                    </div>
                </div>
            </div>
            <!-- end page title -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table align-middle table-nowrap mb-0">
                                    <thead class="table-light">
                                    <tr>
                                        <th class="align-middle">Full Name</th>
                                        <th class="align-middle">Phone</th>
                                        <th class="align-middle">Email</th>
                                        <th class="align-middle">Type</th>
                                        <th class="align-middle">View Details</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if(!empty($contacts))
                                        @foreach($contacts as $key=> $contact)
                                            <tr>
                                                <td>{!! $contact->full_name !!} </td>
                                                <td>{!! $contact->phone !!} </td>
                                                <td>{!! $contact->email !!} </td>
                                                <td>{!! $contact->type !!} </td>
                                                <td>
                                                    <!-- Button trigger modal -->
                                                    <button type="button" class="btn btn-primary btn-sm btn-rounded waves-effect waves-light" data-bs-toggle="modal" data-bs-target=".transaction-detailModal{{$contact->id}}">
                                                        Read More
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                    Mesaj yoxdu
                                    @endif
                                    </tbody>
                                </table>
                            </div>
                            <!-- end table-responsive -->
                        </div>
                    </div>
                </div>
            </div>
            <!-- end row -->
        </div>
        <!-- container-fluid -->
    </div>
    <!-- End Page-content -->
    @if(!empty($contacts))
        @foreach($contacts as $key=> $contact)
            <!-- Transaction Modal -->
            <div class="modal fade transaction-detailModal{{$contact->id}}" tabindex="-1" role="dialog" aria-labelledby="transaction-detailModalLabel{{$contact->id}}" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="transaction-detailModalLabel">{!! $contact->full_name !!}</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <p class="mb-4">{!! $contact->messages !!}</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end modal -->
        @endforeach
    @endif



@endsection
@section('admin.js')
@endsection
