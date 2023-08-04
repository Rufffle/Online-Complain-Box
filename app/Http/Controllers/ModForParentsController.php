<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Models\ParentsComplain;
use App\Models\solutionForParents;
use Illuminate\Http\Request;

class ModForParentsController extends Controller
{
    public function SeeParentsComplainFunction(Request $request)
    {

        if (Auth::id()) {

            //checking which mod trying to login
            $ModeratorType = Auth::user()->ModeratorType;

            // if IT mod loggeed in
            if ($ModeratorType === 'IT') {
                $complaints = ParentsComplain::when($request->date != null, function ($q) use ($request) {
                    $q->whereDate('created_at', $request->date)->get();
                })->when($request->ComplainTypeFilter != null, function ($q) use ($request) {
                    $q->where('ComplainType', $request->ComplainTypeFilter);
                })->where('ComplainSection', 'IT')->where('ComplainStatus', 'Assigned to a moderator')->get();
            }
            // if Lab mod loggeed in
            else if ($ModeratorType === 'Lab') {
                $complaints = ParentsComplain::when($request->date != null, function ($q) use ($request) {
                    $q->whereDate('created_at', $request->date)->get();
                })->when($request->ComplainTypeFilter != null, function ($q) use ($request) {
                    $q->where('ComplainType', $request->ComplainTypeFilter);
                })->where('ComplainSection', 'Lab')->where('ComplainStatus', 'Assigned to a moderator')->get();
            }
            // if General mod loggeed in
            else if ($ModeratorType === 'General') {
                $complaints = ParentsComplain::when($request->date != null, function ($q) use ($request) {
                    $q->whereDate('created_at', $request->date)->get();
                })->when($request->ComplainTypeFilter != null, function ($q) use ($request) {
                    $q->where('ComplainType', $request->ComplainTypeFilter);
                })->where('ComplainSection', 'General')->where('ComplainStatus', 'Assigned to a moderator')->get();
            }
            // if Administrator mod loggeed in
            else if ($ModeratorType === 'Administrator') {
                $complaints = ParentsComplain::when($request->date != null, function ($q) use ($request) {
                    $q->whereDate('created_at', $request->date)->get();
                })->when($request->ComplainTypeFilter != null, function ($q) use ($request) {
                    $q->where('ComplainType', $request->ComplainTypeFilter);
                })->where('ComplainSection', 'Administrator')->where('ComplainStatus', 'Assigned to a moderator')->get();
            }
            return view('Moderators.ModViewParentsComplain', compact('complaints'));
        } else {
            return view('auth.login');
        }
    }

    public function provideSolutionToParentsFunction(Request $request, $id)
    {
        if (Auth::id()) {
            $complaints = ParentsComplain::find($id);
            $complaints->ComplainStatus = 'Solved';

            $complaints->save();

            $solution = new solutionForParents;
            $solution->complaint_id = $complaints->id;
            $solution->solution = $request->input('solution');
            $solution->save();

            return redirect()->back()->with('success', 'Solution provided successfully');
        } else {
            return view('auth.login');
        }
    }
}
