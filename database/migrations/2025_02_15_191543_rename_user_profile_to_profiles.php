<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::rename('user_profile', 'profiles');
    }

    public function down()
    {
        Schema::rename('profiles', 'user_profile');
    }
};
