<?php

namespace App\Http\Controllers\Web\Users;

use App\Helpers\LogHelper;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Follower;
use App\Models\Job;
use App\Models\JobContact;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Lang;
use Illuminate\Testing\Fluent\Concerns\Has;

class UsersController extends Controller
{
    public function dashboard()
    {
        $id = auth()->guard('web')->user()->id;
        $jobActive = Job::where(['status' => 1, 'user_id' => $id])->count();
        $jobNoActive = Job::where(['status' => 0, 'user_id' => $id])->count();
        $companyResume = JobContact::where(['company_id'=> $id])->count();
        $userJobs = JobContact::where(['user_id'=> $id])->count();
        $userLike = Follower::where(['user_id'=> $id])->count();
        $userData = User::with(['followers','jobContact'])->where(['id'=> $id])->first();
        return view('web.users.dashboard',compact('jobActive','jobNoActive','companyResume','userJobs','userLike','userData'));
    }

    public function settings()
    {
        $user = auth()->guard('web')->user();
        return view('web.users.settings', compact('user'));
    }

    public function settings_update($id, Request $request)
    {
        try {
            $user = auth()->guard('web')->user();
            if ($request->hasFile('userlogo')) {
                $logoName = time() . '.' . $request->userlogo->extension();
                $logo = $request->userlogo->move(public_path('uploads/user/userlogo'), $logoName);
                $logoImage = $logo->getFilename();
            } else {
                $logoImage = $user->image;
            }

            if (!empty($request->password) && $request->new_password == $request->re_password) {
                $password =  Hash::make($request->new_password);
            } else {
                $password = $user->password;
            }

            $data = [
                'name' => $request->name ?? $user->name,
                'surname' => $request->surname ?? $user->surname,
                'parent' => 'null',
                'position' => $request->position ?? $user->position,
                'email' => $request->email ?? $user->email,
                'phone' => $request->phone ?? $user->phone,
                'image' => $logoImage,
                'password' => $password
            ];

            User::where('id', $id)->update($data);
            $message =   auth()->guard('web')->user()->name . ' ' . auth()->guard('web')->user()->surname . ' məlumatınız yeniləndi';
            $log_data = [
                'user_id' => auth()->guard('web')->user()->id,
                'table' => 'users',
                'action' => 'settings_update',
                'description' =>$message,
                'ip' => $_SERVER['REMOTE_ADDR']
            ];
            LogHelper::user_company_log($log_data);
            return   ['success' => true, 'message' => $message];
        }catch (\Exception $exception){
            $log_data = [
                'user_id' => auth()->guard('web')->user()->id,
                'table' => 'users',
                'action' => 'settings_update',
                'description' => 'Error. ' . auth()->guard('web')->user()->name . ' ' . auth()->guard('web')->user()->surname . ' məlumatınız yenilənmədi',
                'ip' => $_SERVER['REMOTE_ADDR']
            ];
            LogHelper::user_company_log($log_data);
            return response()->json(['success' => false,'errors' => 'Xəta baş verdi: ' . $exception->getMessage()]);
        }

    }

    public function subCategory($id)
    {
        $categories = Category::where('parent_id', $id)->orderBy('name', 'ASC')->get();
        return response()->json($categories);
    }

    public function follower()
    {
        $user = auth()->guard('web')->user();
        $jobFollower = Follower::with(['job'])->where('followers.user_id', $user->id)->orderBy('followers.id', 'DESC')->paginate(1);
        return view('web.users.follower', compact('jobFollower'));
    }

    public function userAppeal()
    {
        $user = auth()->guard('web')->user();
        $jobs = JobContact::where('user_id', $user->id)->with(['company','job','user'])->orderBy('id', 'DESC')->paginate(10);
        return view('web.users.user-appeal', compact('jobs'));
    }
    public function companyAppeal()
    {
        $user = auth()->guard('web')->user();
        $jobs = JobContact::where('user_id', $user->id)->with(['company','job','user'])->orderBy('id', 'DESC')->paginate(10);
        return view('web.users.company-appeal', compact('jobs'));
    }
}
