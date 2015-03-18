<?php

if (! function_exists('array_column')) {

    function array_column($array, $column, $key = null)
    {
        $output = [];
        
        array_walk($array, function ($value) use(&$output, $column, $key)
        {
            if (isset($value[$column])) {
                if (null === $key) {
                    $output[] = $value[$column];
                } else {
                    $output[$value[$key]] = $value[$column];
                }
            }
        });
        
        return $output;
    }
}

if (! function_exists('pr')) {

    function pr($data, $return = false)
    {
        $output = '<pre>' . print_r($data, true) . '</pre>';
        return ! $return ? print $output : $output;
    }
}

if (! function_exists('zero_fill')) {

    /**
     * Preenche os números com zero a esquerda
     * 
     * @param int $number            
     * @param int $padLength
     *            = o tamanho o preencimento
     * @return string
     */
    function zero_fill($number, $padLength = 0)
    {
        return sprintf("%0{$padLength}s", $number);
    }
}

if (! function_exists('humanize'))
{
    /**
    * @param $str  = uma string a ser humanizada 
    * @return string
    */
    function humanize($str)
    {

        $replacers = [
            '/[_-]+/u'       => ' ',
            '/[^\d\w\s]+/ui' => '',
            
        ];

        return mb_convert_case(
            preg_replace(
                array_keys($replacers),
                $replacers,
                trim($str)
            ),
            MB_CASE_TITLE,
            'UTF-8'
        );
    }
}