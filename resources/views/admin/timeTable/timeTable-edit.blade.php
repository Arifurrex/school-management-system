@extends('admin.layout')

@section('content')
<div class="content-wrapper">

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Edit timeTable</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
                        <li class="breadcrumb-item active">timeTable Edit</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">

                <div class="col-md-12 mx-auto">

                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Edit timeTable</h3>
                        </div>


                        <form action="{{route('timeTable.update',$timeTable->id)}}" method="post">
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
                                            @foreach ($classes as $class )
                                            <option value="{{$class->id}}" {{ $class->id == $timeTable->class_id ? 'selected' : null }}>{{$class->name}}</option>
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
                                        <label for="subjectsContainer">subject</label>
                                        <select name="subject_id" id="subjectsContainer" class="form-control">
                                            <option disabled selected>Select subject</option>
                                            @foreach ($subjects as $subject )
                                            <option value="{{$subject->id}}" {{ $subject->id == $timeTable->subject_id ? 'selected' : null}}>{{$subject->name}}</option>
                                            @endforeach
                                        </select>

                                        @error('subject_id')
                                        <div>
                                            <p class="text-danger">{{$message }}</p>
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-12">
                                        <table id="example1" class="table table-bordered table-striped">
                                            <thead>
                                                <tr>
                                                    <th>Day</th>
                                                    <th>Start time</th>
                                                    <th>End time</th>
                                                    <th>Room Number</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>
                                                        <input type="text" name="day_id" value="{{old('day_id',$timeTable->day->name)}}">
                                                    </td>

                                                    <td>
                                                        <input type="time" name="start_time" value="{{old('start_time',$timeTable->start_time)}}">
                                                    </td>

                                                    <td>
                                                        <input type="time" name="end_time" id="" value="{{old('end_time',$timeTable->end_time)}}">
                                                    </td>

                                                    <td>
                                                        <input type="number" name="room_no" placeholder="room number" value="{{old('room_no',$timeTable->room_no)}}">
                                                    </td>
                                                </tr>
                                            </tbody>
                                    </div>
                                    </table>
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
    var subjectsContainer = document.getElementById('subjectsContainer');

    classSelect.addEventListener('change', function() {
        var classId = this.value;

        if (classId) {
            dataFetch(classId);
        } else {
            subjectsContainer.innerHTML = '';
        }

    });

    function dataFetch(classId) {
        var xhr = new XMLHttpRequest();
        xhr.open('GET', `/admin/timeTable/fetchSubjects?class_id=${classId}`, true);
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
