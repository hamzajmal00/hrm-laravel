<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\InviteRequest;
use Mail;
use App\Mail\OrgnizationMail;
use App\Mail\EmployeeMail;

class InvitationController extends Controller
{
    // invite orginizations
    public function Orgnization(InviteRequest $request){

        $email = $request->email;
        $userMail = 'hm@dfdf.com';

        Mail::to($email)->send(new OrgnizationMail($userMail));
        return response([
            'message' => 'Invitation Mail send on  email'
        ],200);

    }
    // invite Employee
    public function Employee(InviteRequest $request){

        $email = $request->email;
        $userMail = 'hm@dfdf.com';

        Mail::to($email)->send(new EmployeeMail($userMail));
        return response([
            'message' => 'Invitation Mail send on  email'
        ],200);

    }
}
