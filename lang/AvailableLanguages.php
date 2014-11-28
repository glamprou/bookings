<?php

require_once(ROOT_DIR . 'lang/AvailableLanguage.php');

class AvailableLanguages
{
    /**
     * @return array|AvailableLanguage[]
     */
    public static function GetAvailableLanguages()
    {
        return array(
        			'gr_el' => new AvailableLanguage('gr_el', 'gr_el.php', 'Ελληνικά'),
        		);
    }
}

?>