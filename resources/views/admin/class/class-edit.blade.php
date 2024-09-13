@extends('admin.layout')

@section('content')
<div class="content-wrapper">

<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>classes edit</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
          <li class="breadcrumb-item active">classes edit</li>
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
            <h3 class="card-title">Edit classes</h3>
          </div>


          <form action="{{route('class.update',$classes->id)}}" method="post"> 
            @csrf
            <div class="card-body">
              <div class="form-group">
                <label for="exampleInputEmail1">classes</label>
                @if (Session::has('success'))
                 <p class="alert alert-success">
                  {{Session::get('success')}}
                 </p>
                @endif
                <input type="text" name="name" class="form-control" value="{{ old('name', $classes->name) }}" id="exampleInputEmail1" placeholder="Enter classes">
                @error('name')
                <div>
                    <p class="text-danger">{{$message }}</p>
                </div>
                @enderror
              </div>
            </div>

            <div class="card-footer">
              <button type="submit" class="btn btn-primary">update class</button>
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
$(function () {
  bsCustomFileInput.init();
});
</script>
@endsection
