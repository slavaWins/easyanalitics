<?php

namespace SlavaWins\EasyAnalitics\Library;


use SlavaWins\EasyAnalitics\Models\EasyAnalitics;
use SlavaWins\EasyAnalitics\Models\EasyAnaliticsSetting;
use Carbon\Carbon;

class EasyAnaliticsHelper
{

    /**
     * Инкрементировать аналитику по ключу на текущую дату
     * @param string $ind ключ аналитики например user_reg
     * @param int $val Количество действия которое добавится
     * @param Carbon|null $date Кастомная дата на которую нужно записать аналитику
     * @param string $defaultName Дефалтное название, что бы из кода сразу создать представление настроек
     * @return void
     */
    public static function Increment(string $ind, int $val = 1, string $defaultName = "No name", $descr = "", Carbon $date = null)
    {
        if (config('app.env') == 'testing') return;

        if (!$date) $date = Carbon::now();
        $dateString = $date->format("d.m.Y");

        $easyModel = EasyAnalitics::where("date_day", $dateString)->where("ind", $ind)->first();
        if ($easyModel) {
            $easyModel->amount += $val;
        } else {

            /** @var EasyAnaliticsSetting $setting */
            $setting = EasyAnaliticsSetting::where("ind", $ind)->first();
            if (!$setting) {
                $setting = new EasyAnaliticsSetting();
                $setting->name = ($ind . ' No named');
                if ($defaultName) $setting->name = $defaultName;
                $setting->ind = $ind;
                $setting->descr = $descr;
                $setting->save();
            }

            $easyModel = new EasyAnalitics();
            $easyModel->ind = $ind;
            $easyModel->amount = $val;
            $easyModel->date_day = $dateString;
        }
        $easyModel->save();

    }

}


