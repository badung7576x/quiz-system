<?php

namespace App\Console\Commands;

use App\Models\Question;
use Illuminate\Console\Command;

class GenerateQuestionIndex extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'question:generate-index';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate question index for elasticsearch';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('Generating question index...');
        Question::createIndex($shards = null, $replicas = null);
        Question::putMapping($ignoreConflicts = true);
        Question::addAllToIndex();
        $this->info('Question index generated successfully!');
    }
}
