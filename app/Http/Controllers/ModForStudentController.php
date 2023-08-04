<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\DB;
use App\Models\Complain;
use App\Models\TeachersComplain;
use App\Models\ParentsComplain;
use App\Models\SolutionForStud;

class ModForStudentController extends Controller
{

    public function SeeStudentsComplainFunction(Request $request)
    {

        if (Auth::id()) {

            //checking which mod trying to login
            $ModeratorType = Auth::user()->ModeratorType;

            // if IT mod loggeed in
            if ($ModeratorType === 'IT') {
                $complaints = Complain::when($request->date != null, function ($q) use ($request) {
                    $q->whereDate('created_at', $request->date)->get();
                })->when($request->ComplainTypeFilter != null, function ($q) use ($request) {
                    $q->where('ComplainType', $request->ComplainTypeFilter);
                })->where('ComplainSection', 'IT')->where('ComplainStatus', 'Assigned to a moderator')->get();
            }
            // if Lab mod loggeed in
            else if ($ModeratorType === 'Lab') {
                $complaints = Complain::when($request->date != null, function ($q) use ($request) {
                    $q->whereDate('created_at', $request->date)->get();
                })->when($request->ComplainTypeFilter != null, function ($q) use ($request) {
                    $q->where('ComplainType', $request->ComplainTypeFilter);
                })->where('ComplainSection', 'Lab')->where('ComplainStatus', 'Assigned to a moderator')->get();
            }
            // if General mod loggeed in
            else if ($ModeratorType === 'General') {
                $complaints = Complain::when($request->date != null, function ($q) use ($request) {
                    $q->whereDate('created_at', $request->date)->get();
                })->when($request->ComplainTypeFilter != null, function ($q) use ($request) {
                    $q->where('ComplainType', $request->ComplainTypeFilter);
                })->where('ComplainSection', 'General')->where('ComplainStatus', 'Assigned to a moderator')->get();
            }
            // if Administrator mod loggeed in
            else if ($ModeratorType === 'Administrator') {
                $complaints = Complain::when($request->date != null, function ($q) use ($request) {
                    $q->whereDate('created_at', $request->date)->get();
                })->when($request->ComplainTypeFilter != null, function ($q) use ($request) {
                    $q->where('ComplainType', $request->ComplainTypeFilter);
                })->where('ComplainSection', 'Administrator')->where('ComplainStatus', 'Assigned to a moderator')->get();
            }
            return view('Moderators.ModViewStudentComplain', compact('complaints'));
        } else {
            return view('auth.login');
        }
    }

    public function provideSolutionToStudFunction(Request $request, $id)
    {
        if (Auth::id()) {
            $complaints = Complain::find($id);
            $complaints->ComplainStatus = 'Solved';

            $complaints->save();

            $solution = new SolutionForStud;
            $solution->complaint_id = $complaints->id;
            $solution->solution = $request->input('solution');
            $solution->save();

            return redirect()->back()->with('success', 'Solution provided successfully');
        } else {
            return view('auth.login');
        }
    }

}
