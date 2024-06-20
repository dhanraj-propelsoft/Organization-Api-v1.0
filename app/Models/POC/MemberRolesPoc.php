<?php

namespace App\Models\POC;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MemberRolesPoc extends Model
{
    use HasFactory;
    protected $connection;
    
    public function __construct(){
        parent::__construct();
        $this->connection = "mysql_external";
    }
    protected $table = 'member_roles_pocs';

    public function role()
    {
        return $this->hasOne(Role::class, 'id', 'role_id');
    }
}
