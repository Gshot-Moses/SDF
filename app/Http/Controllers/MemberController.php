<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use App\Http\Requests\MemberRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class MemberController extends Controller
{

    public function __contruct() {
        //$this->middleware('auth')->except('index');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $members = User::get();
        return view('members.index', ['members' => $members]);
    }

    public function dashboard() {

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('members.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255|min:3',
            'email' => 'required|unique:users,email|max:255',
            //'password' => 'required',
            'role' => 'required'
        ]);
        if ($validator->fails()) {
            $errors = array();
            if (array_key_exists('name', $validator->errors()->toArray())) {
                $errors['nameError'] = $validator->errors()->toArray()['name'][0];
            }
            if (array_key_exists('email', $validator->errors()->toArray())) {
                $errors['emailError'] = $validator->errors()->toArray()['email'][0];
            }
            return response()->json($errors);
        }
        $validated = $validator->valid();
        $member = new User;
        $member->name = $request->name;
        $member->email = $request->email;
        $member->role_id = $request->role;
        $member->password = Hash::make('12345678');
        $member->save();
        return response()->json($member);
        //return redirect()->route('member.index')->with('status', 'Membre cree');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Member  $member
     * @return \Illuminate\Http\Response
     */
    public function show(Member $member)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Member  $member
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $member = User::where('id', '=', $id)->first();
        $roles = Role::get();
        return view('members.edit', ['member' => $member, 'roles' => $roles]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Member  $member
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255|min:3',
            'email' => 'required|max:255',
            //'password' => 'required',
            'role' => 'required'
        ]);
        if ($validator->fails()) {
            $errors = array();
            if (array_key_exists('name', $validator->errors()->toArray())) {
                $errors['nameError'] = $validator->errors()->toArray()['name'][0];
            }
            if (array_key_exists('email', $validator->errors()->toArray())) {
                $errors['emailError'] = $validator->errors()->toArray()['email'][0];
            }
            return response()->json($errors);
        }
        $validated = $validator->valid();
        $member = User::where('id', '=', $id)->first();
        $member->name = $request->name;
        $member->email = $request->email;
        $member->role_id = $request->role;
        //$member->password = Hash::make($request->password);
        $member->save();
        return response()->json(['success' => 'OK', 'name' => $member->name, 'id' => $member->id]);
        //return redirect()->route('member.index')->with('status', 'Modification effectif');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Member  $member
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $member = User::where('id', '=', $id);
        $member->delete();
        return response()->json(["id" => $id]);
        //return redirect()->route('member.index')->with('status', 'Suppression effectif');
    }
}
