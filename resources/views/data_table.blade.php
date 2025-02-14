@include('layouts.header')

@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show mt-2" role="alert">
        <i class="fa fa-check-circle mr-1"></i>
        {{ session('success') }}
        {{-- <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button> --}}
    </div>
@endif

<section class="content-header">
    <div class="container-fluid">
        <div class="row mt-2 align-items-center justify-content-between">
            <div class="col-12 col-md-4 text-center text-md-left mb-2 mb-md-0">
                <h1>Users Data</h1>
            </div>

            <div class="col-12 col-md-6 d-flex justify-content-center justify-content-md-end gap-3">
                <a href="{{ route('sample.csv') }}" class="btn btn-info btn-sm btn-md-lg mx-1">
                    <i class="fa fa-file-csv me-1"></i> Sample CSV
                </a>

                <button type="button" class="btn btn-success btn-sm btn-md-lg mx-1" data-toggle="modal"
                    data-target="#importCsvModal">
                    <i class="fa fa-upload me-1"></i> Import CSV
                </button>

                <a href="{{ route('data') }}" class="btn btn-primary btn-sm btn-md-lg mx-1">
                    <i class="fa fa-user-plus me-1"></i> Add User
                </a>
            </div>

        </div>
    </div>
</section>

<div class="modal fade" id="importCsvModal" tabindex="-1" role="dialog" aria-labelledby="importCsvModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">

            <div class="modal-header bg-default text-black">
                <h5 class="modal-title" id="importCsvModalLabel">
                    <i class="fa fa-upload mr-1"></i> Import CSV File
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <form action="{{ route('import.csv') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="csv_file">Choose CSV File:</label>
                        <input type="file" name="csv_file" id="csv_file" class="form-control" accept=".csv">
                    </div>

                    <button type="submit" class="btn btn-primary">
                        <i class="fa fa-check-circle mr-1"></i> Upload
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<section class="content">
    <div class="container-fluied">
        <div class="row">
            <div class="col-md-12">
                <div class="card m-2">
                    <div class="card-body">
                        <div id="data-table">
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead style="font-size: 15px; background-color: rgb(241, 241, 221)">
                                        <tr>
                                            <th>No.</th>
                                            <th>Name</th>
                                            <th>Phone No</th>
                                            <th>Email</th>
                                            <th>Address</th>
                                            <th>Country</th>
                                            <th>State</th>
                                            <th>City</th>
                                            <th>PinCode</th>
                                            <th>Company_Name</th>
                                            <th>Designation</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @php
                                            $i = 1;
                                        @endphp
                                        @if (isset($datas))
                                            @foreach ($datas as $data)
                                                <tr>
                                                    <td>{{ $i }}</td>
                                                    <td>{{ $data->name }}</td>
                                                    <td>{{ $data->phone_no }}</td>
                                                    <td>{{ $data->email }}</td>
                                                    <td>{{ $data->address }}</td>
                                                    <td>{{ $data->country }}</td>
                                                    <td>{{ $data->state }}</td>
                                                    <td>{{ $data->city }}</td>
                                                    <td>{{ $data->pincode }}</td>
                                                    <td>{{ $data->company_name }}</td>
                                                    <td>{{ $data->designation }}</td>

                                                    <td>
                                                        <a href="{{ route('data.edit', $data->id) }}"
                                                            class="text-primary mr-2" title="Edit">
                                                            <i class="fa fa-edit"></i>
                                                        </a>
                                                    
                                                        <a href="{{ route('data.destroy', $data->id) }}"
                                                            class="text-danger" title="Delete">
                                                            <i class="fa fa-trash"></i>
                                                        </a>
                                                    </td>

                                                </tr>
                                                @php
                                                    $i++;
                                                @endphp
                                            @endforeach
                                        @endif
                                    </tbody>
                                </table>

                                <div id="pagination-links">
                                    {{ $datas->links('pagination::bootstrap-5') }}
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    $(document).ready(function() {

        var currentPage = 1;

        $(document).on('click', '.pagination a', function(event) {
            event.preventDefault();

            var page = $(this).attr('href').split('page=')[1];
            fetch_data(page);
        });

        function fetch_data(page) {
            $.ajax({
                url: "{{ route('data.table') }}?page=" + page,
                success: function(data) {
                    var $html = $(data.html);
                    var rows = $html.find('#data-table tbody tr');

                    rows.each(function(index) {
                        $(this).find('td:first').text((page - 1) * 25 + index + 1);
                    });

                    $('#data-table').html($html.find('#data-table').html());
                    $('#pagination-links').html($(data.pagination).find('#pagination-links')
                        .html());

                    currentPage = page;
                }
            });
        }

        $('.fade').hide(3000);

    });
</script>

@include('layouts.footer')
