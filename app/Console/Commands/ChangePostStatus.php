<?php

namespace App\Console\Commands;

use App\DTO\PostDTO;
use App\Enums\PostStatus;
use App\Models\User;
use App\Services\PostService;
use Illuminate\Console\Command;

class ChangePostStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'change:post:status
     {status=active : new status for the post}
     {--withoutOutput : silent}
     {--option1=*}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Change post status';

    private function getStatus(): string
    {
        return $this->argument('status') ?? PostStatus::Active->value;
    }

    public function getPostService(): PostService
    {
        return app(PostService::class);
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $author = User::find(1);
        $status = $this->getStatus();
        $statusEnum = PostStatus::from($status);
        $post = new PostDTO(
            1, 'title 123',
            'title-12345',
            'text text',
            $author,
            $statusEnum
        );


        //dd($this->option('option1'));

        $this->getPostService()->update(1, $post);
        if ($this->option('withoutOutput')) {

        } else {
            $this->line(serialize($post));
        }
        echo '1111';
        return Command::SUCCESS;
    }
}
