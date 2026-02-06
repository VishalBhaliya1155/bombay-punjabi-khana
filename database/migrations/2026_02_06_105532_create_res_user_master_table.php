<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('res_user_master', function (Blueprint $table) {

            $table->bigIncrements('userid');
            $table->string('userfname');
            $table->string('userlname')->nullable();
                $table->string('mobile')->nullable()->unique();
               $table->string('email')->nullable()->unique();
            $table->string('userloginid')->unique();   // phone or username
            $table->string('userpassword');

            $table->enum('userrole', [
                'admin',
                'administrator',
                'agent',
                'customer'
            ]);

            $table->text('address')->nullable();

            $table->timestamps(); // created_at, updated_at
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('res_user_master');
    }
};
