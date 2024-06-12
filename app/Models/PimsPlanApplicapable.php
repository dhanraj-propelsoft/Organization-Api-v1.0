<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Organization\OrganizationPatterns;

class PimsPlanApplicapable extends Model
{
    use HasFactory,SoftDeletes;
    protected $table = 'pims_plan_applicapables';

    public function activeStatus()
    {
        return $this->hasOne(ActiveStatus::class, 'id', 'pfm_active_status_id');
    }

    public function plan()
    {
        return $this->hasOne(PimsPlan::class, 'id', 'plan_id');
    }

    public function menu()
    {
        return $this->hasOne(PimsMenu::class, 'id', 'menu_id');
    }


    // public function plan()
    // {
    //     return $this->belongsTo(PimsPlan::class, 'plan_id', 'id');
    // }

    // public function packageApplicable()
    // {
    //     return $this->belongsTo(PimsPackageApplicable::class, 'package_applicable_id', 'id');
    // }

    // public function module()
    // {
    //     return $this->belongsTo(PimsModule::class, 'module_id', 'id');
    // }

    // public function getModuleNameAttribute()
    // {
    //     if ($this->module) {
    //         return $this->module->module_name;
    //     }
    //     return null;
    // }

}
