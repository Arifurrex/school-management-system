<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use Illuminate\Http\Request;

class AnnouncementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data=new Announcement();
        $all_data['announcement']=$data->latest()->get();
        return view('admin.announcement.announcement-index',$all_data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.announcement.announcement-create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'message'=>'required',
            'type'=>'required',
        ]);

        Announcement::create($request->all());
        return redirect()->back()->with('success','successfully added announcement');



    }

    /**
     * Display the specified resource.
     */
    public function show(Announcement $announcement)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Announcement $announcement,$id)
    {
        $data['announcement'] =  Announcement::find($id);
        return view('admin.announcement.announcement-edit',$data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Announcement $announcement,Request $request , $id)
    {
        $data =  Announcement::find($id);
        $data->message =$request->message;
        $data->type = $request->type;
        $data->update();

        return redirect()->route('announcement.index')->with('success','announcement update successfully');
        dd($data);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function delete(Announcement $announcement,$id)
    {
        $data =  Announcement::find($id);
        $data->delete();

        return redirect()->back()->with('success','successfully delete');
    }
}
