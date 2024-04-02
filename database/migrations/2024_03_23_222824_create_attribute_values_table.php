<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
	public function up()
	{
		Schema::create('attribute_values', function (Blueprint $table) {
			$table->id();

            $table->foreignIdFor(\App\Models\Attribute::class)
                ->constrained()->cascadeOnUpdate()->cascadeOnDelete();

            $table->string('code', 70);
            $table->jsonb('value');

			$table->timestamps();
		});
	}

	public function down()
	{
        if (!app()->isLocal()) {
            return;
        }
		Schema::dropIfExists('attribute_values');
	}
};
