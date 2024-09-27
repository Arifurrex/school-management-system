<?php

namespace App\Http\Controllers;

use App\Models\subject;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data['subject'] = subject::latest()->get();
        return view('admin.subject.subject-list', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.subject.subject-create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'type' => 'required',
        ]);

        subject::create($request->all());


        return redirect()->back()->with('success', 'successfully store your subject');
    }

    /**
     * Display the specified resource.
     */
    public function show(subject $subject)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(subject $subject, $id)
    {
        $data['subject'] = subject::find($id);
        return view('admin.subject.subject-edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, subject $subject, $id)
    {
        subject::find($id)->update($request->all());
        return redirect()->back()->with('success', 'successfully update your subject');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete(subject $subject, $id)
    {
        subject::find($id)->delete();
        return redirect()->back()->with('success', 'successfully delete your subject');
    }
}
