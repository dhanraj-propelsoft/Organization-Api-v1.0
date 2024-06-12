<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PimsMenuFunction extends Model
{
    use HasFactory,SoftDeletes;
    protected $table = 'pims_menu_functions';

    public function activeStatus()
    {
        return $this->hasOne(ActiveStatus::class, 'id', 'pfm_active_status_id');
    }

    public function menu()
    {
        return $this->hasOne(PimsMenu::class, 'id', 'menu_id');
    }
}
