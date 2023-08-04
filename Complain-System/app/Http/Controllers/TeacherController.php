<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use App\Models\TeachersComplain;
class TeacherController extends Controller
{
    public function TeacherNewComplainFunction(){

        return View('Teacher.TeacherAddNewComplain');
    }


    public function TeacherNewComPlainSubmitSubmitFunction(Request $request){
        if (Auth::id()) {

            $TeachersComplain = new TeachersComplain;
            $TeachersComplain->TeacherName = Auth::user()->name;
            $TeachersComplain->ComplainType = $request->ComplainType;
            $TeachersComplain->ComplainSection = $request->ComplainSection;
            $TeachersComplain->message = $request->message;
            $TeachersComplain->ComplainStatus = 'Pending';
            $TeachersComplain->userID = Auth::user()->id;
            $TeachersComplain->save();

            Alert::success('Complain Sent successfully', 'Please wait for reply');

            return redirect()->back();
        } else {
            return view('auth.login');
        }
    }

    public function TeacherViewComplainsFunction(){

        if (Auth::id()) {

            $TeachersComplain = Auth::user()->id;
            $TeachersComplain = TeachersComplain::where('userID', $TeachersComplain)->get();

            return View('Teacher.TeacherViewAllComplain', compact('TeachersComplain'));
        } else {
            return view('auth.login');
        }
    }
    public function RemoveTeacherComplainFunction($id){
        if (Auth::id()) {


            $TeachersComplain = TeachersComplain::find($id);
            $TeachersComplain->delete();
            Alert::info('Complain Removed successfully!!', 'Your Complain has been Removed!');
            return redirect()->back();
        } else {

            return view('auth.login');
        }

    }
    public function TeacherViewFeedbackFunction(){

        if (Auth::id()) {

            $complaints = TeachersComplain::leftJoin('solution_for_teachers', 'teachers_complains.id', '=', 'solution_for_teachers.complaint_id')
            ->select('teachers_complains.TeacherName', 'teachers_complains.ComplainType', 'solution_for_teachers.solution')
            ->get();

            // return view('complaints.index', ['complaints' => $complaints]);


            return view('Teacher.TeacherViewFeedback', compact('complaints'));
        }
        else {
            return view('auth.login');
        }
    }
}
