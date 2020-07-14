<?php

namespace App\Helpers;

use Illuminate\Database\Eloquent\Model;

class AliasProcessor
{

    /**
     * Creates the Alias from the Name or Title
     * in the suitable way to be the Url-Route
     * @param string $text
     * @param Model $model
     * @return string
     */
    public static function getAlias(string $text, Model $model)
    {
        $symbols = trim(preg_replace('/[\n\r]{2,}/', "\n", $text));
        $wordsArray = explode(' ', $symbols);
        $wordsArray = array_slice($wordsArray, 0, 5);
        $symbols = implode(' ', $wordsArray);
        $symbols = mb_strtolower($symbols);
        $str = $symbols;
        $len = mb_strlen($str);
        $chars = [];
        for ($k = 0; $k < $len; $k++) {
            $chars[] = mb_substr($str, $k, 1);
        }
        $result = '';
        for ($i = 0; $i < count($chars); $i ++){
            $result .= self::changeSymbol($chars[$i]);
        }
        return self::getAliasUnique($result, $model);
    }

    /**
     * Handle the case if the alias is not unique
     * @param string $alias
     * @param Model $model
     * @return string
     */
    public static function getAliasUnique(string $alias, Model $model)
    {
        while ($model::where('alias', $alias)->exists())
            $alias .= 'I';
        return $alias;
    }

    /**
     * Replace Cyrillic characters with Latin
     * The 'Snake_Case' is implying (underscore on space)
     * @param $symbol
     * @return mixed
     */
    private static function changeSymbol($symbol)
    {
        $map = [' ' => '_','а' => 'a','б' => 'b','в' => 'v','г' =>'g','д' => 'd','е' => 'e','ё' => 'yo','.'=>'','%'=>'pc','='=>'',
            'ж' => 'zh', 'з' => 'z', 'и' => 'i', 'й' => 'j', 'і' => 'i', 'ї' => 'j', 'к' => 'k','л' => 'l',
            'м' => 'm','н' => 'n','о' => 'o', 'п' => 'p', 'р' => 'r', 'с' => 's', 'т' => 't', 'у' => 'u',
            'ф' => 'f', 'х' => 'h', 'ц' => 'c', 'ч' => 'ch','ш' => 'sh', 'щ' => 'shch', 'ъ' => '','ы' => 'y',
            'ь' => '', 'э' => 'e', 'ю' => 'yu','я' => 'ya','?' => '','!' => '', '/' => '', '\\' => '', ',' => '','"' => '', "'" => ''];
        return array_key_exists($symbol, $map) ? $map[$symbol] : $symbol;
    }
}