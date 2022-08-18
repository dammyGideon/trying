<?php

namespace App\Http\Controllers\Children;

use App\Http\Controllers\Controller;
use App\Http\Requests\Children\ChildrenCreationRequest;
use App\Models\Child;
use App\Repositories\Child\ChildRepository;
use Illuminate\Http\Request;

class ChildrenController extends Controller
{
    //

    public function childrenReg(ChildrenCreationRequest $request, ChildRepository $childRepository){
        return $childRepository->childRegistration($request);
    }
    public function parentChildren(ChildRepository $childRepository){
        return $childRepository->parentChildren();
    }
    public function singleChild($id, ChildRepository $childRepository){
        return $childRepository->singleChild($id);
    }
}
