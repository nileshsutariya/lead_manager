@include('layouts.header')

<section class="content-header">
    <div class="container-fluid">
        <div class="row mt-1">
            <div class="col-12 col-md-7 text-center text-md-left">
                <h1>Mail Templet</h1>
            </div>

            <div
                class="col-12 col-md-5 d-flex flex-column flex-md-row justify-content-center justify-content-md-end align-items-center align-items-md-end">
                <div class="card-tools mb-2 mb-md-0">
                    <div class="input-group input-group-lg">
                        <input type="text" class="form-control mr-2" placeholder="Search..."
                            style="border-radius: 5px; height: 40px;" id="search-bar">
                    </div>
                </div>

                <div class="mt-2 mt-md-0">
                    <a href="{{ route('mail') }}" class="btn btn-primary btn-md" style="white-space: nowrap;">Add
                        Mail-Templet</a>
                </div>
            </div>
        </div>

        <section class="content">
            <div class="container-fluied">
                <div class="row">
                    <div class="col-12">
                        <div class="card mt-3">
                            <div class="card-body">
                                <div id="mail-table">
                                    <div class="table-responsive">
                                        <table id="example1" class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>No.</th>
                                                    <th>Name</th>
                                                    <th>Message</th>
                                                    <th>Category</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if (isset($emails))
                                                    @foreach ($emails as $key => $email)
                                                        <tr>
                                                            <td>{{ ($emails->currentPage() - 1) * $emails->perPage() + $key + 1 }}
                                                            </td>
                                                            <td>{{ $email->name }}</td>
                                                            <td>{{ Str::limit(strip_tags($email->message), 25, '...') }}
                                                            </td>
                                                            <td>{{ $email->category->name }}</td>
                                                            <td>
                                                                <a href="{{ route('mail.edit', $email->id) }}"
                                                                    class="text-primary mr-2" title="Edit">
                                                                    <i class="fa fa-edit"></i>
                                                                </a>
                                                                <a href="{{ route('mail.destroy', $email->id) }}"
                                                                    class="text-danger" title="Delete">
                                                                    <i class="fa fa-trash"></i>
                                                                </a>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                @endif
                                            </tbody>

                                        </table>

                                        <div id="pagination-links">
                                            {{ $emails->links('pagination::bootstrap-5') }}
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
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
                url: "{{ route('mail.table') }}?page=" + page,
                success: function(data) {
                    var $html = $(data.html);
                    var rows = $html.find('#data-table tbody tr');

                    $('#mail-table').html($html.find('#mail-table').html());
                    $('#pagination-links').html($(data.pagination).find('#pagination-links')
                        .html());

                    currentPage = page;
                }
            });
        }
    });

    $(document).ready(function() {
        $('#search-bar').on('keyup', function() {
            var value = $(this).val().toLowerCase();
            var rowsFound = false;

            $('.table tbody tr').each(function() {
                var name = $(this).find('td').eq(1).text().toLowerCase();
                var message = $(this).find('td').eq(2).text().toLowerCase();

                if (name.indexOf(value) > -1 || message.indexOf(value) > -1) {
                    $(this).show();
                } else {
                    $(this).hide();
                }
            });
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

<style>
</style>
