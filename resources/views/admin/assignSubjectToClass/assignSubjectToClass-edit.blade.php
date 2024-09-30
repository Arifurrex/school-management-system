@extends('admin.layout')

@section('content')
<div class="content-wrapper">

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Edit Assign Subject To Class</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
                        <li class="breadcrumb-item active">Edit Assign Subject To Class</li>
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
                            <h3 class="card-title">Add Assign Subject To Class</h3>
                        </div>


                        <form action="{{route('assignSubjectToClass.update',$assignSubjectToClass->id)}}" method="post">
                            @csrf
                            <div class="card-body">
                                @if (Session::has('success'))
                                <p class="alert alert-success">
                                    {{Session::get('success')}}
                                </p>
                                @endif
                                <div class="row">
                                    <div class="form-group col-md-12">
                                        <label for="exampleInputClass">Class</label>
                                        <select name="class_id" id="exampleInputClass" class="form-control">
                                            <option disabled>Select what class</option>
                                            <option value="{{$assignSubjectToClass->class_id}}" {{$assignSubjectToClass->class_id == $assignSubjectToClass->academicClasses->id ? 'selected' : null}}>{{$assignSubjectToClass->academicClasses->name}}</option>

                                        </select>

                                        @error('class_id')
                                        <div>
                                            <p class="text-danger">{{$message }}</p>
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-12">
                                        <label for="exampleInputClass">Subject</label>
                                        <select name="subject_id" id="exampleInputClass" class="form-control">
                                            <option disabled>Select subject</option>
                                            @foreach ($subjects as $subject )
                                            <option value="{{$subject->id}}" {{$subject->id  == $assignSubjectToClass->subject_id ? 'selected' : null}}>{{$subject->name}}</option>
                                            @endforeach

                                        </select>

                                        @error('class_id')
                                        <div>
                                            <p class="text-danger">{{$message }}</p>
                                        </div>
                                        @enderror
                                    </div>
                                </div>

                            </div>

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Update</button>
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
