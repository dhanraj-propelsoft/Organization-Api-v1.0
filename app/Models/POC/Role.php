<?php

namespace App\Models\POC;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;
    protected $connection;
    
    public function __construct(){
        parent::__construct();
        $this->connection = "mysql_external";
    }
    public function module()
    {
        return $this->hasOne(MemberModulePermissionPoc::class, 'role_id', 'id');
    }
    
    public function menu()
    {
        return $this->hasOne(MemberMenuPermissionPoc::class, 'role_id', 'id');
    }
}
