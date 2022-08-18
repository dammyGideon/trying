<?php

namespace App\Repositories\SuperAdmin;

use App\Models\UserProfile;
use JasonGuru\LaravelMakeRepository\Repository\BaseRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
/**
 * Class SuperProfileRepository.
 */
class SuperProfileRepository extends BaseRepository
{

    public function model()
    {
        return UserProfile::class;
    }

    




}
