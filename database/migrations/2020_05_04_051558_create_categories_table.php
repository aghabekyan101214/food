<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string("name", 100);
            $table->string("slug", 191);
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->unsignedBigInteger('admin_id');
            $table->timestamps();

            $table->foreign('parent_id')->references('id')->on('categories')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('admin_id')->references('id')->on('admins')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('categories');
    }
}
