@extends('admin.layout')

@section('content')
<div class="content-wrapper">

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>FeeHead edit</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
                        <li class="breadcrumb-item active">FeeHead edit</li>
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
                            <h3 class="card-title">Edit FeeHead</h3>
                        </div>


                        <form action="{{route('FeeStructure.update',$feeStructure->id)}}" method="post">
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
                                            <option value="" disabled>Select what class</option>
                                            @foreach ($classes as $class )
                                            <option value="{{$class->id}}"
                                                {{$feeStructure->academicClass->id == $class->id ? 'selected' : null}}>
                                                {{$class->name}}
                                            </option>
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
                                            <option value="" disabled selected>Select Academic Year</option>

                                            @foreach ($AcademicYears as $AcademicYear )

                                            <option value="{{$AcademicYear->id}}"
                                                {{$feeStructure->AcademicYear->id == $AcademicYear->id? 'selected' : null}}>
                                                {{$AcademicYear->name}}
                                            </option>

                                            <option value="{{$AcademicYear->id}}">{{$AcademicYear->name}}</option>
                                            @endforeach

                                        </select>
                                        @error('academic_year_id')
                                        <div>
                                            <p class="text-danger">{{$message }}</p>
                                        </div>
                                        @enderror
                                    </div>

                                    <div class="form-group col-md-4">
                                        <label for="exampleInpuFeeHead">Fee Head</label>
                                        <select name="fee_head_id" id="exampleInputFeeHead" class="form-control">
                                            <option value="" disabled selected>Select Fee Head</option>
                                            @foreach ($FeeHeads as $FeeHead)
                                            <option value="{{$FeeHead->id}}"
                                                {{$feeStructure->FeeHead->id == $FeeHead->id ? 'selected' : null}}>{{$FeeHead->name}}</option>
                                            @endforeach
                                        </select>
                                        @error('fee_head_id')
                                        <div>
                                            <p class="text-danger">{{$message }}</p>
                                        </div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-md-4">
                                        <label for="exampleInputJanuary">January</label>
                                        <input type="text" name="january"
                                            value=" {{ old('january', $feeStructure->january) }}" class="form-control" id="exampleInputJanuary" placeholder="Enter january fee">
                                        @error('january')
                                        <div>
                                            <p class="text-danger">{{$message}}</p>
                                        </div>
                                        @enderror
                                    </div>

                                    <div class="form-group col-md-4">
                                        <label for="exampleInputFebruary">February</label>
                                        <input type="text" name="february" value="{{ old('february', $feeStructure->february) }}" class="form-control" id="exampleInputFebruary" placeholder="Enter February Fee">
                                        @error('february')
                                        <div>
                                            <p class="text-danger">{{$message }}</p>
                                        </div>
                                        @enderror
                                    </div>

                                    <div class="form-group col-md-4">
                                        <label for="exampleInputMarch">March</label>
                                        <input type="text" name="march" value="{{ old('march', $feeStructure->march) }}" class="form-control" id="exampleInputMarch" placeholder="Enter March fee">
                                        @error('march')
                                        <div>
                                            <p class="text-danger">{{$message }}</p>
                                        </div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-md-4">
                                        <label for="exampleInputEmail1">April</label>
                                        <input type="text" name="april" value="{{ old('april', $feeStructure->april) }}" class="form-control" id="exampleInputApril" placeholder="Enter April Fee">
                                        @error('april')
                                        <div>
                                            <p class="text-danger">{{$message }}</p>
                                        </div>
                                        @enderror
                                    </div>

                                    <div class="form-group col-md-4">
                                        <label for="exampleInputEmail1">May</label>
                                        <input type="text" name="may" value="{{ old('may', $feeStructure->may) }}" class="form-control" id="exampleInputMay" placeholder="Enter May Fee">
                                        @error('may')
                                        <div>
                                            <p class="text-danger">{{$message }}</p>
                                        </div>
                                        @enderror
                                    </div>

                                    <div class="form-group col-md-4">
                                        <label for="exampleInputEmail1">june</label>
                                        <input type="text" name="june" value="{{ old('june', $feeStructure->june) }}" class="form-control" id="exampleInputJune" placeholder="Enter June Fee">
                                        @error('june')
                                        <div>
                                            <p class="text-danger">{{$message }}</p>
                                        </div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-md-4">
                                        <label for="exampleInputJuly">July</label>
                                        <input type="text" name="july" value="{{ old('july', $feeStructure->july) }}" class="form-control" id="exampleInputJuly" placeholder="Enter July Fee">
                                        @error('july')
                                        <div>
                                            <p class="text-danger">{{$message }}</p>
                                        </div>
                                        @enderror
                                    </div>

                                    <div class="form-group col-md-4">
                                        <label for="exampleInputAugust">August</label>
                                        <input type="text" name="august" value="{{ old('august', $feeStructure->august) }}" class="form-control" id="exampleInputAugust" placeholder="Enter August Fee">
                                        @error('august')
                                        <div>
                                            <p class="text-danger">{{$message }}</p>
                                        </div>
                                        @enderror
                                    </div>

                                    <div class="form-group col-md-4">
                                        <label for="exampleInputSeptember">September</label>
                                        <input type="text" name="september" value="{{ old('september', $feeStructure->september) }}" class="form-control" id="exampleInputSeptember" placeholder="Enter September Fee">
                                        @error('september')
                                        <div>
                                            <p class="text-danger">{{$message }}</p>
                                        </div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-md-4">
                                        <label for="exampleInputOctober">October</label>
                                        <input type="text" name="october" value="{{ old('october', $feeStructure->october) }}" class="form-control" id="exampleInputOctober" placeholder="Enter FeeStructure">
                                        @error('october')
                                        <div>
                                            <p class="text-danger">{{$message }}</p>
                                        </div>
                                        @enderror
                                    </div>

                                    <div class="form-group col-md-4">
                                        <label for="exampleInputNovember">November</label>
                                        <input type="text" name="november" value="{{ old('november', $feeStructure->november) }}" class="form-control" id="exampleInputNovember" placeholder="Enter November Fee">
                                        @error('november')
                                        <div>
                                            <p class="text-danger">{{$message }}</p>
                                        </div>
                                        @enderror
                                    </div>

                                    <div class="form-group col-md-4">
                                        <label for="exampleInputDecember">December</label>
                                        <input type="text" name="december" value="{{ old('december', $feeStructure->december) }}" class="form-control" id="exampleInputDecember" placeholder="Enter December Fee">
                                        @error('december')
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
