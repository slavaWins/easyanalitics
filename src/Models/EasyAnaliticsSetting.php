<?php

namespace SlavaWins\EasyAnalitics\Models;

use SlavaWins\EasyAnalitics\Library\EasyAnaliticsStruct;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


/**
 * @property int id
 * @property string ind
 * @property string name
 * @property string descr
 *
 **/
class EasyAnaliticsSetting extends Model
{

    /**
     * Генерация воронки продаж из нескольких аналитик
     * @param array $ind массив из аналитик по порядку ['reg','confirm_email','pay']
     * @param $forDays
     * @return EasyAnaliticsStruct|null
     */
    public static function VoronkaGen(array $inds, $forDays = 30)
    {
        $listSetting = [];
        foreach ($inds as $ind) {
            $setting = self::GetAnaliticsData($ind, $forDays);
            if (!$setting) continue;
            if (count($setting->data) < 2) continue;

            $listSetting[] = $setting;

        }

        if(count($listSetting)<2)return null;

        $listDate = [];
        foreach ($listSetting as $setting) {

            foreach ($setting->data as $item) {

                if (!isset($listDate[$item->date_day])) {
                    $listDate[$item->date_day] = [
                        'settings' => [],
                        'max' => 0,
                    ];
                }
                $listDate[$item->date_day]['settings'][$item->ind] = $item->amount;
            }
        }
        $listDate = collect($listDate);
        $needCount = count($listSetting);

        $listDate = $listDate->filter(function ($day) use ($needCount) {
            return count($day['settings']) == $needCount;
        });

        $matrixVal = [];
        foreach ($listDate as $day) {
            foreach ($day['settings'] as $K => $V) {
                if (!isset($matrixVal[$K])) $matrixVal[$K] = [
                    'val' => 0,
                    'percent' => 0,
                ];
                $matrixVal[$K]['val'] += $V;
            }
        }
        $maxVal = 0;
        foreach ($matrixVal as $K => $V) $matrixVal[$K]['val'] = round($V['val'] / count($listDate));
        foreach ($matrixVal as $K => $V) $maxVal = max($maxVal, $V['val']);
        foreach ($matrixVal as $K => $V) $matrixVal[$K]['percent'] = round($V['val'] / $maxVal * 100);

        foreach ($listSetting as $V) {
            $matrixVal[$V->setting->ind]['name'] = $V->setting->name;
        }

        foreach ($matrixVal as $K => $V) {
            if (!isset($V['val'])) return null;
        }
        // dd($listDate);
        return $matrixVal;
    }

    public static function GetAnaliticsData($ind, $forDays = 30)
    {

        $setting = self::FindByInd($ind);
        if (!$setting) return null;

        /** @var EasyAnaliticsStruct $sturctdata */
        $sturctdata = new EasyAnaliticsStruct();
        $sturctdata->setting = $setting;
        $sturctdata->data = $setting->GetAnalitics($forDays);

        $sturctdata->max = 0;
        $sturctdata->min = 100000000000;
        foreach ($sturctdata->data as $V) {
            $sturctdata->max = max($V->amount, $sturctdata->max);
            $sturctdata->min = min($V->amount, $sturctdata->min);
        }

        return $sturctdata;
    }

    public static function FindByInd($ind)
    {
        return EasyAnaliticsSetting::where('ind', $ind)->first();
    }

    public function GetAnalitics($forDays = 30)
    {
        $list = EasyAnalitics::where("ind", $this->ind)->orderBy("id")->get(); //С
        return $list;
    }
}
