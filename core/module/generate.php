<?php

class Generate
{

    /*
     * method @genRandomString
     *
     * $chars - set symbols or false
     * $max - set maximum length after prefix
     * */

    function genRandomString($chars = false,
                             $max = false){
        $chars=(!$chars)?"1234567890qazxswedcvfrtgbnhyujmkiolp":$chars;
        $max=(!$max)?10:$max;
        $size=StrLen($chars)-1;
        $name=null;

        while($max--)
            $name.= $chars[rand(0,$size)];

        return "qx_".$name;
    }

    /*
     * method @rus2translit
     *
     * $string - set string ot transliterate
     * */

    function rus2translit($string) {
        $converter = array(
            'а' => 'a',   'б' => 'b',   'в' => 'v',
            'г' => 'g',   'д' => 'd',   'е' => 'e',
            'ё' => 'e',   'ж' => 'zh',  'з' => 'z',
            'и' => 'i',   'й' => 'y',   'к' => 'k',
            'л' => 'l',   'м' => 'm',   'н' => 'n',
            'о' => 'o',   'п' => 'p',   'р' => 'r',
            'с' => 's',   'т' => 't',   'у' => 'u',
            'ф' => 'f',   'х' => 'h',   'ц' => 'c',
            'ч' => 'ch',  'ш' => 'sh',  'щ' => 'sch',
            'ь' => '\'',  'ы' => 'y',   'ъ' => '\'',
            'э' => 'e',   'ю' => 'yu',  'я' => 'ya',

            ' ' => '_', '—' => '-', '–' => '-',

            'А' => 'A',   'Б' => 'B',   'В' => 'V',
            'Г' => 'G',   'Д' => 'D',   'Е' => 'E',
            'Ё' => 'E',   'Ж' => 'Zh',  'З' => 'Z',
            'И' => 'I',   'Й' => 'Y',   'К' => 'K',
            'Л' => 'L',   'М' => 'M',   'Н' => 'N',
            'О' => 'O',   'П' => 'P',   'Р' => 'R',
            'С' => 'S',   'Т' => 'T',   'У' => 'U',
            'Ф' => 'F',   'Х' => 'H',   'Ц' => 'C',
            'Ч' => 'Ch',  'Ш' => 'Sh',  'Щ' => 'Sch',
            'Ь' => '\'',  'Ы' => 'Y',   'Ъ' => '\'',
            'Э' => 'E',   'Ю' => 'Yu',  'Я' => 'Ya',

            //Укр алфавит
            'і' => 'i', 'ґ' => 'g', 'ї' => 'y', 'є' => 'e',
            'І' => 'I', 'Ґ' => 'G', 'Ї' => 'Y', 'Є' => 'E',
        );
        return strtr($string, $converter);
    }

    /*
     * method @str2url
     *
     * $str - set string to convert
     * */

    function str2url($str) {
        // переводим в транслит
        $str = $this->rus2translit($str);
        // в нижний регистр
        $str = strtolower($str);
        // заменям все ненужное нам на "-"
        $str = preg_replace('~[^-a-z0-9_]+~u', '-', $str);
        // удаляем начальные и конечные '-'
        $str = trim($str, "-");
        return $str;
    }

}