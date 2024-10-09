@extends('admin.layout')

@section('content')
<div class="content-wrapper">

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>timeTable</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
                        <li class="breadcrumb-item active">timeTable</li>
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
                            <h3 class="card-title">Add timeTable</h3>
                        </div>


                        <form action="{{route('timeTable.store')}}" method="post">
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
                                    <div class="form-group col-md-12">
                                        <label for="subjectsContainer">subject</label>
                                        <select name="subject_id" id="subjectsContainer" class="form-control">
                                            <option disabled selected>Select subject</option>
                                            @foreach ($subjects as $subject )
                                            <option value="{{$subject->id}}">{{$subject->name}}</option>
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
                                                @php
                                                $i=1;
                                                @endphp
                                                @foreach ($days as $day)
                                                <tr>
                                                    <td>{{$day->name}}</td>
                                                    <input type="hidden" name="timeTable[{{$i}}][day_id]" value="{{$day->id}}">
                                                    <td><input type="time" name="timeTable[{{$i}}][start_time]"></td>
                                                    <td><input type="time" name="timeTable[{{$i}}][end_time]" id=""></td>
                                                    <td><input type="number" name="timeTable[{{$i}}][room_no]" placeholder="room number"></td>
                                                </tr>
                                                @php
                                                $i++;
                                                @endphp
                                                @endforeach
                                            </tbody>
                                            <!-- "timeTable" => [
                                                    1 => [  // ১ম দিনের জন্য ইনপুট ডেটা
                                                        "day_id" => 1,       // ১ম দিনের ID
                                                        "start_time" => "08:00", // শুরু সময়
                                                        "end_time" => "10:00",   // শেষ সময়
                                                        "room_no" => 101         // রুম নম্বর
                                                    ],
                                                    2 => [  // ২য় দিনের জন্য ইনপুট ডেটা
                                                        "day_id" => 2,
                                                        "start_time" => "10:00",
                                                        "end_time" => "12:00",
                                                        "room_no" => 102
                                                    ]
                                                    // এভাবে ৩য়, ৪র্থ, ... ৭ম দিনের জন্য ডেটা
                                            ] -->
                                    </div>
                                    </table>
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
