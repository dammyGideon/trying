<?php

namespace App\Repositories\Auth;

use App\Mail\Forgotpassword;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use JasonGuru\LaravelMakeRepository\Repository\BaseRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\PasswordReset;
use Nette\Schema\ValidationException;
use Illuminate\Support\Facades\Response;

/**
 * Class UserRepository.
 */
class UserRepository extends BaseRepository
{

    public function model()
    {
        return User::class;
    }

    public function parent_reg($user_data)
    {
        $users_email = DB::table('users')->where('email', $user_data->input('email'))->value('email');

        if ($users_email == '') {
            $newParent = new User();
            $newParent->email=$user_data->input('email');
            $newParent->password= Hash::make($user_data->input('password'));
            $newParent->save();
            $newParent->assignRole('parent');

            $files = $user_data->file('parent_photo');
            $filename = $user_data->parent_photo->getClientOriginalName();
            $destinationPath = public_path('/profile/images');
            $files->move($destinationPath, $filename);

            $imagePath = $filename;

            DB::table('parents')
                ->insert([
                    'user_id'=>$newParent->id,
                    'parent_name'=>$user_data->input('parent_name'),
                    'parent_number'=>$user_data->input('parent_number'),
                    'parent_dob'=>$user_data->input('parent_dob'),
                    'parent_photo'=>$imagePath
                ]);

            return[
                "status"=>true,
                "response"=>"Parent registration successful"
            ];

        }else{
            $response = [
                "message" => "This User already exist"
            ];
            return response()->json($response);
        }

    }


    public function authenticateUser($usersData)
    {
        $data = $usersData->validate([
            'email' => 'email|required',
            'password' => 'required'
        ]);

        if (!auth()->attempt($data)) {
            return response([
                'error_message' =>
                    'Incorrect Email and password'
            ]);
        }

        $token = auth()->user()->createToken('token')->accessToken;

        return response([
             'status'=>true,
            'role' =>auth()->user()->getRoleNames(),
             'response'=>'Login Successful',
              'token' => $token
            ]);
    }

    public function forgot_password($user_email)
    {
        $email= DB::table('users')->where('email', $user_email->input('email'))->value('email');

        if (!empty($email)) {
           $status= Password::sendResetLink(
               $user_email->only('email')
           );
            switch ($status) {
                case Password::RESET_LINK_SENT:
                    return Response::json(array("status" => 200, "message" => trans($status), "data" => array()));
                case Password::INVALID_USER:
                    return Response::json(array("status" => 400, "message" => trans($status), "data" => array()));
            }

        } else{
            return response()->json(['message'=>'Email does not match']);
        }
    }

    public  function reset_password($user_data){

        $status= Password::reset(
            $user_data->only('email','password','password_confirmation','token'),
            function($user) use ($user_data){
                $user->forceFill([
                   'password'=>Hash::make($user_data->input('password')),
                   'remember_token'=>Str::random(60),
                ])->save();

                event(new PasswordReset($user));
            }
        );
        if($status == Password::PASSWORD_RESET){
            return response()->json(["message"=>"password reset successfully "]);
        }

        return response(
            [
                'message'=>__($status)
            ],500
        );

    }

    public function singleUser()
    {
        $user=Auth::user()->getAuthIdentifier();
        $user_profile=DB::table('parents')->where('user_id',$user)->get();
        return response()->json(
            [
             "authenticated_user"=>Auth::user()->email,
                "user"=>$user_profile
            ]);
    }

    public function profilePicture($profile){

        $user_profile= auth()->user()->getAuthIdentifier();
        $files = $profile->file('image');
        $filename = $profile->image->getClientOriginalName();
        $destinationPath = public_path('/profile/images');
        $files->move($destinationPath, $filename);

        $imagePath = $filename;
        DB::table('users')
            ->where('id',$user_profile)
            ->update(['uploads'=>$imagePath]);

        return[
            "status"=>true,
            "message"=>"image uploaded"
        ];

    }

    public function updateProfile($update_profile){
        $auth=Auth::user()->id;

        DB::table('parents')->where('user_id',$auth)->update([
           'parent_name'=>$update_profile->input('parent_name'),
            'parent_number'=>$update_profile->input('parent_number'),
            'parent_dob'=>$update_profile->input('parent_dob')
        ]);

        DB::table('users')->where('id',$auth)->update([
           'email'=>$update_profile->input('email'),
            'password'=>hash::make($update_profile->input('password'))
        ]);

        return[
            "status"=>true,
            "response"=>"Profile as been updated"
        ];
    }

}
