<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PimsPlan extends Model
{
    use HasFactory,SoftDeletes;
    protected $table = 'pims_plans';

    public function activeStatus()
    {
        return $this->hasOne(ActiveStatus::class, 'id', 'pfm_active_status_id');
    }

    public function packageApplicable()
    {
        return $this->hasOne(PimsPackageApplicable::class, 'id', 'package_applicapable_id');
    }
}
