@extends('admin.layout')

@section('content')
<div class="content-wrapper">

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Academic year</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
                        <li class="breadcrumb-item active">academic year</li>
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
                            <h3 class="card-title">Add academic year</h3>
                        </div>


                        <form action="{{route('academic-year.store')}}" method="post">
                            @csrf
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">academic year</label>
                                    @if (Session::has('success'))
                                    <p class="alert alert-success">
                                        {{Session::get('success')}}
                                    </p>
                                    @endif
                                    <input type="text" name="name" class="form-control" id="exampleInputEmail1" placeholder="Enter academic year">
                                    @error('name')
                                    <div>
                                        <p class="text-danger">{{$message }}</p>
                                    </div>
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
