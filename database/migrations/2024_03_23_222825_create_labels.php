<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
	public function up()
	{
		Schema::create('labels', function (Blueprint $table) {
			$table->id();
            $table->string('code', 50)->unique()->index();
            $table->string('color', 50);
            $table->jsonb('name');
			$table->timestamps();
            $table->softDeletes();
		});
	}

	public function down()
	{
        if (!app()->isLocal()) {
            return;
        }
		Schema::dropIfExists('labels');
	}
};
