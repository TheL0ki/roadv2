<?php

namespace App\Http\Controllers;

use App\Models\Shift;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\File;

class SettingsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();

        return view('settings', [
            'shifts' => Shift::query()
                ->where('isHoliday', 0)
                ->where('active', 1)
                ->whereNull('deletedAt')
                ->orderBy('name')
                ->get(),
            'selectedShiftIds' => $user->reminderShifts()->pluck('shifts.id'),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $userAttributes = $request->validate([
            'email' => ['required', 'email'],
            'userId' => ['required'],
            'profilePic' => ['nullable', 'file', File::types(['png', 'jpg', 'jpeg', 'webp', 'gif'])],
            'reminderShifts' => ['nullable', 'array'],
            'reminderShifts.*' => ['integer'],
        ]);

        $user = User::find($userAttributes['userId']);

        $user->email = $userAttributes['email'];
        $user->highlight_current_user_row = $request->boolean('highlightCurrentUserRow');
        $user->email_shift_reminder = $request->boolean('emailShiftReminder');
        if (isset($userAttributes['profilePic'])) {
            if ($user->profilePic !== null) {
                Storage::disk('public')->delete($user->profilePic);
            }
            $profilePicPath = $request->file('profilePic')->storePublicly('profilePic', 'public');
            $user->profilePic = $profilePicPath;
        }

        $user->save();
        $user->reminderShifts()->sync($this->reminderShiftIds($request));

        return redirect()->back()->with('feedback', 'profileUpdatedSuccess');
    }

    /**
     * @return list<int>
     */
    private function reminderShiftIds(Request $request): array
    {
        $requested = $request->input('reminderShifts', []);

        if (! is_array($requested) || $requested === []) {
            return [];
        }

        return Shift::query()
            ->whereIn('id', $requested)
            ->where('isHoliday', 0)
            ->where('active', 1)
            ->whereNull('deletedAt')
            ->pluck('id')
            ->all();
    }

    public function updatePassword(Request $request)
    {
        $userInput = $request->validate([
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user = User::find($request->userId);
        $user->password = bcrypt($userInput['password']);
        $user->save();

        return redirect()->back()->with('feedback', 'profileUpdatedSuccess');
    }
}
