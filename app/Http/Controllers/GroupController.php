<?php

namespace App\Http\Controllers;

use App\Models\Group;
use Illuminate\Http\Request;

class GroupController extends Controller
{
    public function index(){
        $groups = Group::orderBy('id','DESC')->get();
        return view('groups.index',compact('groups'));
    }

    public function store(Request $request){
      //  dd($request->name);
        $request->validate([
            'name'=>'required',
        ]);
        $group = Group::create([
            'name'=>$request->name,
        ]);
        return response()->json(['success'=>true]);
    }
    public function edit(Group $group)
    {
        return view('groups.index',compact('group'));
    }
    public function update(Request $request){
        $request->validate([
            'name'=>'required',
        ]);
        $group=Group::find($request->update_id);
         $group->update($request->all());

        
        return response()->json([
            'success'=>true,
        ]);
    }
    public function destroy(Group $group)
    {
        $group->delete();

        return redirect()->route('groups.index')->with('success', 'Group deleted successfully');
    }
}
