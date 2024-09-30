@extends('admin.layout')

@section('content')
<div class="content-wrapper">

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Assign Subject To Class</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
                        <li class="breadcrumb-item active">Assign Subject To Class</li>
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


                        <form action="{{route('assignSubjectToClass.store')}}" method="post">
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
                                            <option disabled selected>Select what class</option>
                                            @foreach ($classes as $class )
                                            <option value="{{$class->id}}">{{$class->name}}</option>
                                            @endforeach
                                        </select>

                                        @error('class_id')
                                        <div>
                                            <p class="text-danger">{{$message }}</p>
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row">
                                    @foreach ($subjects as $subject)
                                    <div class="form-group col-md-12">
                                        <input type="checkbox" id="subject-{{$subject->id}}" name="subjects_ids[]" value="{{$subject->id}}">
                                        <label for="subject-{{$subject->id}}">{{$subject->name}}</label>
                                    </div>
                                    @endforeach

                                    @error('subjects_ids')
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
