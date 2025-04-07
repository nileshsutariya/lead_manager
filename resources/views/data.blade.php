@include('layouts.header')

<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card card-default m-3">
                <div class="card-header" style="background-color: rgb(249, 248, 252)">
                    <h1 class="card-title" style="font-size: 20px">{{ isset($data) ? 'Edit Users' : 'Users' }}</h1>
                </div>
                <form method="post" action="{{ isset($data) ? route('data.update', $data->id) : route('data.store') }}">
                    @csrf
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name">Name</label>
                                    <input type="text" class="form-control" name="name" id="name"
                                        value="{{ old('name', isset($data) ? $data->name : '') }}">
                                    @error('name')
                                        <div class="text-danger">*{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="phone">Phone No</label>
                                    <input type="text" class="form-control" name="phone" id="phone"
                                        value="{{ old('phone', isset($data) ? $data->phone_no : '') }}">
                                    @error('phone')
                                        <div class="text-danger">*{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="email" class="form-control" name="email" id="email"
                                        value="{{ old('email', isset($data) ? $data->email : '') }}">
                                    @error('email')
                                        <div class="text-danger">*{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="address">Address</label>
                                    <input type="text" class="form-control" name="address" id="address"
                                        value="{{ old('address', isset($data) ? $data->address : '') }}">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="city">City</label>
                                    <input type="text" class="form-control" name="city" id="city"
                                        value="{{ old('city', isset($data) ? $data->city : '') }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="state">State</label>
                                    <input type="text" class="form-control" name="state" id="state"
                                        value="{{ old('state', isset($data) ? $data->state : '') }}">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="pincode">Pincode</label>
                                    <input type="text" class="form-control" name="pincode" id="pincode"
                                        value="{{ old('pincode', isset($data) ? $data->pincode : '') }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="country">Country</label>
                                    <input type="text" class="form-control" name="country" id="country"
                                        value="{{ old('country', isset($data) ? $data->country : '') }}">
                                    @error('country')
                                        <div class="text-danger">*{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="company_name">Company Name</label>
                                    <input type="text" class="form-control" name="company_name" id="company_name"
                                        value="{{ old('company_name', isset($data) ? $data->company_name : '') }}">
                                    @error('company_name')
                                        <div class="text-danger">*{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="designation">Referance</label>
                                    <input type="text" class="form-control" name="reference" id="refernce"
                                        value="{{ old('reference', isset($data) ? $data->reference : '') }}">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Company Type</label>
                                    <select class="form-control" name="company_type" style="height: 44px">
                                        <option value="">Select a Company Type</option>
                                        @foreach ($companies as $id => $name)
                                            <option value="{{ $id }}"
                                                {{ isset($data) && (string) $data->company_type === (string) $id ? 'selected' : '' }}>
                                                {{ $name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label for="categories">Categories</label>
                                <div class="select2-primary">
                                    <select class="select2" multiple="multiple" data-placeholder="Select a Category"
                                        data-dropdown-css-class="select2-primary" style="width: 100%;" id="category"
                                        name="category[]">
                                        <option value="">Select a Categories</option>
                                        @foreach ($categories as $id => $name)
                                            <option value="{{ $id }}"
                                                {{ isset($data) && in_array($id, json_decode($data->categories ?? '[]', true)) ? 'selected' : '' }}>
                                                {{ $name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mt-4 ml-3 align-items-right">
                                <input type="checkbox" class="form-check-input" id="status" name="status"
                                    value="1" {{ old('status', $data->status ?? 0) == 1 ? 'checked' : '' }}>
                                <label class="form-check-label ml-2" for="status" style="font-size: 18px;">
                                    Is Active
                                </label>
                            </div>
                        </div>
                    </div>
            </div>

            <div class="card-footer">
                <button type="submit" class="btn btn-primary col-md-2">Submit</button>
            </div>
            </form>
        </div>
    </div>
</div>

<script>
    $(function() {
        //Initialize Select2 Elements
        $('.select2').select2()

        //Initialize Select2 Elements
        $('.select2bs4').select2({
            theme: 'bootstrap5'
        })
    });
</script>

@include('layouts.footer')
