<?php

namespace App\Console\Commands;

use App\Models\QuestionBank;
use Illuminate\Console\Command;

class GenerateQuestionIndex extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'question:index';

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
        // QuestionBank::createIndex($shards = null, $replicas = null);
        // QuestionBank::putMapping($ignoreConflicts = true);
        QuestionBank::addAllToIndex();
        $this->info('Question index generated successfully!');
    }
}
