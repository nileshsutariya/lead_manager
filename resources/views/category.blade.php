@include('layouts.header')

<div class="container-fluid">
    <div class="row">
        <div class="col-md-6">
            <div class="card card-default m-2">
                <div class="card-header" style="background-color: rgb(249, 248, 252)">
                    <h1 class="card-title" style="font-size: 20px">Category</h1>
                </div>
                @if (isset($category))
                    <form action="{{ route('category.update', $category->id) }}" method="post">
                    @else
                        <form method="post" action="{{ route('category.store') }}">
                @endif
                @csrf
                <div class="card-body">
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" class="form-control"
                            value="{{ isset($category) ? $category->name : old('name') }}" id="name"
                            placeholder="Enter Name" name="name">
                        @error('name')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="mail_templet">Mail Template</label>
                        <select class="form-control select2" id="mail_templet" name="mail_templet">
                            <option value="">Select a template</option>
                            @foreach ($mail_template as $id => $name)
                                <option value="{{ $id }}"
                                    {{ old('mail_templet', isset($category) ? $category->mail_templet : '') == $id ? 'selected' : '' }}>
                                    {{ $name }}
                                </option>
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
        @if (isset($categories))

            <div class="col-md-6 mt-2">
                <div class="card ">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="example1" class="table table-bordered table-responsive">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Name</th>
                                        <th>Mail_Templet</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (isset($categories))
                                        @foreach ($categories as $key => $category)
                                            <tr>
                                                <td>{{ $key + 1 }} </td>
                                                <td>{{ $category->name }}</td>
                                                <td>
                                                    {{ $category->email }}
                                                </td>
                                                <td>
                                                    <a href="{{ route('category.edit', $category->id) }}"
                                                        class="text-primary mr-2" title="Edit">
                                                        <i class="fa fa-edit"></i>
                                                    </a>
                                                    <a href="{{ route('category.delete', $category->id) }}"
                                                        class="text-danger" title="Delete">
                                                        <i class="fa fa-trash"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        @endif
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
