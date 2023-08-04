<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Complain;
use App\Models\TeachersComplain;
use App\Models\ParentsComplain;
use App\Models\Moderator;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class AdminController extends Controller
{
    public function AddModeratorsFunction()
    {

        return view('admin.AddModerators');
    }

    public function AddModeratorButtonFunction(Request $request)
    {

        // $Moderators = new Moderator;

        // $Moderators->name = $request->name;
        // $Moderators->email = $request->email;
        // $Moderators->phone = $request->phone;
        // $Moderators->UserType = $request->UserType='Moderator';
        // $Moderators->password = $request->password='$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi'; // password
        // $Moderators->remember_token = Str::random(10);

        // $Moderators->save();


        User::insert([

            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'UserType' => $request->UserType = 'Moderator',
            'ModeratorType' => $request->ModeratorType,
            'password' => $request->password = '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi' // password


        ]);
        Alert::success('successfull', 'Moderator Added successfully');
        return redirect()->back();
    }

    public function ViewModeratorsListFunction()
    {
        if (Auth::id()) {

            $Moderators = User::where('UserType', '=', 'Moderator')->get();
            return view('admin.AdminViewModList', compact('Moderators'));
        } else {
            return view('auth.login');
        }
    }
    public function RemoveModFunction($id)
    {
        if (Auth::id()) {


            $Moderators = User::find($id);
            $Moderators->delete();
            Alert::info('successful', 'Removed successfully');
            return redirect()->back();
        } else {
            return view('auth.login');
        }
    }

    public function ViewComplainFunction(Request $request)
    {

        if (Auth::id()) {


        $Complain = Complain::when($request->date != null, function ($q) use ($request) {
                $q->whereDate('created_at', $request->date)->get();
            })->when($request->ComplainTypeFilter != null, function ($q) use ($request) {
                $q->where('ComplainType', $request->ComplainTypeFilter);
            })->get();

            return view('admin.AdminViewStudentComplains', compact('Complain'));
        } else {
            return view('auth.login');
        }
    }
    public function ViewTeachersComplainFunction (Request $request)
    {

        if (Auth::id()) {


            $TeachersComplain = TeachersComplain::when($request->date != null, function ($q) use ($request) {
                $q->whereDate('created_at', $request->date)->get();
            })->when($request->ComplainTypeFilter != null, function ($q) use ($request) {
                $q->where('ComplainType', $request->ComplainTypeFilter);
            })->get();

            return view('admin.AdminViewTeacherComplains', compact('TeachersComplain'));
        } else {
            return view('auth.login');
        }
    }
    public function ViewParentsComplainFunction (Request $request)
    {

        if (Auth::id()) {


            $ParentsComplain = ParentsComplain::when($request->date != null, function ($q) use ($request) {
                $q->whereDate('created_at', $request->date)->get();
            })->when($request->ComplainTypeFilter != null, function ($q) use ($request) {
                $q->where('ComplainType', $request->ComplainTypeFilter);
            })->get();

            return view('admin.AdminViewParentsComplains', compact('ParentsComplain'));
        }
        else {
            return view('auth.login');
        }
    }
    public function AssignToModFunction($id){
  if(Auth::id()){
    $ParentsComplain = ParentsComplain::find($id);
    $ParentsComplain->ComplainStatus = 'Assigned to a moderator';
    $ParentsComplain->save();
    $ParentsComplain = Auth::user()->id;
    $ParentsComplain = ParentsComplain::where('userID', $ParentsComplain)->get();
    // return view('admin.AdminViewParentsComplains', compact('ParentsComplain'));
    // return redirect()-back();
    return redirect()->back()->with('success', 'Assigned Successfully');
  }
  else{
    return view('auth.login');
  }

    }
    public function AssignToModForSTDFunction($id){
  if(Auth::id()){
    $Complains = Complain::find($id);
    $Complains->ComplainStatus = 'Assigned to a moderator';
    $Complains->save();
    $Complains = Auth::user()->id;
    $Complains = Complain::where('userID', $Complains)->get();
    return redirect()->back()->with('success', 'Assigned Successfully');
  }
  else{
    return view('auth.login');
  }

    }
    public function AssignToModForTeacherFunction($id){
  if(Auth::id()){
    $Complains = TeachersComplain::find($id);
    $Complains->ComplainStatus = 'Assigned to a moderator';
    $Complains->save();
    $Complains = Auth::user()->id;
    $Complains = TeachersComplain::where('userID', $Complains)->get();
    return redirect()->back()->with('success', 'Assigned Successfully');
  }
  else{
    return view('auth.login');
  }

    }
}
