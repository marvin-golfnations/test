<?php

class Pdf
{
    var $TF;

    function pdf()
    {
        $this->TF = &get_instance();
        log_message('Debug', 'mPDF class is loaded.');
    }

    function load($param = NULL)
    {
        return new mPDF('','A4-L', 12, 10, 10, 10, 10);
    }
}