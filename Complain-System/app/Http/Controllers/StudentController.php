<?php

namespace App\Http\Controllers;


use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Complain;
use App\Models\SolutionForStud;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;


class StudentController extends Controller
{
    public function NewComplainFunction()
    {

        return view('Student.StudentNewComplain');
    }
    public function MakeNewComPlainButtonFunction(Request $request)
    {
        if (Auth::id()) {

            $Complain = new Complain;
            $Complain->StudentName = Auth::user()->name;
            $Complain->StudentId = Auth::user()->userId;
            $Complain->ComplainType = $request->ComplainType;
            $Complain->ComplainSection = $request->ComplainSection;
            $Complain->Description = $request->Description;
            $Complain->ComplainStatus = 'Pending';
            $Complain->userID = Auth::user()->id;
            $Complain->save();

            Alert::success('Complain Sent successfully', 'Please wait for reply');

            return redirect()->back();
        } else {
            return view('auth.login');
        }
    }
    public function ViewComplainListFunction()
    {

        if (Auth::id()) {

            $Complain = Auth::user()->id;
            $Complain = Complain::where('userID', $Complain)->get();


            return view('Student.StudentSeeComplain', compact('Complain'));
        } else {
            return view('auth.login');
        }
    }

    public function RemoveComplainButtonFunction($id)
    {

        if (Auth::id()) {


            $Complain = Complain::find($id);
            $Complain->delete();
            Alert::info('Complain Sent successfully', 'Your Complain has been Removed');
            return redirect()->back();
        } else {

            return view('auth.login');
        }
    }




    public function StudViewFeedbackFunction()
    {

        if (Auth::id()) {
            $complaints = Complain::leftJoin('solution_for_studs', 'complains.id', '=', 'solution_for_studs.complaint_id')
            ->select('complains.StudentName', 'complains.ComplainType', 'solution_for_studs.solution')
            ->get();

            // return view('complaints.index', ['complaints' => $complaints]);


            return view('Student.StudentViewFeedback', compact('complaints'));
        } else {

            return view('auth.login');
        }
    }



    // public function RemoveFeedbackButtonFunction($id)
    // {

    //     if (Auth::id()) {

    //         $solution = SolutionForStud::findOrFail($id);
    //         $solution->delete();
    //         Alert::info('removed successfully', 'Your qeury has been Removed');
    //         return redirect()->back();
    //     } else {

    //         return view('auth.login');
    //     }
    // }


    public function SeeProfileFunction()
    {

        if (Auth::id()) {
            return view('profile.show');
        } else {

            return view('auth.login');
        }
    }
}
