<?php

namespace App\Console\Commands;

use App\Models\Category;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;

class FixCategorySlug extends Command
{
    protected $signature = 'app:slug-cat-fix';

    protected $description = 'Fix category slug';

    public function handle()
    {
        $bar = $this->output->createProgressBar(Category::count());
        $bar->start();
        Category::query()->chunk(50, function (Collection $items) use ($bar) {
            $items->map(function (Category $category) use ($bar) {
                $bar->advance();
                if (!str($category->slug)->contains('/')) {
                    return;
                }
                $category->slug = str($category->slug)->replace('/', '--');
                $category->save();
            });
        });
        $bar->finish();
        return self::SUCCESS;
    }
}
