<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
	public function up()
	{
		Schema::create('attributes', function (Blueprint $table) {
			$table->id();

            $table->string('code', 50)->unique()->index();
            $table->jsonb('name');
            $table->string('frontend_type', 15)
                ->default('checkbox')
                ->comment('checkbox, radio, text, textarea');
            $table->boolean('is_required')->default(false);
            $table->boolean('is_filterable')->default(false);

			$table->timestamps();
            $table->softDeletes();
		});
	}

	public function down()
	{
        if (!app()->isLocal()) {
            return;
        }
		Schema::dropIfExists('attributes');
	}
};
