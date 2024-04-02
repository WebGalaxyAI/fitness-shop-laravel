<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
	public function up()
	{
		Schema::create('brands', static function (Blueprint $table) {
			$table->id();

            $table->string('name', 30);
            $table->string('slug', 30);
            $table->string('logo', 100)->nullable();
            $table->integer('order')->default(1);

			$table->timestamps();
            $table->softDeletes();
		});
	}

	public function down()
	{
        if (!app()->isLocal()) {
            return;
        }
		Schema::dropIfExists('brands');
	}
};
