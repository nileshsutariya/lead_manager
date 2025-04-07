@include('layouts.header')

<div class="container-fluid">
    <div class="row">
        <div class="col-md-6">
            <div class="card card-default m-2">
                <div class="card-header" style="background-color: rgb(249, 248, 252)">
                    <h1 class="card-title" style="font-size: 20px">Category</h1>
                </div>
                <form method="post" action="{{ route('category.store') }}">
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
                        <div class="form-group">
                            <label for="mail_templet">Mail Template</label>
                            <select class="form-control select2" id="mail_templet" name="mail_templet">
                                <option value="">Select a template</option>
                                @foreach ($mail_template as $id => $name)
                                    <option value="{{ $id }}">{{ $name }}</option>
                                @endforeach
                            </select>
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
                                    <th>No.</th>
                                    <th>Name</th>
                                    <th>Mail_Templet</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (isset($categories))
                                    @if ($categories->count())
                                        @foreach ($categories as $key => $category)
                                            <tr>
                                                <td>{{ $key + 1 }} </td>
                                                <td>{{ $category->name }}</td>
                                                <td>
                                                    @if ($category->emails->count())
                                                        @foreach ($category->emails as $email)
                                                            {{ $email->name }}<br>  
                                                        @endforeach
                                                    @else
                                                        N/A
                                                    @endif
                                                </td>
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
        $('#mail_templet').select2({
            placeholder: "Select a template",
            allowClear: true
        });

        $('.select2-selection').css({
            'height': '38px',
            'font-size': '16px',
            'padding': '5px 12px'
        });
    });
</script>

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
