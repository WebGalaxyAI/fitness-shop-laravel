<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
	public function up()
	{
		Schema::create('product_category', static function (Blueprint $table) {
			$table->id();

            $table->foreignIdFor(\App\Models\Product::class)
                ->constrained()
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->foreignIdFor(\App\Models\Category::class)
                ->constrained()
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

			$table->timestamps();
		});
	}

	public function down()
	{
        if (!app()->isLocal()) {
            return;
        }
		Schema::dropIfExists('product_category');
	}
};
