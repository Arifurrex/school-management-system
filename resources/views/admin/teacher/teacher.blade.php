@extends('admin.layout')

@section('content')
<div class="content-wrapper">

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>teacher management</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
                        <li class="breadcrumb-item active">teacher management</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">

                <div class="col-md-12">

                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Add teacher</h3>
                        </div>
                        <form action="{{route('teacher.store')}}" method="post">
                            @csrf
                            <div class="card-body">
                                @if (Session::has('success'))
                                <p class="alert alert-success">
                                    {{Session::get('success')}}
                                </p>
                                @endif


                                <div class="row">
                                    <div class="form-group col-md-4">
                                        <label for="exampleInputJanuary">Teacher Name</label>
                                        <input type="" name="name" class="form-control" id="exampleInputJanuary" placeholder="Enter teacher name">
                                        @error('name')
                                        <div>
                                            <p class="text-danger">{{$message}}</p>
                                        </div>
                                        @enderror
                                    </div>

                                    <div class="form-group col-md-4">
                                        <label for="exampleInputJanuary">Teacher Father Name</label>
                                        <input type="" name="father_name" class="form-control" id="exampleInputJanuary" placeholder="Enter teacher father name">
                                        @error('father_name')
                                        <div>
                                            <p class="text-danger">{{$message}}</p>
                                        </div>
                                        @enderror
                                    </div>


                                    <div class="form-group col-md-4">
                                        <label for="exampleInputFebruary">teacher Mother Name</label>
                                        <input type="text" name="mother_name" class="form-control" id="exampleInputFebruary" placeholder="Enter mother name">
                                        @error('mother_name')
                                        <div>
                                            <p class="text-danger">{{$message }}</p>
                                        </div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-md-4">
                                        <label for="exampleInputAcademicYear">Date of birth</label>
                                        <input type="date" name="dob" class="form-control">
                                        @error('dob')
                                        <div>
                                            <p class="text-danger">{{$message }}</p>
                                        </div>
                                        @enderror
                                    </div>

                                    <div class="form-group col-md-4">
                                        <label for="exampleInputEmail1">mobile number</label>
                                        <input type="text" name="mobile_no" class="form-control" id="exampleInputApril" placeholder="Enter your mobile number">
                                        @error('mobile_no')
                                        <div>
                                            <p class="text-danger">{{$message }}</p>
                                        </div>
                                        @enderror
                                    </div>

                                    <div class="form-group col-md-4">
                                        <label for="exampleInputEmail1">Email</label>
                                        <input type="text" name="email" class="form-control" id="exampleInputMay" placeholder="Enter your email">
                                        @error('email')
                                        <div>
                                            <p class="text-danger">{{$message }}</p>
                                        </div>
                                        @enderror
                                    </div>

                                    <div class="form-group col-md-4">
                                        <label for="exampleInputEmail1">Create password</label>
                                        <input type="text" name="password" class="form-control" id="exampleInputJune" placeholder="Enter password">
                                        @error('password')
                                        <div>
                                            <p class="text-danger">{{$message }}</p>
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </form>
                    </div>

                </div>

            </div>

        </div>
    </section>

</div>
@endsection

@section('customJs')
<script src="../../plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>
<script>
    $(function() {
        bsCustomFileInput.init();
    });
</script>
@endsection
