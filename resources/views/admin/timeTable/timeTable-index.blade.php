@extends('admin.layout')

@section('customcss')
<link rel="stylesheet" href="plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
<link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
@endsection
@section('content')
<div class="content-wrapper">

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>timeTable</h1>
                    @if (Session::has('success'))
                    <p class="alert alert-success">
                        {{Session::get('success')}}
                    </p>
                    @endif
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
                        <li class="breadcrumb-item active"><a href="{{route('assignTeacherToClass.index')}}">timeTable</a></li>
                    </ol>
                </div>
            </div>
    </section>

    <section class="content mb-2">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <form action="{{route('timeTable.index')}}" method="get">
                        @csrf
                        <div class="row d-flex justify-content-center align-items-center border">
                            <div class="form-group col-md-3">
                                <label for="exampleInputClass">Class</label>
                                <select name="class_id" id="exampleInputClass" class="form-control">
                                    <option disabled selected>Select what class</option>
                                    @foreach ($classes as $class )
                                    <option value="{{$class->id}}" {{$class->id == request('class_id') ? 'selected' : null}}>{{$class->name}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group col-md-3">
                                <label for="subjectsContainer">subject</label>
                                <select name="subject_id" id="subjectsContainer" class="form-control">
                                    <option value="" disabled selected>Select subject</option>
                                    @foreach ($subjects as $subject )
                                    <option value="{{$subject->id}}" {{$subject->id == request('subject_id') ? 'selected' : ''}}>{{$subject->name}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-3 d-flex justify-content-center align-items-center">
                                <button type="submit" class="btn btn-primary">Filter Data</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">


                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">DataTable with default features</h3>
                        </div>

                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Day</th>
                                        <th>Class</th>
                                        <th>Subject</th>
                                        <th>Start Time</th>
                                        <th>End Time</th>
                                        <th>Room no</th>
                                        <th>create time</th>
                                        <th>Edit</th>
                                        <th>Delete</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($timeTable as $data )
                                    <tr>
                                        <td>{{$data->id}}</td>
                                        <td>{{ optional($data->day)->name}}</td>
                                        <td>{{ optional($data->academicClasses)->name}}</td>
                                        <td>{{ optional($data->subjects)->name}}</td>
                                        <td>{{ $data->start_time}}</td>
                                        <td>{{ $data->end_time}}</td>
                                        <td>{{ $data->room_no}}</td>
                                        <td>{{\Carbon\Carbon::parse($data->created_at)->diffForHumans();}}</td>
                                        <td><a href="{{route('timeTable.edit',$data->id)}}" class="btn btn-primary">Edit</a></td>
                                        <td><a href="{{route('timeTable.delete',$data->id)}}" onclick="return confirm('are you sure for delete it !')" class="btn btn-danger">Delete</a></td>
                                    </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>ID</th>
                                        <th>Day</th>
                                        <th>Class</th>
                                        <th>Subject</th>
                                        <th>Start Time</th>
                                        <th>End Time</th>
                                        <th>Room no</th>
                                        <th>create time</th>
                                        <th>Edit</th>
                                        <th>Delete</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>

                    </div>

                </div>

            </div>

        </div>

    </section>

</div>
@endsection

@section('customJs')


<script src="plugins/datatables/jquery.dataTables.min.js"></script>
<script src="plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="plugins/jszip/jszip.min.js"></script>
<script src="plugins/pdfmake/pdfmake.min.js"></script>
<script src="plugins/pdfmake/vfs_fonts.js"></script>
<script src="plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="plugins/datatables-buttons/js/buttons.colVis.min.js"></script>

<script src="dist/js/adminlte.min2167.js?v=3.2.0"></script>

<script>
    $(function() {
        $("#example1").DataTable({
                "responsive": true, // টেবিলকে রেস্পন্সিভ করে তোলে যাতে এটি ছোট স্ক্রিনেও ঠিক মতো দেখা যায়।
                "lengthChange": false, // ড্রপডাউন থেকে পেজের row সংখ্যা পরিবর্তন করার অপশন নিষ্ক্রিয় করে।
                "autoWidth": false, // স্বয়ংক্রিয়ভাবে টেবিলের কলামগুলোর প্রস্থ সেট না করতে বলে।
                "buttons": [ // ডাটাটেবিলে কিছু button যোগ করে, যেমন:
                    "copy", // টেবিলের ডেটা কপি করার button।
                    "csv", // CSV ফরম্যাটে ডেটা এক্সপোর্ট করার button।
                    "excel", // Excel ফাইলে ডেটা এক্সপোর্ট করার button।
                    "pdf", // PDF ফরম্যাটে ডেটা এক্সপোর্ট করার button।
                    "print", // টেবিলের ডেটা প্রিন্ট করার জন্য button।
                    "colvis" // টেবিলের কলামগুলো হাইড/শো করার জন্য কলাম ভিজিবিলিটি অপশন।
                ]
            })
            .buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
            // buttonগুলোকে টেবিলের নির্দিষ্ট স্থানে অ্যাপেন্ড করে (অর্থাৎ সেই বোতামগুলোকে পজিশনিং করে নির্দিষ্ট একটি ডিভে দেখানো হয়)।


        $('#example2').DataTable({
            "paging": true, // টেবিলে পেজিনেশন (অর্থাৎ পেজের সংখ্যা যোগ করা) সক্রিয় করে।
            "lengthChange": false, // ড্রপডাউন থেকে পেজের row সংখ্যা পরিবর্তন করার অপশন নিষ্ক্রিয়।
            "searching": false, // সার্চ ফিচার নিষ্ক্রিয় করে।
            "ordering": true, // কলাম অনুযায়ী টেবিলের ডেটা সাজানোর (অর্ডার) সুবিধা দেয়।
            "autoWidth": false, // কলামের প্রস্থ স্বয়ংক্রিয়ভাবে সেট না করা।
            "responsive": true, // টেবিলকে রেস্পন্সিভ করে তোলে।
        })
    });
</script>
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
