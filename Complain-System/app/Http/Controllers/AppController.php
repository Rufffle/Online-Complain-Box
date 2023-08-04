<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class AppController extends Controller
{
    public function LoginFunction(Request $request)
    {

            $userType= Auth::user()->UserType;

            if ($userType=='Admin') {
            return view('admin.adminDashboard');
                }

            if ($userType=='Student') {
            return view('Student.StudentDashboard');
                }

            if ($userType=='Teacher') {
                return view('Teacher.TeacherDashboard');
                    }

            if ($userType=='Parents') {

            return view('Parents.ParentsDashboard');

                }

            if ($userType=='Moderator') {
            return view('Moderators.ModeratorDashboard');
            }

            else{
                return View('auth.login');


            }
            // $credentials = $request->validate([
            //     'email' => ['required', 'email'],
            //     'password' => ['required'],
            // ]);

            // if (Auth::attempt($credentials)) {
            //     $userType = Auth::user()->UserType;

            //     if ($userType == 'Admin') {
            //         return view('admin.adminDashboard');
            //     } elseif ($userType == 'Student') {
            //         return view('Student.StudentDashboard');
            //     } elseif ($userType == 'Teacher') {
            //         return view('Teacher.TeacherDashboard');
            //     } elseif ($userType == 'Parents') {
            //         return view('Parents.ParentsDashboard');
            //     } elseif ($userType == 'Moderator') {
            //         return view('Moderators.ModeratorDashboard');
            //     }
            // } else {
            //     return redirect()->back()->with('error', 'Invalid credentials. Please try again.');
            // }
    }

    public function logoutFunction (){

        Auth::logout();
        return Redirect()->route('login');

    }
}




