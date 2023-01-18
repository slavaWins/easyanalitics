<?php

namespace SlavaWins\EasyAnalitics\Library;


use SlavaWins\EasyAnalitics\Models\EasyAnalitics;
use SlavaWins\EasyAnalitics\Models\EasyAnaliticsSetting;
use Carbon\Carbon;

/**
 * @property EasyAnalitics[] $data
 */
class EasyAnaliticsStruct
{

    public $data;
    public EasyAnaliticsSetting $setting;
    public int $min;
    public int $max;


}
