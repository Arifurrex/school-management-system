@extends('admin.layout')

@section('content')
<div class="content-wrapper">

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Announcement Form</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{route('announcement.index')}}">Announcement list</a></li>

                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">

                <div class="col-md-8 mx-auto">

                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">announcement edit</h3>
                        </div>


                        <form action="{{route('announcement.update',$announcement->id)}}" method="post">
                            @csrf

                            @if (Session::has('success'))
                            <p class="alert alert-success">
                                {{Session::get('success')}}
                            </p>
                            @endif
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="announcement">Edit announcement</label>
                                    <input type="text" name="message" value="{{old('message',$announcement->message)}}" class="form-control" id="announcement" placeholder="Enter announcement">
                                    @error('message')
                                    <p class="danger text-danger">{{$message}}</p>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label class="sr-only" for="exampleInputClass">Class</label>
                                    <select name="type" id="exampleInputClass" class="form-control">
                                        <option value="teacher"{{$announcement->type == 'teacher' ? 'selected' : ""}}>teacher</option>
                                        <option value="student" {{$announcement->type == 'student' ? 'selected' : ""}}>student</option>
                                        <option value="parent" {{$announcement->type == 'parent' ? 'selected' : ""}}>parent</option>
                                    </select>
                                    @error('type')
                                    <p class="danger text-danger">{{$message}}</p>
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
