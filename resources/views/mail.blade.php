@include('layouts.header')

<div class="container-fluid">
    <div class="content-header mb-1 ">
        <h3 class="fw-bold">
            <i class="nav-icon fa fa-envelope text-primary me-2"></i> E-mail
        </h3>
    </div>
    <div class="card col-md-12">
        <div class="card-body p-4 ">
            <form method="POST" action="{{ isset($email) ? route('mail.update', $email->id) : route('mail.store') }}"
                enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label for="name" class="form-label fw-semibold">Name</label>
                    <input type="text" class="form-control" id="name" name="name"
                        placeholder="Enter your name" value="{{ old('name', isset($email) ? $email->name : '') }}">
                    @error('name')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="message" class="form-label fw-semibold">Body</label>
                    <textarea class="form-control" id="message" name="message" placeholder="Write your message here...">
                        {{ old('message', isset($email) ? $email->message : '') }}
                    </textarea>
                    @error('message')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="attachment" class="form-label fw-semibold">Attachment</label>
                
                    <!-- Hidden Input to Store Existing File -->
                    @if(isset($email->attachment))
                    <div class="mb-2">
                        <p>Current File: <span class="text-primary">{{ $email->attachment->name }}</span></p>
                    </div>
                    @endif
                
                    <input type="file" class="form-control border rounded-2 p-2" id="attachment" name="attachments">
                </div>

                <div class="mb-3">
                    <input type="checkbox" class="form-check-input" id="status" name="status" value="1"
                        {{ old('status', $email->status ?? 0) == 1 ? 'checked' : '' }}>
                    <label class="form-check-label ml-1" for="status" style="font-size: 18px;">Is Active</label>
                </div>

                <div class="card-footer mt-2 col-sm-12">
                    <button type="submit" class="btn btn-primary">submit</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#message').summernote({
            placeholder: 'Write your message here...',
            tabsize: 2,
            height: 150,
            toolbar: [
                ['style', ['bold', 'italic', 'underline', 'clear']],
                ['font', ['strikethrough', 'superscript', 'subscript']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['insert', ['link', 'picture', 'video']],
                ['view', ['codeview']]
            ]
        });
    });

    let existingContent = $('#message').text();
    $('#message').summernote('code', existingContent);
</script>


@include('layouts.footer')

<style>
    .card {
        box-shadow: 5px 5px 10px rgb(231, 231, 231);
    }
</style>
