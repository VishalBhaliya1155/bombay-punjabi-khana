<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('res_item_master', function (Blueprint $table) {
            $table->id('item_id'); // Primary Key

            $table->string('name');

            $table->unsignedBigInteger('cat_id'); // Foreign Key
            $table->integer('price');

            $table->timestamps();

            // Foreign Key Relation
            $table->foreign('cat_id')
                ->references('cat_id')
                ->on('res_category_master')
                ->onDelete('cascade');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('res_item_master');
    }
};
