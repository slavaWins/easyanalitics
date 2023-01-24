<?php

namespace SlavaWins\EasyAnalitics\Console\Commands;

use SlavaWins\EasyAnalitics\Library\EasyAnaliticsHelper;
use SlavaWins\EasyAnalitics\Models\EasyAnalitics;
use SlavaWins\EasyAnalitics\Models\EasyAnaliticsSetting;
use Carbon\Carbon;
use Illuminate\Console\Command;

class GenereateItems extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'easyanalitics:items';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Гнереация тестовых данных аналитики';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }


    public function randText($data)
    {
        return $data[rand(0, count($data) - 1)];
    }


    public function handle()
    {

        $list = EasyAnaliticsSetting::all();


        if (!$list->count()) dd("Нет не одной аналитической модели EasyAnaliticsSetting!");

        foreach ($list as $easyAnaliticsSetting) {
            $this->info("Генерация рандомной аналитики для " . $easyAnaliticsSetting->name);

            $maxVal = rand(10, 1900);
            for ($i = rand(17, 28); $i >0; $i--) {
                EasyAnaliticsHelper::Increment($easyAnaliticsSetting->ind, rand($maxVal / 2, $maxVal), "","",Carbon::now()->addDays(-$i));
            }
        }
        $this->info("Процесс успешно выполнен!");
    }
}
