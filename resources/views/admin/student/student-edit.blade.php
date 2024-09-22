@extends('admin.layout')

@section('content')
<div class="content-wrapper">

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>student management</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
                        <li class="breadcrumb-item active">Edit student information</li>
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
                            <h3 class="card-title">Edit student</h3>
                        </div>


                        <form action="{{route('student.update',$student->id)}}" method="post">
                            @csrf
                            <div class="card-body">
                                @if (Session::has('success'))
                                <p class="alert alert-success">
                                    {{Session::get('success')}}
                                </p>
                                @endif
                                <div class="row">
                                    <div class="form-group col-md-4">
                                        <label for="exampleInputClass">Class</label>
                                        <select name="academic_class_id" id="exampleInputClass" class="form-control">
                                            <option disabled>Select what class</option>
                                            @foreach ($classes as $class )
                                            <option value="{{$class->id}}"{{$class->id == $student->academic_class_id ? 'selected' : null}}>{{$class->name}}</option>
                                            @endforeach
                                        </select>

                                        @error('academic_class_id')
                                        <div>
                                            <p class="text-danger">{{$message }}</p>
                                        </div>
                                        @enderror
                                    </div>

                                    <div class="form-group col-md-4">
                                        <label for="exampleInputAcademicYear">Academic Year</label>
                                        <select name="academic_year_id" id="exampleInputAcademicYear" class="form-control">
                                            <option value="" disabled>Select Academic Year</option>
                                            @foreach ($AcademicYears as $AcademicYear )
                                            <option value="{{$AcademicYear->id}}"{{$AcademicYear->id == $student->academic_year_id ? 'selected' : null}}>{{$AcademicYear->name}}</option>
                                            @endforeach
                                        </select>
                                        @error('academic_year_id')
                                        <div>
                                            <p class="text-danger">{{$message }}</p>
                                        </div>
                                        @enderror
                                    </div>

                                    <div class="form-group col-md-4">
                                        <label for="exampleInputAcademicYear">Admission Date</label>
                                        <input type="date" name="admission_date" value="{{old('admission_date',$student->admission_date)}}" class="form-control">
                                        @error('admission_date')
                                        <div>
                                            <p class="text-danger">{{$message }}</p>
                                        </div>
                                        @enderror

                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-md-4">
                                        <label for="exampleInputJanuary">Student Name</label>
                                        <input type="" name="name" value="{{old('name',$student->name)}}" class="form-control" id="exampleInputJanuary" placeholder="Enter student name">
                                        @error('name')
                                        <div>
                                            <p class="text-danger">{{$message}}</p>
                                        </div>
                                        @enderror
                                    </div>

                                    <div class="form-group col-md-4">
                                        <label for="exampleInputJanuary">Student Father Name</label>
                                        <input type="text" name="father_name" value="{{old('father_name',$student->father_name)}}" class="form-control" id="exampleInputJanuary" placeholder="Enter student father name">
                                        @error('father_name')
                                        <div>
                                            <p class="text-danger">{{$message}}</p>
                                        </div>
                                        @enderror
                                    </div>


                                    <div class="form-group col-md-4">
                                        <label for="exampleInputFebruary">student Mother Name</label>
                                        <input type="text" name="mother_name" value="{{old('mother_name',$student->mother_name)}}" class="form-control" id="exampleInputFebruary" placeholder="Enter mother name">
                                        @error('mother_name')
                                        <div>
                                            <p class="text-danger">{{$message }}</p>
                                        </div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row">
                                <div class="form-group col-md-4">
                                        <label for="exampleInputAcademicYear">Date of birth</label>
                                        <input type="date" name="dob" value="{{old('dob',$student->dob)}}" class="form-control">
                                        @error('dob')
                                        <div>
                                            <p class="text-danger">{{$message }}</p>
                                        </div>
                                        @enderror
                                    </div>

                                    <div class="form-group col-md-4">
                                        <label for="exampleInputEmail1">mobile number</label>
                                        <input type="text" name="mobile_no" value="{{old('mobile_no',$student->mobile_no)}}" class="form-control" id="exampleInputApril" placeholder="Enter your mobile number">
                                        @error('mobile_no')
                                        <div>
                                            <p class="text-danger">{{$message }}</p>
                                        </div>
                                        @enderror
                                    </div>

                                    <div class="form-group col-md-4">
                                        <label for="exampleInputEmail1">Email</label>
                                        <input type="text" name="email" value="{{old('email',$student->email)}}" class="form-control" id="exampleInputMay" placeholder="Enter your email">
                                        @error('email')
                                        <div>
                                            <p class="text-danger">{{$message }}</p>
                                        </div>
                                        @enderror
                                    </div>

                                    <div class="form-group col-md-4">
                                        <label for="exampleInputEmail1">Create password</label>
                                        <input type="password" name="password" value="{{old('password',$student->password)}}" class="form-control" id="exampleInputJune" placeholder="Enter password">
                                        @error('password')
                                        <div>
                                            <p class="text-danger">{{$message }}</p>
                                        </div>
                                        @enderror
                                    </div>
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