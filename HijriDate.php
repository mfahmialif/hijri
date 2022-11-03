<?php
class HijriDate
{
    public static function gregorianToHijri($GYear, $GMonth, $GDay)
    {
        $y = $GYear;
        $m = $GMonth;
        $d = $GDay;
        $jd = GregoriantoJD($m, $d, $y);
        $l = $jd - 1948440 + 10632;
        $n = (int) (($l - 1) / 10631);
        $l = $l - 10631 * $n + 354;
        $j = ((int) ((10985 - $l) / 5316)) * ((int) ((50 * $l) / 17719)) + ((int) ($l / 5670)) * ((int) ((43 * $l) / 15238));
        $l = $l - ((int) ((30 - $j) / 15)) * ((int) ((17719 * $j) / 50)) - ((int) ($j / 16)) * ((int) ((15238 * $j) / 43)) + 29;
        $m = (int) ((24 * $l) / 709);
        $d = $l - (int) ((709 * $m) / 24);
        $y = 30 * $n + $j - 30;

        $hijri = (object) [
            "year" => $y,
            "month" => $m,
            "day" => $d
        ];

        $bulanHijriah = array(
            1 => "Muharram", "Shafar", "Rabi'ul Awwal", "Rabi'ul Akhir",
            "Jumadil Ula", "Jumadil Akhirah", "Rajab", "Sya'ban",
            "Ramadan", "Syawwal", "Dzulqaidah", "Dzulhijjah"
        );

        $tanggal = $hijri->day;
        $bulan = $bulanHijriah[$hijri->month];
        $tahun = $hijri->year;

        $gregorian = (object) [
            "year" => $GYear,
            "month" => $GMonth,
            "day" => $GDay
        ];

        $data = (object) [
            "hijri" => $hijri,
            "value" => "$tanggal $bulan $tahun",
            "gregorian" => $gregorian
        ];

        return $data;
    }

    public static function hijriToGregorian($HYear, $HMonth, $HDay)
    {
        $jd = (int)((11 * $HYear + 3) / 30) + 354 * $HYear +
            30 * $HMonth - (int)(($HMonth - 1) / 2) + $HDay + 1948440 - 385;

        $gregorian = jdtogregorian($jd);
        $gregorian = date("Y-m-d", strtotime($gregorian));

        $hijri = (object) [
            "year" => $HYear,
            "month" => $HMonth,
            "day" => $HDay
        ];

        $data = (object) [
            "gregorian" => $gregorian,
            "hijri" => $hijri
        ];
        return $data;
    }
}
