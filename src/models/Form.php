<?php

namespace portalium\site\models;

use portalium\helpers\ObjectHelper;

class Form
{
    const TYPE_INPUT            = 0;
    const TYPE_INPUTTEXT        = 1;
    const TYPE_INPUTPASSWORD    = 2;
    const TYPE_INPUTFILE        = 3;
    const TYPE_INPUTHIDDEN      = 4;
    const TYPE_TEXTAREA         = 5;
    const TYPE_CHECKBOX         = 6;
    const TYPE_CHECKBOXLIST     = 7;
    const TYPE_RADIO            = 8;
    const TYPE_RADIOLIST        = 9;
    const TYPE_LISTBOX          = 10;
    const TYPE_DROPDOWNLIST     = 11;
    const TYPE_WIDGET           = 12;

    public static function getTypes()
    {
        return ObjectHelper::getConstants('TYPE_',__CLASS__);
    }
}
