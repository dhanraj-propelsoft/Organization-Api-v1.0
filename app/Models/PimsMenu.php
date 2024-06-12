<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PimsMenu extends Model
{
    use HasFactory,SoftDeletes;
    protected $table = 'pims_menus';

    public function activeStatus()
    {
        return $this->hasOne(ActiveStatus::class, 'id', 'pfm_active_status_id');
    }

    public function module()
    {
        return $this->hasOne(PimsModule::class, 'id', 'module_id');
    }
}
