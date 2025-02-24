@php
    $classes = "py-2 px-4 rounded w-64";

    switch ($slot) {
        case 'savingError':
            $classes .=" bg-red-400 text-red-800";
            $heading = "Error";
            $message = "Something went wrong";
            break;
        case 'profileUpdatedSuccess':
            $classes .=" bg-green-400 text-green-700";
            $heading = "Success";
            $message = "Profile updated successfully";
            break;
        case 'teamActiveUser':
            $classes .=" bg-red-400 text-red-800";
            $heading = "Error";
            $message = "Team has active User";
            break;
        case 'userCreated':
            $classes .=" bg-green-400 text-green-700";
            $heading = "Success";
            $message = "User created successfully";
            break;
        case 'userUpdatedSuccess':
            $classes .=" bg-green-400 text-green-700";
            $heading = "Success";
            $message = "User updated successfully";
            break;
        case 'userDeleted':
            $classes .=" bg-green-400 text-green-700";
            $heading = "Success";
            $message = "User deleted successfully";
            break;
        case 'teamCreated':
            $classes .=" bg-green-400 text-green-700";
            $heading = "Success";
            $message = "Team created successfully";
            break;
        case 'teamUpdated':
            $classes .=" bg-green-400 text-green-700";
            $heading = "Success";
            $message = "Team updated successfully";
            break;
        case 'teamDeleted':
            $classes .=" bg-green-400 text-green-700";
            $heading = "Success";
            $message = "Team deleted successfully";
            break;
        default:
            $classes .=" bg-yellow-200";
            $heading = "Error";
            $message = "No feedback message provided";
            break;
    }
@endphp

<div class="absolute top-2 right-2 hidden" id="feedbackModal">
    <div {{ $attributes(['class' => $classes]) }}>
        <div class="font-bold border-b border-black/20 w-full">
            <h2>{{ $heading }}</h2>
        </div>
        <div>
            {{ $message }}
        </div>
    </div>
</div>