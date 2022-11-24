<?php

namespace App\Console\Commands;

use App\Repo\Post\PostEloquentRepo;
use App\Services\TagService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\Console\Helper\ProgressBar;

class RefreshCache extends Command
{
    protected ProgressBar $bar;
    protected int $counter;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cache:refresh
    {--withoutOutput : silent}
    ';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Refreshing cache for general models';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $model = $this->choice('Enter model', ['Tag', 'Post', 'All']);

        if ($model === 'All') {
            $countSelected = 2;
        } else {
            $countSelected = 0;
        }


        $this->counter = 0;

        $this->bar = $this->output->createProgressBar($countSelected);
        $this->bar->start();
        switch ($model) {
            case 'Tag':

                $this->refreshTagsCache();
                break;
            case 'Post':

                $this->refreshPostsCache();
                break;
            case 'All':

                $this->refreshTagsCache();

                $this->refreshPostsCache();

                break;
        }

        $this->bar->finish();
        if (!$this->option('withoutOutput')) {

            $this->info(PHP_EOL . PHP_EOL . 'count refreshed models - ' . $this->counter .PHP_EOL );
        }

        return Command::SUCCESS;
    }

    public function refreshPostsCache()
    {
        $this->counter++;
        $this->bar->advance();
        Cache::tags('post_list')->flush();

        (new PostEloquentRepo())->all();
    }

    public function refreshTagsCache()
    {
        $this->counter++;
        $this->bar->advance();
        Cache::tags('tags')->flush();

        (new TagService())->getList();
    }
}
