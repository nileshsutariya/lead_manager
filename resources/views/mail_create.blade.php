@include('layouts.header')

<section class="content-header">
    <div class="container-fluid">
        <div class="row mt-1">
            <div class="col-md-4 text-center text-md-left header">
                <h1>Mail Create</h1>
            </div>
            <div class="col-md-8">
                <div id="alert-placeholder"></div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="card m-1">
                    <div class="card-body">
                        <form id="userForm" method="POST" action="{{ route('create.mail.store') }}"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label>Search User</label>
                                <select class="form-control select2" style="width: 100%;" id="userSearch"
                                    value="" name="search_user">
                                    <option value="">Select a User</option>
                                </select>
                                @error('search_user')
                                    <div class="text-danger">{{$message}}</div>
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
                                        <label>Company Name</label>
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
                                    <button type="button" id="updateBtn" class="btn btn-success d-none">Update</button>
                                </div>
                            </div>

                            <div class="mb-3 mt-4">
                                <label for="mail_template">Mail Template</label>
                                <select class="form-control select2 select2customize" id="mail_template"
                                    name="mail_template" style="width: 100%;">
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
                                    {{-- @error('mail_subject')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror --}}
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
                                        <th style="width: 20%">Mail_sent_at</th>
                                        <th class="text-center">Subject</th>
                                        <th></th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</section>

