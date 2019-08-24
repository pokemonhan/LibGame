<?php namespace App\Lib\Game\Method\Pk10\CDY;

//　猜冠军 单式
use App\Lib\Game\Method\Pk10\Base;

class PKQZX1_S extends Base
{
    public static $filterArr = ['0' => 1, '1' => 1, '2' => 1, '3' => 1, '4' => 1, '5' => 1, '6' => 1, '7' => 1, '8' => 1, '9' => 1];

    //　供测试用 生成随机投注
    public function randomCodes()
    {
        $rand = rand(1, 10);
        return implode('&', (array)array_rand(self::$filterArr, $rand));
    }

    public function fromOld($sCodes)
    {
        return implode('&', explode('|', $sCodes));
    }

    public function regexp($sCodes)
    {
        //　格式
        if (!preg_match('/^(?!\|)(?!.*\|$)(?!.*?\d\d)([\d]\|?)*$/', $sCodes)) {
            return false;
        }

        $aCode = explode('|', $sCodes);

        //　去重
        if(count($aCode) != count(array_filter(array_unique($aCode)))) return false;

        //　校验
        foreach ($aCode as $_code) {
            if (!isset(self::$filterArr[$_code])) {
                return false;
            }
        }

        return true;
    }

    public function count($sCodes)
    {
        return count(explode(',', $sCodes));
    }

    //　判定中奖
    public function assertLevel($levelId, $sCodes, Array $numbers)
    {
        $str    = implode(' ', $numbers);
        $aCodes = explode(',', $sCodes);

        foreach ($aCodes as $code) {
            if ($code === $str) {
                return 1;
            }
        }
    }
}
