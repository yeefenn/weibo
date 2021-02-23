<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
//use Request;

class UsersController extends Controller
{
    //
    public function create()
    {
      return view('users.create');

    }
    public function show(User  $user)
    {
      return view('users.show',compact('user'));

    }
    // public function store(Request $request)
    // {
    //     $input=Request::all();
    //     dump($input);
    //     exit;

    // }
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:users|max:50',
            'email' => 'required|email|unique:users|max:255',
            'password' => 'required|confirmed|min:6'
        ]);
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);
        //dump($user);exit;
        Auth::login($user);
        session()->flash('success', '欢迎，您将在这里开启一段新的旅程~');
        return redirect()->route('users.show', [$user]);
    }


    public function edit(User $user)
    {
        return view('users.edit',compact('user'));


    }

    public function update(User $user ,Request $request)
    {
       $this->validate($request,[
           'name'=>'required|max:50px',
           'password'=>'nullable|confirmed|min:6'
       ]);
    //    $user->update([
    //        'name'=>$request->name,
    //        'password'=>bcrypt($request->password)
    //    ]);

       $data=[];
       $data['name']=$request->name;
       if($request->password){
           $data['password']=bcrypt($request->password);
       }

       $user->update($data);
       session()->flash('success','个人资料更新成功！');
       return redirect()->route('users.show',$user);

    }



}
