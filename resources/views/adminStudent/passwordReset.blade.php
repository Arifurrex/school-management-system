@extends('adminStudent.layout')

@section('content')
<div class="content-wrapper">

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>General Form</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Password Reset</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">

                <div class="col-md-6 mx-auto">

                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Reset your password</h3>
                        </div>
                        @if (Session::has('success'))
                        <p class="alert alert-success">
                            {{Session::get('success')}}
                        </p>
                        @endif

                        @if (Session::has('error'))
                        <p class="alert alert-danger">
                            {{Session::get('error')}}
                        </p>
                        @endif


                        <form action="{{route('adminStudent.passwordReset.store')}}" method="post">
                            @csrf
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="oldPass">Old Password</label>
                                    <input class="form-control" name="oldPass" id="oldPass" placeholder="Password" type="password">
                                </div>
                                <div class="form-group">
                                    <label for="newPass">New Password</label>
                                    <input type="password" class="form-control" id="newPass" placeholder="Password" name="newPass">
                                    @error('newPass')
                                    <p class="text-danger">{{$message}}</p>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="confirmPass">Confirm Password</label>
                                    <input type="password" class="form-control" id="confirmPass" placeholder="Password" name="confirmPass">
                                    @error('confirmPass')
                                    <p class="text-danger">{{$message}}</p>
                                    @enderror
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
