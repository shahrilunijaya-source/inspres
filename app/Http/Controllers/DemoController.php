<?php

namespace App\Http\Controllers;

use App\Models\DemoWalkthroughStep;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DemoController extends Controller
{
    public function switchRole(Request $request)
    {
        abort_unless(app()->environment('demo', 'local'), 403, 'Demo switcher disabled in this environment.');

        $role = $request->query('role', 'public');
        $user = User::where('is_demo', true)->where('role', $role)->first();

        abort_if(!$user, 404, 'Demo user not found for role ' . $role);

        Auth::loginUsingId($user->id, true);

        if (in_array($role, ['officer', 'supervisor', 'admin'], true)) {
            return redirect('/admin');
        }
        return redirect()->route('dashboard')->with('success', 'Anda kini melihat sebagai ' . $user->roleLabel() . ' — ' . $user->name);
    }

    public function walkthrough(Request $request)
    {
        $stepNo = (int) $request->query('step', session('walkthrough_step', 1));
        $step = DemoWalkthroughStep::where('step_no', $stepNo)->first();
        $totalSteps = DemoWalkthroughStep::count();
        $allSteps = DemoWalkthroughStep::orderBy('step_no')->get();
        session(['walkthrough_step' => $stepNo]);
        return view('demo.walkthrough', compact('step', 'totalSteps', 'allSteps', 'stepNo'));
    }

    public function advance(Request $request)
    {
        $next = (int) $request->input('step', session('walkthrough_step', 1)) + 1;
        $total = DemoWalkthroughStep::count();
        if ($next > $total) $next = 1;
        return redirect()->route('demo.walkthrough', ['step' => $next]);
    }
}
