<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Profile;
use Auth;
use Illuminate\Http\Request;

use Symfony\Component\Intl\Countries;
use Symfony\Component\Intl\Languages;
class ProfileController extends Controller
{
    //function edit 

    public function edit(){
        $user=Auth::user();
        $countries = Countries::getNames();
        $locals=Languages::getNames();
        // dd($languages);
        return view("dashboard/profile/edit",[
            "user"=> $user,
            'countries'=>$countries,
            'locals'=>$locals
        ]);
    }


    //update user profile though authed user

    public function update(Request $request){

        $user=Auth::user();
        //validation request data
//  'title' => ['required', 'unique:posts', 'max:255'],
        $request->validate([
            'first_name'=>['required','string','max:20','min:3'],
            'last_name'=>['required','string','max:20','min:3'],
            'birthdate'=>['nullable','date','before:today'],
            'country'=>['required','string','size:2'],
            'gender'=>['nullable','in:male,female']
          

        ]);

        //update user profile data

        $profile=$user->profile;
        if($profile->first_name){

            $profile->update($request->all());
        }else{
            $request->merge(
                ['user_id'=>$user->id]
            );
            Profile::create($request->all());
        }
        return redirect()->route('dashboard.profile.edit')->with('success','profile updated!');
    }
}
