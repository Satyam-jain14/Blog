<?php

namespace App\Http\Controllers;

use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    //
    public function editProfile(){
        $info=User::find(Auth::user()->id);
        return view('user.editprofile',compact('info'));
    }

    public function userProfile(){
        request()->validate([
            'profilepic'=>'required|mimes:jpg,jpge,png,gif|max:5000'
        ]);
        if(request()->profilepic->getError()==0){
            $filename=time()."__".request()->profilepic->getClientOriginalName();
            request()->profilepic->move("./profiles/",$filename);
            $info=User::find(Auth::user()->id);
            if(Auth::user()->profilepic){
                if(Auth::user()->profilepic!="default.jpg"){
                unlink("./profiles/".Auth::user()->profilepic);
                }
            }
            $info->profilepic=$filename;
            $info->save();
        }
        return redirect("/editProfile");
    }

    public function updateProfile($id){
        // dd("hello");
        request()->validate([
            'mobile'=>'digits:10',
        ]);
        $info=User::find($id);
        $info->name=request('name');
        $info->bio=request('bio');
        $info->dob=request('dob');
        $info->status=request('status');
        $info->gender=request('gender');
        $info->email=request('email');
        $info->mobile=request('mobile');
        $info->address=request('address');
        $info->save();
        return redirect("/editProfile")->with('msg','Info Updated!!');
        
    }
    public function show($id){
        // dd($id);
        $info=User::find($id);
        return view('user.editprofile',compact("info"));
    }
}
