<?php


namespace App\Interfaces;


interface IOtpRepository
{
    public function generate($type,$code,$id);
    public function verify($id,$pin);
    public function verifyforgotpassword($id,$pin);
}