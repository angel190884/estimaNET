<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Requests;
class DateController extends Controller
{
    public static function ChangeDate($date)
    {
        $arraydate = explode("-", $date);
        return  $arraydate[2].'-'.$arraydate[1].'-'.$arraydate[0];
    }
    public static function ChangeDateLetter($date)
    {
        if ($date=='0000-00-00'){
            return '------';
        }
        $mes='';
        $arraydate = explode("-", $date);

        if ($arraydate[1]=='01'){
            $mes='ENERO';
        }
        if ($arraydate[1]=='02'){
            $mes='FEBRERO';
        }
        if ($arraydate[1]=='03'){
            $mes='MARZO';
        }
        if ($arraydate[1]=='04'){
            $mes='ABRIL';
        }
        if ($arraydate[1]=='05'){
            $mes='MAYO';
        }
        if ($arraydate[1]=='06'){
            $mes='JUNIO';
        }
        if ($arraydate[1]=='07'){
            $mes='JULIO';
        }
        if ($arraydate[1]=='08'){
            $mes='AGOSTO';
        }
        if ($arraydate[1]=='09'){
            $mes='SEPTIEMBRE';
        }
        if ($arraydate[1]=='10'){
            $mes='OCTUBRE';
        }
        if ($arraydate[1]=='11'){
            $mes='NOVIEMBRE';
        }
        if ($arraydate[1]=='12'){
            $mes='DICIEMBRE';
        }


        return strtoupper($arraydate[2].' de '.$mes.' del '.$arraydate[0]);
    }
}
