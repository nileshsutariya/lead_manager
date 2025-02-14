@include('layouts.header')

<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card card-default m-3">
                <div class="card-header" style="background-color: rgb(249, 248, 252)">
                    <h1 class="card-title" style="font-size: 20px">{{ isset($data) ? 'Edit Data' : 'User Data' }}</h1>
                </div>
                <form method="post" action="{{ isset($data) ? route('data.update', $data->id) : route('data.store') }}">
                    @csrf
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name">Name</label>
                                    <input type="text" class="form-control" name="name" id="name" value="{{ old('name', isset($data) ? $data->name : '') }}">
                                    @error('name')
                                        <div class="text-danger">*{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="phone">Phone No</label>
                                    <input type="text" class="form-control" name="phone" id="phone" value="{{ old('phone', isset($data) ? $data->phone_no : '') }}">
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
                                    <input type="email" class="form-control" name="email" id="email" value="{{ old('email', isset($data) ? $data->email : '') }}">
                                    @error('email')
                                        <div class="text-danger">*{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="address">Address</label>
                                    <input type="text" class="form-control" name="address" id="address" value="{{ old('address', isset($data) ? $data->address : '') }}">
                                    @error('address')
                                        <div class="text-danger">*{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="city">City</label>
                                    <input type="text" class="form-control" name="city" id="city" value="{{ old('city', isset($data) ? $data->city : '') }}">
                                    @error('city')
                                        <div class="text-danger">*{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="state">State</label>
                                    <input type="text" class="form-control" name="state" id="state" value="{{ old('state', isset($data) ? $data->state : '') }}">
                                    @error('state')
                                        <div class="text-danger">*{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="pincode">Pincode</label>
                                    <input type="text" class="form-control" name="pincode" id="pincode" value="{{ old('pincode', isset($data) ? $data->pincode : '') }}">
                                    @error('pincode')
                                        <div class="text-danger">*{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="country">Country</label>
                                    <input type="text" class="form-control" name="country" id="country" value="{{ old('country', isset($data) ? $data->country : '') }}">
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
                                    <input type="text" class="form-control" name="company_name" id="company_name" value="{{ old('company_name', isset($data) ? $data->company_name : '') }}">
                                    @error('company_name')
                                        <div class="text-danger">*{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="designation">Designation</label>
                                    <input type="text" class="form-control" name="designation" id="designation" value="{{ old('designation', isset($data) ? $data->designation : '') }}">
                                    @error('designation')
                                        <div class="text-danger">*{{ $message }}</div>
                                    @enderror
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
</div>

@include('layouts.footer')
