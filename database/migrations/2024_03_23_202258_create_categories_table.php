<?php

use Fureev\Trees;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            Trees\Migrate::columns($table, (new \App\Models\Category())->getTreeConfig());
            $table->jsonb('name');
            $table->string('image', 100)->nullable();
            $table->string('slug', 70);
            $table->integer('order')->default(1);

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (!app()->isLocal()) {
            return;
        }
        Schema::dropIfExists('categories');
    }
};
