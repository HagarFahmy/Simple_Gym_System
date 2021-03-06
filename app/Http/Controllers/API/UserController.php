<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller as Controller;
use App\Http\Resources\AttendanceResource;
use Illuminate\Support\Facades\Auth;
use App\Models\Revenue;
use App\Models\User;
use App\Models\Attendance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;



class UserController extends Controller
{
    public function remainingTrainingSessionsOfTheUser()
    {
        // Setting the id of the login user.
        $userId = Auth::id();
        // Initializing variable.
        $totalTrainingSessions = 0;
        // Getting all training packages that user already bought.
        $packages = Revenue::with('training_package_sessions')->where('user_id', $userId)->get();
        // If the user have packages.
        if ($packages != null) {
            foreach ($packages as $package) {
                // Fetching all total sessions count by this user.
                $totalTrainingSessions += $package->training_package_sessions[0]->sessions_number;
            }
            // Fetching all the user attendance
            $attendedSessions = Attendance::where('user_id', $userId)->count();
            $remainingTrainingSessions = $totalTrainingSessions - $attendedSessions;
        } else {
            // If the user did'nt bought any packages yet.
            return "Buy training packages first to proceed.";
        }

        // Returning JSON object of the info.
        return response()->json([
            'Total training sessions' => $totalTrainingSessions,
            'Remaining training sessions' => $remainingTrainingSessions,
        ]);
    }

    public function getAttendanceHistoryOfTheUser()
    {
        // Get the user id who logged in to fetch his data.
        $userID = Auth::id();
        // Returning user attendance history.
        return AttendanceResource::collection(User::where('id', $userID)->first()->attendances_sessions);
    }


    public function update(Request $request)
    {
        $user = Auth()->user(); // it should be $user = Auth::id();
        $validator = Validator::make($request->all(), [
            'name' => 'nullable',
            'email' => 'nullable|string|unique:users,email,' . $user->id,
            'gender' => 'nullable',
            'date_of_birth' => 'nullable',
            'profile_image' => 'nullable|image|mimes:jpg,jpeg',
            'password' => 'nullable|min:6',
            'gym_id' => 'nullable',

        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $user->name = $request->name ? $request->name : $user->name;
        $user->email = $request->email ? $request->email : $user->email;
        $user->gender = $request->gender ? $request->gender : $user->gender;
        $user->date_of_birth = $request->birth_date ? $request->date_of_birth : $user->date_of_birth;
        $user->password = $request->password ? $request->bcrypt($request->password) : $user->password;
        $user->profile_image = $request->profile_image ? $request->profile_image : $user->profile_image;

        $user->save();
        return $this->sendResponse($user, 'User updated successfully.');
    }
}