<script>
    $(document).ready(function() {
        $('.data').hide();

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

$(document).ready(function () {
    $('#userSearch').on('select2:open', function () {
    const observer = new MutationObserver(function () {
        const $input = $('.select2-container--open .select2-search input');
        if ($input.length) {
            observer.disconnect();

            const $resultsList = $('.select2-results__options');
            $resultsList.empty(); 

            const $addItem = $(`
                <li class="select2-results__option new-user"
                    role="option"
                    style="background-color: #e6ffe6; padding: 10px 12px; border-radius: 6px; margin: 6px 0; text-align: center; cursor: pointer; font-weight: bold; color: #007b00;">
                    + Add new user
                </li>
            `);

            $addItem.on('click', function () {
                $('#user_details input').val('');
                $('#user_details select').val('').trigger('change');
                $('#categories').val(null).trigger('change');
                $('#company_type').val(null).trigger('change');

                $('#user_details').slideDown();
                $('.data').hide();
                $('#submitBtn').removeClass('d-none');
                $('#updateBtn').addClass('d-none');

                const $select = $('.select2-container--open').prev('select');
                $select.val(null).trigger('change').select2('close');
            });

            $resultsList.append($addItem); 

            $input.on('input', function () {
                const searchVal = $(this).val().trim();

                $resultsList.empty();

                if (searchVal.length < 1) {
                    $resultsList.append($addItem); 
                    return;
                }

                $.ajax({
                    url: '/users/search',
                    dataType: 'json',
                    data: { q: searchVal },
                    success: function (data) {
                        $resultsList.empty();

                        $('#user_details input').val('');
                        $('#user_details select').val('').trigger('change');
                        $('#user_details').slideUp();
                        $('#submitBtn').addClass('d-none');
                        $('#updateBtn').addClass('d-none');

                        if (data.length === 0) {
                            $resultsList.append($addItem);
                            return;
                        }

                        data.forEach(user => {
                            const displayHtml = `
                                <div style="font-size: 14px; color: #333;">
                                    <div class="row">
                                        <div class="col-md-6"><strong>${user.name ?? ''}</strong></div>
                                        <div class="col-md-6"><span>${user.phone_no ?? ''}</span></div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6"><span>${user.email ?? ''}</span></div>
                                        <div class="col-md-6"><span>${user.company_name ?? ''}</span></div>
                                    </div>
                                </div>`;

                            const $item = $(`
                                <li class="select2-results__option select2-results__option--selectable custom-user-item"
                                    role="option"
                                    data-user-id="${user.id}"
                                    style="background-color: #f4fbff; padding: 10px 12px; border-radius: 6px; margin: 6px 0; transition: background-color 0.3s; cursor: pointer;">
                                    ${displayHtml}
                                </li>
                            `);

                            $item.on('click', function () {
                                $("#name").val(user.name || '');
                                $("#email").val(user.email || '');
                                $("#phone_no").val(user.phone_no || '');
                                $("#company_name").val(user.company_name || '');
                                $("#country").val(user.country || '');
                                $("#state").val(user.state || '');
                                $("#city").val(user.city || '');
                                $("#pincode").val(user.pincode || '');
                                $("#address").val(user.address || '');
                                $("#reference").val(user.reference || '');

                                if (user.categories && Array.isArray(user.categories)) {
                                    const selectedCategoryIds = [];
                                    $("#categories option").each(function () {
                                        const optionText = $(this).text().trim();
                                        if (user.categories.includes(optionText)) {
                                            selectedCategoryIds.push($(this).val());
                                        }
                                    });
                                    $("#categories").val(selectedCategoryIds).trigger("change");
                                }

                                let companyTypeVal = null;
                                if (user.company_type) {
                                    $("#company_type option").each(function () {
                                        if ($(this).val() == user.company_type) {
                                            companyTypeVal = $(this).val();
                                        }
                                    });
                                }
                                $("#company_type").val(companyTypeVal).trigger("change");

                                $('#user_details').slideDown();
                                $('#submitBtn').addClass('d-none');
                                $('#updateBtn').removeClass('d-none').data('user-id', user.id);

                                const selectedText = user.name || user.email || user.phone_no || user.company_name;
                                const $select = $('.select2-container--open').prev('select');

                                if ($select.find(`option[value="${user.id}"]`).length === 0) {
                                    const newOption = new Option(selectedText, user.id, true);
                                    $select.append(newOption);
                                    $select.select2('destroy').select2();
                                }

                                $select.val(user.id).trigger('change.select2'); 
                                $select.select2('close');

                                const email = $("#email").val();
                                if (email) {
                                    $.ajax({
                                        url: '{{ route('user.mail.history') }}',
                                        type: 'GET',
                                        data: { email: email },
                                        success: function (response) {
                                            let tableBody = '';
                                            if (response.email.length > 0) {
                                                response.email.forEach(mail => {
                                                    tableBody += `
                                                        <tr>
                                                            <td>${mail.mail_sent_at}</td>
                                                           <td class="text-center"><span>${mail.subject}</span></td>
                                                            <td><i class="fa fa-eye show_message" style="color: #007bff;"></i></td>
                                                        </tr>
                                                        <tr class="message-row" style="display: none;">
                                                            <td colspan="3">
                                                                <div class="message-content" style="margin-top: 8px; padding: 10px; background: #f9f9f9; border: 1px solid #ccc; border-radius: 4px;">
                                                                    ${mail.mail_body}
                                                                </div>
                                                            </td>
                                                        </tr>`;
                                                });
                                                $('#example1 tbody').html(tableBody);
                                                $('.data').slideDown();
                                            } else {
                                                $('.data').hide();
                                            }
                                        }
                                    });
                                }
                            });

                            $resultsList.append($item);
                        });
                    },
                    error: function (xhr) {
                        console.error(xhr.responseText);
                    }
                });
            });
        }
    });

    observer.observe(document.body, {
        childList: true,
        subtree: true
    });
});
});

$("#submitBtn").on("click", function(e) {
    e.preventDefault();

    let form = document.getElementById('userForm');
    let formData = new FormData(form);

    $.ajax({
        url: "{{ route('data.store') }}",
        type: "POST",
        data: formData,
        processData: false,
        contentType: false,
        success: function(response) {
            $('#alert-placeholder').html(`
                <div class="alert alert-primary alert-dismissible fade show" role="alert" id="primary-alert">
                    <i class="fa fa-check-circle me-1"></i>
                    Users details saved successfully!
                </div>
            `);

            setTimeout(() => {
                $('#primary-alert').fadeOut();
            }, 2500);
            $('#user_details').hide();
        },
        error: function(xhr) {
            console.log(xhr.responseText);
        }
    });
});

    const updateUrlTemplate = "{{ route('data.update', ['id' => '__ID__']) }}";
    $("#updateBtn").on("click", function(e) {
        e.preventDefault();

        let userId = $(this).data('user-id');
        let updateUrl = updateUrlTemplate.replace('__ID__', userId);
        console.log(updateUrl);

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
                $('#alert-placeholder').html(`
                <div class="alert alert-success alert-dismissible fade show" role="alert" id="success-alert">
                    <i class="fa fa-check-circle me-1"></i>
                    Users details Updated successfully!
                </div>
            `);

            setTimeout(() => {
                $('#success-alert').fadeOut();
            }, 2500);
            $("#user_details").show();

            $('html, body').animate({
                scrollTop: $(".header").offset().top - 100 
            }, 500); 

            },
            error: function(xhr) {
                console.log("Update error:", xhr.responseText);
            },
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
                            $('#mail_template_details').slideDown();
                        }
                    }
                });
            } else {
                $('#mail_template_details').hide();
                $('#mail_subject').val('');
                $('#mail_message').summernote('code', '');
            }
        });

        $(document).on('click', '.show_message', function() {
            const $mainRow = $(this).closest('tr');
            const $messageRow = $mainRow.next('.message-row');
            $messageRow.toggle();
        });

    });
</script>

<script>
    $(function() {
        $('.select2').select2()
        $('.select2bs4').select2({
            theme: 'bootstrap4'
        });

        $('#mail_template').select2({
            placeholder: "Select a Mail Template",
            allowClear: false
        });

    })

    $(document).ready(function() {
        $("#example1").DataTable({
            "responsive": false,
            "lengthChange": false,
            "autoWidth": false,
            "paging": false,
            "searching": false,
            "ordering": false,
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
</style>
