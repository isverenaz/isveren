@extends('admin.layouts.app')
@section('admin.css')
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/assets/css/toastr.min.css') }}">
@endsection
@section('admin.content')
    <div class="page-content">
        <div class="container-fluid">
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
                    <div class="card">
                        <div class="card-header">
                            <form action="?" method="get">
                                <div class="body d-flex justify-content-between align-items-center mb-3">
                                    <select class="form-control" name="status">
                                        <option value="">-Sec</option>
                                        <option value="1">-Aktiv olan</option>
                                        <option value="2">-Aktiv olmayan</option>
                                    </select>
                                    <button type="submit" class="ml-auto btn btn-success">Axtar</button>
                                </div>
                            </form>
                        </div>
                        <div class="card-body">
                            <div class="body d-flex justify-content-between align-items-center mb-3">
                                <h4 class="card-title">Cv</h4>
                            </div>
                            <table id="datatable" class="table table-bordered dt-responsive  nowrap w-100">
                                <thead>
                                    <tr>
                                        <th>Ad/Soyad</th>
                                        <th>Email</th>
                                        <th>Telefon</th>
                                        <th>Status</th>
                                        <th>Baxış</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($cv as $data)
                                        <tr>
                                            <td>{{ $data['user']['name'] }} {{ $data['user']['surname'] }}</td>
                                            <td>{{ $data['email'] }}</td>
                                            <td>{{ $data['phone'] }}</td>
                                            <td>
                                                <div class="form-check form-switch mb-3" dir="ltr">
                                                    <input class="form-check-input" type="checkbox" id="attribute_status"  name="attribute_status" @if($data['status'] == 1) checked="" @endif onChange="changeStat({{ $data['id'] }},{{ $data['status'] }})">
                                                </div>
                                            </td>
                                            <td>
                                                <a class="btn btn-link p-0" href="{{ route('admin.cv.show', $data['id']) }}" data-bs-toggle="tooltip" data-bs-placement="top" title="Baxış">
                                                    <span class="text-1000 fas fa-eye"></span>
                                                </a>
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
                    {!! $cv->links() !!}
                </div>
        </div> <!-- container-fluid -->
    </div>
    <!-- End Page-content -->
@endsection
@section('admin.js')
    <script src="{{ asset('admin/assets/js/toastr.min.js') }}"></script>
    <script type="text/javascript">
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>
    <script>
        function changeStat(id, status) {
            var token = $("meta[name='_token']").attr('content');
            var url = '{{ env('APP_URL ') }}/admin/cv/status/' + id;
            $.ajax({
                url: `${url}`,
                dataType: 'json',
                data: {
                    status: status,
                    _token: token
                },
                type: 'post',
                success: function(data) {
                    toastr.success("Məlumat yeniləndi");
                },
                error: function(data) {
                    toastr.error("Yenidən cəhd göstərin");
                }
            })
        }
    </script>
@endsection
