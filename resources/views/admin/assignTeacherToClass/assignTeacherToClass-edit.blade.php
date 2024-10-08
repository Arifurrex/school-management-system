@extends('admin.layout')

@section('content')
<div class="content-wrapper">

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Edit Assign Teacher To Class</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
                        <li class="breadcrumb-item active">Edit Assign Teacher To Class</li>
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
                            <h3 class="card-title">Add Assign Teacher To Class</h3>
                        </div>


                        <form action="{{route('assignTeacherToClass.update',$assignTeacherToClass->id)}}" method="post">
                            @csrf
                            <div class="card-body">

                                @if (Session::has('success'))
                                <p class="alert alert-success">
                                    {{Session::get('success')}}
                                </p>
                                @endif

                                <div class="row">
                                    <div class="form-group col-md-12">
                                        <label for="exampleInputTeacher">Teacher</label>
                                        <select name="teacher_id" id="exampleInputTeacher" class="form-control">
                                            <option disabled>Select Teacher</option>
                                            @foreach ($teachers as $teacher )
                                            <option value="{{$teacher->id}}" {{$teacher->id  == $assignTeacherToClass->teacher_id ? 'selected' : null}}>{{$teacher->name}}</option>
                                            @endforeach

                                        </select>

                                        @error('class_id')
                                        <div>
                                            <p class="text-danger">{{$message }}</p>
                                        </div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- <div class="row">
                                    <div class="form-group col-md-12">
                                        <label for="exampleInputTeacher">Teacher</label>
                                        <select name="teacher_id" id="exampleInputTeacher" class="form-control">
                                            <option disabled selected>Select teacher</option>
                                            <option value="{{$assignTeacherToClass->teacher->id}}" {{$assignTeacherToClass->teacher->id == $assignTeacherToClass->teacher_id ? 'selected' : null }}> {{$assignTeacherToClass->teacher->name}}</option>
                                        </select>

                                        @error('teacher_id')
                                        <div>
                                            <p class="text-danger">{{$message }}</p>
                                        </div>
                                        @enderror
                                    </div>
                                </div> -->
                                <div class="row">
                                    <div class="form-group col-md-12">
                                        <label for="exampleInputClass">Class</label>
                                        <select name="class_id" id="exampleInputClass" class="form-control">
                                            <option disabled>Select class</option>
                                            @foreach ($academicClass as $acaClass )
                                            <option value="{{$acaClass->id}}" {{$acaClass->id  == $assignTeacherToClass->class_id ? 'selected' : null}}>{{$acaClass->name}}</option>
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
                                    <div class="form-group col-md-12">
                                        <label for="exampleInputSubject2">subject</label>
                                        <select name="subject_id" id="exampleInputSubject2" class="form-control">
                                            <option disabled>Select subject</option>
                                            @foreach ($assaignSubjectToClass as $assSubToCla )
                                            <option value="{{$assSubToCla->subject_id}}"

                                                {{$assSubToCla->subject_id  == $assignTeacherToClass->subject_id ? 'selected' : null}}>

                                                {{$assSubToCla->subjects->name}}

                                            </option>
                                            @endforeach

                                        </select>

                                        @error('class_id')
                                        <div>
                                            <p class="text-danger">{{$message }}</p>
                                        </div>
                                        @enderror
                                    </div>
                                </div>


                                <!-- <div class="row">
                                    <div class="form-group col-md-12">
                                        <label for="exampleInputSubject">subject1</label>
                                        <select name="class_id" id="exampleInputSubject" class="form-control">
                                            <option disabled>Select subject</option>
                                            @foreach ($subjects as $subject )
                                            <option value="{{$subject->id}}" {{$subject->id  == $assignTeacherToClass->subject_id ? 'selected' : null}}>{{$subject->name}}</option>
                                            @endforeach

                                        </select>

                                        @error('class_id')
                                        <div>
                                            <p class="text-danger">{{$message }}</p>
                                        </div>
                                        @enderror
                                    </div> -->
                            </div>

                            <div class="row" id="subjectsContainer">

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

<!-- httpRequest ajax apply -->
<script>
    var classSelect = document.getElementById('exampleInputClass');
    var subjectsContainer = document.getElementById('exampleInputSubject2');

    classSelect.addEventListener('change', function() {
        var classId = this.value;

        if (classId) {
            dataFetchEdit(classId);
        } else {
            subjectsContainer.innerHTML = '';
        }

    });

    function dataFetchEdit(classId) {
        var xhr = new XMLHttpRequest();
        xhr.open('GET', `/admin/assignTeacherToClass/fetchSubjectsEdit?class_id=${classId}`, true);
        xhr.onload = function() {
            if (xhr.status === 200) {
                var data = JSON.parse(xhr.responseText);
                subjectsContainer.innerHTML = data.html;
            }
        };
        xhr.send();
    };
</script>

@endsection
