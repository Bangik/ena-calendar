<?php

use Database\Seeders\CategorySeeder;
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
            $table->uuid('id')->primary();
            $table->foreignUuid('created_by')->constrained('users')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignUuid('updated_by')->constrained('users')->onUpdate('cascade')->onDelete('cascade');
            $table->string('name');
            $table->string('type');
            $table->string('icon')->nullable();
            $table->string('color', 50)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        $seed = new CategorySeeder();
        $seed->run();
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
