<?php

namespace App\Repositories\Child;


use App\Models\User;
use Illuminate\Support\Facades\Auth;
use JasonGuru\LaravelMakeRepository\Repository\BaseRepository;
use Illuminate\Support\Facades\DB;
//use Your Model

/**
 * Class ChildRepository.
 */
class ChildRepository extends BaseRepository
{
    /**
     * @return string
     *  Return the model
     */
    public function model()
    {
        return User::class;
    }

    public function allChild(){
        $payload=DB::class('children')->get();
        return[
          "status"=>true,
            "response"=>$payload
        ];
    }

    public function parentChildren(){
        $auth=Auth::user()->id;
        $parent_id=DB::table('parents')->where('user_id',$auth)->value('id');

        $payload=DB::table('children')->where('parent_id',$parent_id)->get();
        return[
          "status"=>true,
            "response"=>$payload
        ];
    }

    public function singleChild($child){
        $auth=Auth::user()->id;
        $parent_id=DB::table('parents')->where('user_id',$auth)->value('id');

        $payload=DB::table('children')->where('id',$child)->get();
        return[
            "status"=>true,
            "response"=>$payload
        ];
    }

    public function childRegistration($children){
        $auth=Auth::user()->id;

        $parent_id=DB::table('parents')->where('user_id',$auth)->value('id');

        $parent_child= DB::table('children')
            ->where('parent_id',$parent_id)->where('child_name',$children->input('child_name'))
            ->value('id');



            if($children->hasFile('child_photo')) {

                $files = $children->file('child_photo');
                $filename = $children->child_photo->getClientOriginalName();
                $destinationPath = public_path('/children');
                $files->move($destinationPath, $filename);

                $imagePath = $filename;

                if(empty($parent_child)){


                    DB::table('children')->insert([
                    'parent_id'=>$parent_id,
                    'child_name'=>$children->input('child_name'),
                    'child_allergies'=>$children->input('child_allergies'),
                    'child_photo'=>$imagePath
                ]);

                return[
                    'status'=>true,
                    'response'=>"this particular child details was uploaded successful"
                ];
            }else{

                    return[
                        'status'=>true,
                        'response'=>"this particular child as been register by this parent"
                    ];
                }

        }



    }
}

