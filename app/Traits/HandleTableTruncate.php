<?php

namespace App\Traits;

use Illuminate\Support\Facades\DB;

trait HandleTableTruncate
{
    public function truncateTable($table){
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table($table)->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
