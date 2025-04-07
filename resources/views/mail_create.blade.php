@include('layouts.header')

<section class="content-header">
    <div class="container-fluid">
        <div class="row mt-1">
            <div class="col-md-12 text-center text-md-left">
                <h1>Mail Create</h1>
            </div>
        </div>

        <div class="card m-1">
            <div class="card-body">
                <div class="mb-3 position-relative">
                    <label for="user_search">Search User</label>
                    <input type="text" class="form-control" id="user_search" name="user_search"
                        placeholder="Search by name, email...">
                    <input type="hidden" id="user_id" name="user_id">
                    <div id="search_results" class="list-group position-absolute w-100 mt-1 bg-white border shadow"
                        style="z-index: 1000; display: none;"></div>
                </div>

                <form id="userForm" method="POST">
                    @csrf
                    <input type="hidden" id="user_id" name="user_id">
                    <div id="user_details" style="display: none;">
                        <div class="row">
                            <div class="col-md-3 mb-3">
                                <label>Name</label>
                                <input type="text" class="form-control" id="name" name="name">
                            </div>

                            <div class="col-md-3 mb-3">
                                <label>Email</label>
                                <input type="email" class="form-control" id="email" name="email">
                            </div>

                            <div class="col-md-3 mb-3">
                                <label>Phone</label>
                                <input type="text" class="form-control" id="phone_no" name="phone">
                            </div>

                            <div class="col-md-3 mb-3">
                                <label>Company</label>
                                <input type="text" class="form-control" id="company_name" name="company_name">
                            </div>

                            <div class="col-md-3 mb-3">
                                <label>Company Type</label>
                                <select class="form-control select2" id="company_type" name="company_type"
                                    style="width: 100%;">
                                    <option value="">Select a Company Type</option>
                                    @foreach ($companies as $id => $name)
                                        <option value="{{ $id }}">{{ $name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-3 mb-3">
                                <label>Country</label>
                                <input type="text" class="form-control" id="country" name="country">
                            </div>

                            <div class="col-md-3 mb-3">
                                <label>State</label>
                                <input type="text" class="form-control" id="state" name="state">
                            </div>

                            <div class="col-md-3 mb-3">
                                <label>City</label>
                                <input type="text" class="form-control" id="city" name="city">
                            </div>
                            <div class="col-md-3 mb-3">
                                <div class="select2-primary">
                                    <label for="categories">Categories</label>
                                    <select class="select2" multiple="multiple" data-placeholder="Select a Category"
                                        data-dropdown-css-class="select2-primary" style="height: 44px" id="categories"
                                        name="category[]">
                                        @foreach ($categories as $id => $name)
                                            <option value="{{ $id }}">
                                                {{ $name }}
                                            </option>
                                        @endforeach
                                    </select>

                                </div>
                            </div>

                            <div class="col-md-3 mb-3">
                                <label>Pincode</label>
                                <input type="text" class="form-control" id="pincode" name="pincode">
                            </div>

                            <div class="col-md-3 mb-3">
                                <label>Address</label>
                                <input type="text" class="form-control" id="address" name="address">
                            </div>

                            <div class="col-md-3 mb-3">
                                <label>Reference</label>
                                <input type="text" class="form-control" id="reference" name="reference">
                            </div>
                        </div>

                        <div class="text-right">
                            <button type="button" id="submitBtn" class="btn btn-primary">Submit</button>
                            <button type="button" id="updateBtn" class="btn btn-success d-none">Update</button>
                        </div>
                    </div>
                </form>

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
                        <input type="text" class="form-control" id="mail_subject" name="mail_subject">
                    </div>

                    <div class="mb-3">
                        <label for="mail_message">Message</label>
                        <textarea class="form-control" id="mail_message" name="mail_message"></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="attachments">Attachments</label>
                        <input type="file" class="form-control" id="attachments" name="attachments[]" multiple>
                    </div>
                </div>

                <div class="card-footer mt-2 text-right">
                    <button type="submit" class="btn btn-primary">Send Mail</button>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
$(document).ready(function() {
    let userSearchInput = document.querySelector("#user_search");
    let tagify = new Tagify(userSearchInput, {
        maxTags: 5,
        dropdown: {
            enabled: 3,
            maxItems: 10
        }
    });

    tagify.on("input", function(e) {
        let query = e.detail.value;

        if (query.length > 2) {
            $.ajax({
                url: "{{ route('users.search') }}",
                type: "GET",
                data: { query: query },
                success: function(response) {
                    if (response.length > 0) {
                        tagify.settings.whitelist = response.map(user => ({
                            value: user.name || user.email || user.phone_no || user.company_name,
                            id: user.id,
                            email: user.email,
                            name: user.name,
                            phone: user.phone_no,
                            company_name: user.company_name,
                            company_type: user.company_type,
                            country: user.country,
                            state: user.state,
                            city: user.city,
                            categories: user.category_names,
                            pincode: user.pincode,
                            address: user.address,
                            reference: user.reference
                        }));
                        tagify.dropdown.show();
                    } else {
                        resetUserFields();
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
    });

    tagify.on("remove", function(e) {
        let remainingUsers = tagify.value;

        if (remainingUsers.length > 0) {
            let latestUser = remainingUsers[remainingUsers.length - 1];
            populateUserFields(latestUser); 
        } else {
            resetUserFields(); 
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
</style>
