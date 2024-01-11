<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\Member;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    public function index(){
        $groups = Group::all();
        $members = Member::paginate(10);     


       
       // return response()->json(['success'=>true]);
       return view('members.index', compact('members','groups'));
}
        
    
    public function create()
    {
        $groups = Group::all();
       // $members = Member::all();
        return view('members.create', compact('groups'));
    }

    public function store(Request $request)
    {
        //dd($request);
        $validatedData = $request->validate([
            'email' => 'required|email',
            'first_name' => 'required',
            'last_name' => 'required',
            'phone_no' => 'required',
            //'add_to_group' => 'required',
            'group_id' => 'nullable|array',
            
        ]);
        $member = Member::create([ 
        'email'=>$request->email,
        'first_name'=>$request->first_name,
        'last_name'=>$request->last_name,
        'phone_no'=>$request->phone_no,
      //  'add_to_group'=>$request->group,
        'group_id'=>$request->array, 
    ]);
        if (isset($validatedData['group_id'])) {
            $member->groups()->attach($validatedData['group_id']);
        }
        return redirect()->route('members.index')->with('success', 'Member created successfully');
    }

    public function edit(Member $member, $currentPage)
    {
        $groups = Group::all();
        return view('members.edit', compact('member', 'groups', 'currentPage'));
    }

    public function update(Request $request,Member $member)
    {
        $validatedData = $request->validate([
            'email' => 'required|email',
            'first_name' => 'required',
            'last_name' => 'required',
            'phone_no' => 'required',
           // 'add_to_group'=>'required',
            'group_id' => 'nullable|array',
        ]);

        $member->update([
        'email'=>$request->email,
        'first_name'=>$request->first_name,
        'last_name'=>$request->last_name,
        'phone_no'=>$request->phone_no,
       //'add_to_group'=>$request->group,
        'group_id'=>$request->array, 
    ]);

        $member->groups()->sync($validatedData['group_id'] ?? []);
        $redirectPage = $this->getCurrentPage($request->currentPage);
        return response()->json(['success' => true, 'page' => $redirectPage]);

        //return redirect()->route('members.index')->with('success', 'Member updated successfully');
    }
    public function show(Member $member)
    {
        $groups = $member->groups;

        return view('members.index', compact('member', 'groups'));
    }
    public function destroy(Member $member, $currentPage)
    {
        
        $member->delete();

        $redirectPage = $this->getCurrentPage($currentPage);
        return response()->json(['success' => true, 'page' => $redirectPage]);
            
    }
    private function getCurrentPage($currentPage)
    {
        $paginator = Member::paginate(10, ['id']);
        if ($currentPage <= $paginator->lastPage()) {
            return $currentPage;
        }
        return $paginator->lastPage();
    }
}
