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
            <!-- end page title -->

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="body d-flex justify-content-between align-items-center mb-3">
                                <h4 class="card-title">Cities</h4>
                                <a href="{{ route('admin.category.create') }}" class="ml-auto btn btn-success">Add</a>
                            </div>
                            <table id="datatable" class="table table-bordered dt-responsive  nowrap w-100">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Status</th>
                                        <th>Settings</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($categories as $data)
                                        <tr>
                                            <td>{{ json_decode($data, true)['name']['az'] }}</td>
                                            <td>
                                                <div class="form-check form-switch form-switch-lg col-md-10" dir="ltr">
                                                    <input class="form-check-input" type="checkbox" name="status"
                                                        id="SwitchCheckSizelg" {{ $data['status'] == 1 ? 'checked' : '' }}>
                                                </div>
                                            </td>
                                            <td><a class="btn btn-link p-0" href="{{ route('admin.category.edit', $data['id']) }}" data-bs-toggle="tooltip"
                                                    data-bs-placement="top" title="Edit"><span
                                                        class="text-500 fas fa-edit"></span></a>
                                                <form action="{{ route('admin.category.destroy',$data['id']) }}" method="post" style="display:inline-block">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"  class="btn btn-danger waves-effect waves-light">
                                                        <i class="mdi mdi-trash-can d-block font-size-16"></i>
                                                    </button>
                                                </form>
                                            </td>

                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div> <!-- end col -->
            </div> <!-- end row -->

            <div class="pagination">
                {!! $categories->links() !!}
            </div>
        </div> <!-- container-fluid -->
    </div>
    <!-- End Page-content -->
@endsection
