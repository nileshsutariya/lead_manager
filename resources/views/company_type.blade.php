@include('layouts.header')

<div class="container-fluid">
    <div class="row">
        <div class="col-md-6">
            <div class="card card-default m-2">
                <div class="card-header" style="background-color: rgb(249, 248, 252)">
                    <h1 class="card-title" style="font-size: 20px">Company Type</h1>
                </div>
                <form method="post" action="{{route('store.company')}}">
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" class="form-control" id="name" placeholder="Enter Name"
                                name="name">
                            @error('name')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="col-md-6 mt-2">
            <div class="card ">
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="example1" class="table table-bordered table-responsive">
                            <thead >
                                <tr>
                                    <th style="width: 10%">No.</th>
                                    <th style="width: 90%">Name</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (isset($companies))
                                    @if ($companies->count())
                                        @foreach ($companies as $key => $company)
                                            <tr>
                                                <td>{{ $key + 1 }} </td>
                                                <td>{{ $company->name }}</td>
                                            </tr>
                                        @endforeach
                                    @endif
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $("#example1").DataTable({
            "responsive": false,
            "lengthChange": false,
            "autoWidth": false,
            "paging": false,
            "searching": false,
            "ordering": true,
            "info": false,
            "columnDefs": [{
                    "width": "10%",
                    "targets": -1
                },
                {
                    "orderable": false,
                    "targets": -1
                }
            ]
        });
    });
</script>

@include('layouts.footer')
