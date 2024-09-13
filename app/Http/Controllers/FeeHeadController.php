<?php

namespace App\Http\Controllers;

use App\Models\FeeHead;
use Illuminate\Http\Request;

class FeeHeadController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = new FeeHead();
        $all_data['FeeHead']=$data->latest()->get();
        return view('admin.FeeHead_list',$all_data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.FeeHead');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'=>'required'
        ]);

        $data = new FeeHead();
        $data ->name = $request->name;
        $data->save();
        return redirect()->route('FeeHead.create')->with('success','fee head save successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(FeeHead $feeHead)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(FeeHead $feeHead,$id)
    {
        $data['FeeHead'] = FeeHead::find($id);
        return view('admin.FeeHead-edit',$data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $data = FeeHead::find($id);
        $data->name = $request->name;
        $data->update();
        return redirect()->route('FeeHead.index')->with('success','successfully updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $data = FeeHead::find($id);
        $data->delete();
        return redirect()->route('FeeHead.index')->with('success','successfully delete ');
    }
}
