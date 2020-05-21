<?php

namespace App\Helpers;

class Helper
{
    public static function validCpf($cpf)
    {
        $cpf = preg_replace('/[^0-9]/is', '', $cpf);

        if (strlen($cpf) !== 11) {
            return false;
        }

        if (preg_match('/(\d)\1{10}/', $cpf)) {
            return false;
        }

        return true;
    }

    public static function validCnpj($cnpj)
    {
        $cnpj = preg_replace('/[^0-9]/is', '', $cnpj);

        if (strlen($cnpj) !== 14) {
            return false;
        }

        if (preg_match('/(\d)\1{10}/', $cnpj)) {
            return false;
        }

        return true;
    }
}
