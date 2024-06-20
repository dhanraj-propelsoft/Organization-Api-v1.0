<?php

namespace App\Models\POC;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MemberMenuFunctionPermissionPoc extends Model
{
    use HasFactory;
    
    protected $connection;

    public function __construct()
    {
        parent::__construct();
        $this->connection = "mysql_external";
    }
}
