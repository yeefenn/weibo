<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
class SessionsController extends Controller
{
    //
  public function create()
  {
     return view('sessions.create');

  }

  public function store(Request $request)
  {
      $credentilals = $this->validate($request,[
          'email'=>'required|email|max:225',
          'password'=>'required'
      ]);
      if (Auth::attempt($credentilals))
      {
        session()->flash('success','欢迎回来！');
        return redirect()->route('users.show',[Auth::user()]);

      }else
      {
        session()->flash('danger','很抱歉，您的邮箱和密码不匹配！');
        return redirect()->back()->withInput();

      }

      return;
  }






}
