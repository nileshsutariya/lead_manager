@include('layouts.header')

<section class="content-header">
    <div class="container-fluid">
        <div class="row mt-1">
            <div class="col-md-12 text-center text-md-left">
                <h1>Mail Create</h1>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="card m-1">
                    <div class="card-body">
                        <form id="userForm" method="POST" action="{{ route('create.mail.store') }}"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3 position-relative">
                                <label for="user_search">Search User</label>
                                <textarea id="user_search" name="user_search" placeholder="Search..." style="width: 100px"></textarea>
                                <input type="hidden" id="user_search_data" name="user_search_data">
                                <div id="search_results"
                                    class="list-group position-absolute w-100 mt-1 bg-white border shadow"
                                    style="z-index: 1000; display: none;"></div>
                                @error('user_search')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <input type="hidden" id="user_id" name="user_id">
                            <div id="user_details" style="display: none;">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label>Name</label>
                                        <input type="text" class="form-control" id="name" name="name">
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label>Email</label>
                                        <input type="email" class="form-control" id="email" name="email">
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label>Phone</label>
                                        <input type="text" class="form-control" id="phone_no" name="phone">
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label>Company</label>
                                        <input type="text" class="form-control" id="company_name"
                                            name="company_name">
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label>Company Type</label>
                                        <select class="form-control select2" id="company_type" name="company_type"
                                            style="width: 100%;">
                                            <option value="">Select a Company Type</option>
                                            @foreach ($companies as $id => $name)
                                                <option value="{{ $id }}">{{ $name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label>Reference</label>
                                        <input type="text" class="form-control" id="reference" name="reference">
                                    </div>

                                    <div class="col-md-12 mb-3">
                                        <div class="select2-primary">
                                            <label for="categories">Categories</label>
                                            <select class="select2" multiple="multiple"
                                                data-placeholder="Select a Category"
                                                data-dropdown-css-class="select2-primary" id="categories"
                                                name="category[]">
                                                @foreach ($categories as $id => $name)
                                                    <option value="{{ $id }}">
                                                        {{ $name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-4 mb-3">
                                        <label>Country</label>
                                        <input type="text" class="form-control" id="country" name="country">
                                    </div>

                                    <div class="col-md-4 mb-3">
                                        <label>State</label>
                                        <input type="text" class="form-control" id="state" name="state">
                                    </div>

                                    <div class="col-md-4 mb-3">
                                        <label>City</label>
                                        <input type="text" class="form-control" id="city" name="city">
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label>Pincode</label>
                                        <input type="text" class="form-control" id="pincode" name="pincode">
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label>Address</label>
                                        <input type="text" class="form-control" id="address" name="address">
                                    </div>
                                </div>

                                <div class="text-right">
                                    <button type="button" id="submitBtn" class="btn btn-primary">Submit</button>
                                    <button type="button" id="updateBtn"
                                        class="btn btn-success d-none">Update</button>
                                </div>
                            </div>

                            <div class="mb-3 mt-4">
                                <label for="mail_template">Mail Template</label>
                                <select class="form-control select2" id="mail_template" name="mail_template"
                                    style="width: 100%;">
                                    <option value="">Select a Mail Template</option>
                                    @foreach ($emails as $id => $name)
                                        <option value="{{ $id }}">{{ $name }}</option>
                                    @endforeach
                                </select>
                                @error('mail_template')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div id="mail_template_details" style="display: none;">
                                <div class="mb-3">
                                    <label for="mail_subject">Subject</label>
                                    <input type="text" class="form-control" id="mail_subject"
                                        name="mail_subject">
                                    @error('mail_subject')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="mail_message">Message</label>
                                    <textarea class="form-control" id="mail_message" name="mail_message"></textarea>
                                </div>

                                <div class="mb-3">
                                    <button type="button" id="add-attachments-btn" class="btn btn-primary">
                                        Add Attachments
                                    </button>
                                    <div class="file-input-wrapper" id="file-input-wrapper-${counter}"
                                        style="position: relative; margin-top: 10px;">
                                        <input type="file" class="form-control" name="attachments[]"
                                            id="attachments-${counter}" multiple>
                                    </div>
                                    <div id="file-input-container"></div>
                                </div>
                            </div>

                            <div class="card-footer mt-2 text-right">
                                <button type="submit" class="btn btn-primary">Send Mail</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card m-1 data">
                    <h4 class="mt-3 ml-3">Mail History</h4>
                    <div class="card-body">
                        <div id="data-table">
                            <table id="example1" class="table table-bordered table-responsive">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        {{-- <th>Mail Template</th> --}}
                                        <th>Categories</th>
                                        <th>Reference</th>
                                        <th>Mail_sent_at</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {{-- @php
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
                                            </tr>
                                            @php
                                                $i++;
                                            @endphp
                                        @endforeach
                                    @endif --}}
                                </tbody>
                            </table>
                            {{-- <div id="pagination-links">
                                {{ $datas->links('pagination::bootstrap-5') }}
                            </div> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
</section>

<script>
    $(document).ready(function() {

        // $('.data').hide();

        let userSearchInput = document.querySelector("#user_search");
        let tagify = new Tagify(userSearchInput, {
            maxTags: 10,
            dropdown: {
                enabled: 3,
                maxItems: 10
            }
        });

        tagify.on("input", function(e) {
            let query = e.detail.value.toLowerCase();

            if (query.length > 2) {
                $.ajax({
                    url: "{{ route('users.search') }}",
                    type: "GET",
                    data: {
                        query
                    },
                    success: function(response) {
                        const whitelist = [];
                        const selectedUserIds = new Set(tagify.value.map(item => String(item
                            .id)));
                        console.log('Selected User IDs:', selectedUserIds);

                        response.forEach(user => {
                            if (selectedUserIds.has(String(user.id))) {
                                return;
                            }

                            const fields = [{
                                    label: 'name',
                                    value: user.name
                                },
                                {
                                    label: 'email',
                                    value: user.email
                                },
                                {
                                    label: 'phone',
                                    value: user.phone_no
                                },
                                {
                                    label: 'company_name',
                                    value: user.company_name
                                }
                            ];

                            fields.forEach(field => {
                                const lowerValue = field.value
                                    ?.toLowerCase();
                                if (lowerValue && lowerValue.includes(
                                        query)) {
                                    whitelist.push({
                                        value: field.value,
                                        field_type: field.label,
                                        id: user.id,
                                        email: user.email,
                                        name: user.name,
                                        phone: user.phone_no,
                                        company_name: user
                                            .company_name,
                                        company_type: user
                                            .company_type,
                                        country: user.country,
                                        state: user.state,
                                        city: user.city,
                                        categories: user
                                            .category_names,
                                        pincode: user.pincode,
                                        address: user.address,
                                        reference: user.reference
                                    });
                                }
                            });
                        });

                        tagify.settings.whitelist = whitelist;

                        if (whitelist.length > 0 && !tagify.dropdown.visible) {
                            tagify.dropdown.show();
                        }
                    }
                });
            }
        });

        tagify.on("add", function(e) {
            let user = e.detail.data;

            if (user.id) {
                populateUserFields(user);
            } else {
                resetUserFields();
            }

            console.log('Item selected:', user);
            tagify.input.value = '';
            tagify.settings.whitelist = tagify.settings.whitelist.filter(item => item.id !== user.id);
            tagify.dropdown.hide();

            $("#user_details").show();
        });


        tagify.on("remove", function(e) {
            console.log('Item removed:', e.detail.data);
            tagify.dropdown.show();
            let remainingUsers = tagify.value;

            if (remainingUsers.length > 0) {
                let latestUser = remainingUsers[remainingUsers.length - 1];
                populateUserFields(latestUser);
            } else {
                $("#user_details").hide();
            }
        });


        function populateUserFields(user) {
            $("#user_id").val(user.id || '');
            $("#name").val(user.name || '');
            $("#email").val(user.email || '');
            $("#phone_no").val(user.phone || '');
            $("#company_name").val(user.company_name || '');
            $("#country").val(user.country || '');
            $("#state").val(user.state || '');
            $("#city").val(user.city || '');
            $("#pincode").val(user.pincode || '');
            $("#address").val(user.address || '');
            $("#reference").val(user.reference || '');

            $("#categories").val([]).trigger("change");
            let selectedCategoryIds = [];
            $("#categories option").each(function() {
                if (user.categories && user.categories.includes($(this).text().trim())) {
                    selectedCategoryIds.push($(this).val());
                }
            });
            $("#categories").val(selectedCategoryIds).trigger("change");

            let companyTypeVal = null;
            $("#company_type option").each(function() {
                if ($(this).text() === (user.company_type || "")) {
                    companyTypeVal = $(this).val();
                }
            });
            $("#company_type").val(companyTypeVal).trigger("change");

            $("#user_details").show();
            $("#updateBtn").removeClass('d-none');
            $("#submitBtn").addClass('d-none');
        }

        function resetUserFields() {
            $("#user_id").val('');
            $("#name").val('');
            $("#email").val('');
            $("#phone_no").val('');
            $("#company_name").val('');
            $("#company_type").val('').trigger("change");
            $("#country").val('');
            $("#state").val('');
            $("#city").val('');
            $("#categories").val([]).trigger("change");
            $("#pincode").val('');
            $("#address").val('');
            $("#reference").val('');

            $("#user_details").show();
            $("#updateBtn").addClass('d-none');
            $("#submitBtn").removeClass('d-none');
        }

        $("#submitBtn").on("click", function(e) {
            e.preventDefault();
            $(".text-danger.dynamic-error").remove();

            let country = $("#country").val().trim();
            let email = $("#email").val().trim();
            let phone = $("#phone_no").val().trim();
            let companyName = $("#company_name").val().trim();
            let name = $("#name").val().trim();

            if (!email && !phone && !companyName && !name) {
                const errorMsg =
                    '<div class="text-danger dynamic-error">name || email || phone || company_name one of these fields is required</div>';

                $("#email").after(errorMsg);
                $("#phone_no").after(errorMsg);
                $("#company_name").after(errorMsg);
                $("#name").closest('.form-group, .mb-3').append(errorMsg);
                return;
            }

            if (!country) {
                if (!$("#country").siblings(".text-danger").length) {
                    $("#country").after(
                        '<div class="text-danger">The country field is required.</div>');
                }
                return;
            } else {
                $("#country").siblings(".text-danger").remove();
            }

            let form = document.getElementById('userForm');
            let formData = new FormData(form);

            $.ajax({
                url: "{{ route('data.store') }}",
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    window.location.href = "{{ route('mail.create') }}";
                },
                error: function(xhr) {
                    if (xhr.status === 422) {
                        let errors = xhr.responseJSON.errors;
                        $(".text-danger").remove();

                        $.each(errors, function(key, value) {
                            let input = $(`[name="${key}"]`);
                            input.siblings(".text-danger").remove();
                            input.after(
                                `<div class="text-danger">${value[0]}</div>`);
                        });

                        $("#user_details").show();
                    } else {
                        alert("Something went wrong.");
                        console.log(xhr.responseText);
                    }
                }
            });
        });

        $("#updateBtn").on("click", function(e) {
            e.preventDefault();

            $("#country").siblings(".text-danger").remove();
            $(".text-danger.dynamic-error").remove();

            let country = $("#country").val().trim();
            let email = $("#email").val().trim();
            let phone = $("#phone_no").val().trim();
            let companyName = $("#company_name").val().trim();
            let name = $("#name").val().trim();

            if (!email && !phone && !companyName && !name) {
                const errorMsg =
                    '<div class="text-danger dynamic-error">name || email || phone || company_name one of these fields are required</div>';
                $("#email").after(errorMsg);
                $("#phone_no").after(errorMsg);
                $("#company_name").after(errorMsg);
                $("#name").closest('.form-group, .mb-3').append(errorMsg);
                return;
            }

            if (!country) {
                $("#country").after(
                    '<div class="text-danger dynamic-error">The country field is required.</div>'
                );
                return;
            }

            let userId = $("#user_id").val();
            console.log('User ID:', userId);
            let updateUrl = "{{ route('data.update', ':id') }}".replace(':id', userId);
            let formData = new FormData(document.getElementById("userForm"));

            $.ajax({
                url: updateUrl,
                method: "POST",
                data: formData,
                processData: false,
                contentType: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr("content"),
                },
                success: function(response) {
                    $("#user_details").show();
                },
                error: function(xhr) {
                    console.log(xhr.responseText);
                },
            });
        });

        $("#email, #phone_no, #company_name, #name").on("input change", function() {
            let email = $("#email").val().trim();
            let phone = $("#phone_no").val().trim();
            let companyName = $("#company_name").val().trim();
            let name = $("#name").val().trim();

            if (email || phone || companyName || name) {
                $(".text-danger.dynamic-error").remove();
            }
        });


    });

    $(document).ready(function() {
        var counter = 0;

        $('#add-attachments-btn').on('click', function() {
            counter++;

            var newFileInput = `
         <div class="file-input-wrapper" id="file-input-wrapper-${counter}" style="position: relative; margin-top: 10px;">
                <input type="file" class="form-control" name="attachments[]" id="attachments-${counter}" multiple>
                <button type="button" class="btn btn-danger remove-btn" data-id="${counter}" 
                    style="position: absolute; top: 5px; right: 5px; padding: 2px 5px; font-size: 18px; 
                    width: 25px; height: 25px; text-align: center; line-height: 20px; border-radius: 50%;
                     background-color: red; color: white;">-</button>
            </div>
        `;

            $('#file-input-container').append(newFileInput);
        });
        $(document).on('click', '.remove-btn', function() {
            var id = $(this).data('id');
            $('#file-input-wrapper-' + id).remove();
        });
    });
</script>

<script>
    $(document).ready(function() {
        $('#mail_message').summernote({
            placeholder: 'Write your message here...',
            tabsize: 2,
            height: 200,
            toolbar: [
                ['style', ['bold', 'italic', 'underline', 'clear']],
                ['font', ['fontsize']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['insert', ['link', 'picture']]
            ]
        });

        $('#mail_template').on('change', function() {
            let templateId = $(this).val();

            if (templateId) {
                $.ajax({
                    url: "{{ route('mail.templates.show') }}",
                    type: "GET",
                    data: {
                        id: templateId
                    },
                    success: function(response) {
                        if (response) {
                            $('#mail_subject').val(response.subject);
                            $('#mail_message').summernote('code', response.message);
                            $('#mail_template_details').show();

                            // let subject = $('#mail_subject').val().trim();
                            // if (!subject) {
                            //     const errorMsg =
                            //         '<div class="text-danger dynamic-error">Subject field is required</div>';
                            //     $('#mail_subject').after(errorMsg);
                            // }

                        }
                    }
                });
            } else {
                $('#mail_template_details').hide();
                $('#mail_subject').val('');
                $('#mail_message').summernote('code', '');
            }
        });
    });
</script>

<script>
    $(function() {
        $('.select2').select2()

        $('.select2bs4').select2({
            theme: 'bootstrap5'
        })
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
    .select2-container .select2-selection--single {
        height: 38px !important;
        padding: 6px 12px;
        border: 1px solid #ced4da;
        border-radius: 0.25rem;
    }

    .select2-container--default .select2-selection--multiple {
        height: 40px !important;
        padding: 2px 4px;
        border: 1px solid #ced4da;
        border-radius: 0.25rem;
    }

    .tagify-textarea {
        width: 100%;
        font-size: 1rem;
        line-height: 1.5;
        border: 1px solid #ced4da;
        box-sizing: border-box;
        resize: vertical;
    }

    .tagify {
        width: 100%;
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        box-sizing: border-box;
    }
</style>
