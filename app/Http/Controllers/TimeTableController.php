<?php

namespace App\Http\Controllers;

use App\Models\academicClass;
use App\Models\assignSubjectToClass;
use App\Models\assignTeacherToClass;
use App\Models\day;
use App\Models\subject;
use App\Models\timeTable;
use Illuminate\Http\Request;

class TimeTableController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = timeTable::query()->with(['academicClasses', 'subjects', 'day']);

        if ($request->filled('class_id')) {
            $query->where('class_id', $request->get('class_id'));
        }
        if ($request->filled('subject_id')) {
            $query->where('subject_id', $request->get('subject_id'));
        }
        $data['timeTable'] = $query->get();

        $data['assignTeacherToClass'] = assignTeacherToClass::get();
        $data['classes'] = academicClass::all();
        $data['subjects'] = subject::all();
        return view('admin.timeTable.timeTable-index', $data);
    }
    // AJAX
    public function fetchSubjects(Request $request)
    {
        $classId = $request->class_id;

        $assignSubjectToClass = assignSubjectToClass::where('class_id', $classId)
            ->with(['subjects', 'academicClasses'])
            ->get();

        $assignTeacherToClass = assignTeacherToClass::find($classId);

        $outputtt = '';

        // Starting HTML for the select box
        $outputtt .= '<div class="form-group col-md-12">
                <label for="exampleInputSubject">Subject3</label>
                <select name="subject_id" id="exampleInputSubject" class="form-control">
                    <option disabled>Select subject</option>';

        // Looping through the subjects
        foreach ($assignSubjectToClass as $assignSubjectToCla) {
            $outputtt .= '<option value="' . $assignSubjectToCla->subjects->id . '"';

            // Closing the option tag with the subject's name
            $outputtt .= '>' . $assignSubjectToCla->subjects->name . '</option>';
        }

        // Closing the select and div tag
        $outputtt .= '</select></div>';

        // Returning the output as JSON
        return response()->json(['html' => $outputtt]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data['days'] = day::all();
        $data['classes'] = academicClass::all();
        $data['subjects'] = subject::all();
        return view('admin.timeTable.timeTable-create', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $class_id = $request->class_id;
        $subject_id = $request->subject_id;

        foreach ($request->timeTable as $timeTable) {
            $day_id = $timeTable['day_id'];
            $start_time = $timeTable['start_time'];
            $end_time = $timeTable['end_time'];
            $room_no = $timeTable['room_no'];

            timeTable::updateOrCreate(
                [
                    'day_id' => $day_id,
                    'subject_id' => $subject_id,
                    'class_id' => $class_id,
                ],
                [
                    'day_id' => $day_id,
                    'subject_id' => $subject_id,
                    'class_id' => $class_id,
                    'start_time' => $start_time,
                    'end_time' => $end_time,
                    'room_no' => $room_no,
                ]
            );
        }
        return redirect()->route('timeTable.create')->with('success', 'successfully insert data');
    }

    /**
     * Display the specified resource.
     */
    public function show(timeTable $timeTable)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(timeTable $timeTable, $id, Request $request)
    {
        $data['timeTable'] = timeTable::with('day')->find($id);
        $data['classes'] = academicClass::all();
        $data['subjects'] = subject::all();
        $data['days'] = day::all();
        return view('admin.timeTable.timeTable-edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, timeTable $timeTable,$id)
    {
        $data = timeTable::find($id);
        $data->class_id = $request->class_id;
        $data->subject_id = $request->subject_id;
        $data->room_no = $request->room_no;
        $data->start_time = $request->start_time;
        $data->end_time = $request->end_time;
        $data->update();

        return redirect()->route('timeTable.index')->with('success','successfully update');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(timeTable $timeTable)
    {
        //
    }
}
