<?php

/**
 * Klasa posiada metody do pracy z datami
 *
 */
class MDate {

    /**
     * Funkcja zwraca datę w takim formacie jaki sie poda w parametrze $format. Zwraca
     * polskie nazwy miesięcy i dni.  
     * 
     * @param string $format - Format daty jaki chcemy otrzymać. Dodatkowe parametry:
     * 	l - zwraca polską nazwę tygodnia
     * 	F - zwraca polską nazwe miesiąca
     * 	f - zwraca polską nazwę miesiąca w przypadku Dopełniacz
     * @param string/timestamp $timestamp - timestamp, bądź data w formacie Y-m-d lub Y-m-d H:i:s
     * @return string
     */
    static function date($format, $timestamp) {
        if (self::isString($timestamp)) {
            $timestamp = strtotime($timestamp);
        }

        $to_convert = array(
            'l' => array('dat' => 'N', 'str' => array('Poniedziałek', 'Wtorek', 'Środa', 'Czwartek', 'Piątek', 'Sobota', 'Niedziela')),
            'F' => array('dat' => 'n', 'str' => array('styczeń', 'luty', 'marzec', 'kwiecień', 'maj', 'czerwiec', 'lipiec', 'sierpień', 'wrzesień', 'październik', 'listopad', 'grudzień')),
            'f' => array('dat' => 'n', 'str' => array('stycznia', 'lutego', 'marca', 'kwietnia', 'maja', 'czerwca', 'lipca', 'sierpnia', 'września', 'października', 'listopada', 'grudnia'))
        );

        $pieces = preg_split('#[:/.\-, ]#', $format);

        if ($pieces) {
            if ($timestamp === null) {
                $timestamp = time();
            }
            foreach ($pieces as $datepart) {
                if (array_key_exists($datepart, $to_convert)) {
                    $replace[] = $to_convert[$datepart]['str'][(date($to_convert[$datepart]['dat'], $timestamp) - 1)];
                } else {
                    $replace[] = date($datepart, $timestamp);
                }
            }
            return str_replace($pieces, $replace, $format);
        }
    }

    /**
     * Sprawdza czy data jest w formacie Y-m-d lub Y-m-d H:i:s
     * @param string $date
     * @return bool
     */
    static function isString($date) {
        if (preg_match('/^[0-9]{4}-[0-9]{2}-[0-9]{2}$/', $date) > 0) {
            return true;
        }

        if (preg_match('/^[0-9]{4}-[0-9]{2}-[0-9]{2}\s[0-9]{2}:[0-9]{2}:[0-9]{2}$/', $date) > 0) {
            return true;
        }

        return false;
    }

}