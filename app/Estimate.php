<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use App\Http\Controllers\DateController;

class Estimate extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'number',
        'contract_id',
        'start',
        'finish',
        'release',
        'retention',
        'type'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [

    ];

    /**
     * Relation to Contract class
     * 
     * @return Illuminate\Database\Eloquent\Concerns\HasRelationships::belongsTo
     */
    public function contract()
    {
        return $this->belongsTo(Contract::class);
    }

    /**
     * Relation to Concept class
     * 
     * @return Illuminate\Database\Eloquent\Concerns\HasRelationships::belongsToMany
     */
    public function concepts()
    {
        return $this->belongsToMany(Concept::class)->withTimestamps();
    }

    /**
     * Relation to Generator class
     * 
     * @return Illuminate\Database\Eloquent\Concerns\HasRelationships::hasMany
     */
    public function generators()
    {
        return $this->hasMany(Generator::class);
    }

    /**
     * Relation to Deduction class
     * 
     * @return Illuminate\Database\Eloquent\Concerns\HasRelationships::belongsToMany
     */
    public function deductions()
    {
        return $this->belongsToMany(Deduction::class)->withTimestamps()->withPivot('factor');
    }

    /**
     * Return the start date with format.
     * 
     * @return string
     */
    public function getStartOkAttribute()
    {
        return Carbon::parse($this->start)->format('d-m-Y');
    }
    /**
     * Return the finish date with format.
     * 
     * @return string
     */
    public function getFinishOkAttribute()
    {
        return Carbon::parse($this->finish)->format('d-m-Y');
    }
    /**
     * Return the date of emission with format.
     * 
     * @return string
     */
    public function getReleaseOkAttribute()
    {
        return Carbon::parse($this->release)->format('d-m-Y');
    }
    /**
     * Return type. Retorna el tipo de estimacion con formato de letras.
     * 
     * @return string
     */
    public function getTypeOkAttribute()
    {
        switch ($this->type) {
        case 1:
            $type= 'NORMAL';
            break;
        case 2:
            $type= 'EXTRAORDINARIA';
            break;
        case 3:
            $type= 'FINAL';
            break;
        case 4:
            $type= 'COMBINADA';
            break;
        case 5:
            $type= 'FINAL COMBINADA';
            break;    
        default:
            $type= 'NO ESPECIFICADO';
        }
        return $type;
    }
    /**
     * Retorna la letra segun el tipo de la estimación.
     * 
     * @return string
     */
    public function getEstimateLetterAttribute()
    {
        if ($this->type=='N') {
            return strtoupper($this->getNumberEstimateLetterAttribute());
        }
        return strtoupper($this->getNumberEstimateLetterAttribute().' '.$this->getTypeOkAttribute());
    }
    /**
     * Retorna el numero de estimacion en formato de letras.
     * 
     * @return string
     */
    public function getNumberEstimateLetterAttribute()
    {
        return strtoupper($this->transformNumber($this->number));
    }

    /**
     * Retorna el tipo de estimacion en formato de letras.
     * 
     * @return string
     */
    public function getTypeEstimateAttribute()
    {
        if ($this->type=='1') {
            return 'NORMAL';
        }
        if ($this->type=='2') {
            return 'EXTRAORDINARIA';
        }
        if ($this->type=='4') {
            return 'COMBINADA';
        }
        if ($this->type=='3') {
            return 'FINAL';
        }
        if ($this->type=='5') {
            return 'COMBINADA FINAL';
        }
        return 'NO ESPECIFICADO';
    }

    /**
     * Retorna la fecha de entrega en formato de letras.
     * 
     * @return string
     */
    public function getDateOfDeliveryAttribute()
    {
        return DateController::ChangeDateLetter($this->release);
    }

    /**
     * Retorna el periodo de la estimacion en formato de letras.
     * 
     * @return string
     */
    public function getFormattedPeriodEstimateAttribute()
    {
        $periodStart=$this->getPeriodStartLetterAttribute();
        $periodFinish=$this->getPeriodFinishLetterAttribute();
        return strtoupper("del $periodStart al $periodFinish");
    }
    
    /**
     * Retorna la fecha de inicio de estimacion en formato de letras.
     * 
     * @return string
     */
    public function getPeriodStartLetterAttribute()
    {
        return DateController::ChangeDateLetter($this->start);
    }

    /**
     * Retorna la fecha de fin de estimacion en formato de letras.
     * 
     * @return string
     */
    public function getPeriodFinishLetterAttribute()
    {
        return DateController::ChangeDateLetter($this->finish);
    }
    /**
     * Retorna Monto total de la estimacion.
     * 
     * @return Float
     */
    public function getTotalEstimateAmountAttribute(Estimate $estimate=null)
    {
        if ($estimate!=null) {
            $amount=$this->estimateAmount($estimate);
            return $amount+$this->retention;
        }
        $amount=$this->estimateAmount;
        return $amount+$this->retention;
    }
    public function getEstimateAmountAttribute(Estimate $estimate=null)
    {
        if ($estimate!=null) {
            $total=0;
            if ($estimate->contract->type == 1) {
                if ($estimate->contract->split_catalog) {
                    $subGenerators = collect();
                    foreach ($estimate->generators as $generator) {
                        $subGenerators->push($generator->subGenerators);
                    }
                    foreach ($subGenerators->collapse()->sortBy('location.name') as $subGenerator) {
                        $total+=round($subGenerator->quantity * $subGenerator->generator->concept->unit_price, 2, PHP_ROUND_HALF_DOWN);
                    }
                } else {
                    foreach ($estimate->generators as $generator) {
                        $total+=round($generator->quantity * $generator->concept->unit_price, 2, PHP_ROUND_HALF_DOWN);
                    }
                }
            } elseif ($estimate->contract->type == 2) {
                if ($this->start >= $this->contract->date_finish_modified) {
                    $unitPrice=($this->contract->totalAmount + $this->contract->amount_adjustment) / 100;
                } else {
                    $unitPrice=$this->contract->originalAmount/100;
                }
                foreach ($estimate->generators as $generator) {
                    if ($generator->concept->immovable==false) {
                        $total+=round($generator->quantity * ($unitPrice), 2, PHP_ROUND_HALF_DOWN);
                    } else {
                        $total+=round($generator->quantity * ($this->contract->originalAmount/100), 2, PHP_ROUND_HALF_DOWN);
                    }
                }
            }
            return $total;
        }
        $total=0;
        if ($this->contract->type == 1) {
            if ($this->contract->split_catalog) {
                $subGenerators = collect();
                foreach ($this->generators as $generator) {
                    $subGenerators->push($generator->subGenerators);
                }
                foreach ($subGenerators->collapse()->sortBy('location.name') as $subGenerator) {
                    $total += round($subGenerator->quantity * $subGenerator->generator->concept->unit_price, 2, PHP_ROUND_HALF_DOWN);
                }
            } else {
                foreach ($this->generators as $generator) {
                    $total+=round($generator->quantity * $generator->concept->unit_price, 2, PHP_ROUND_HALF_DOWN);
                }
            }
        } elseif ($this->contract->type == 2) {
            if ($this->start >= $this->contract->date_finish_modified) {
                $unitPrice=($this->contract->totalAmount + $this->contract->adjustment_amount) / 100;
            } else {
                $unitPrice=$this->contract->originalAmount/100;
            }
            foreach ($this->generators as $generator) {
                if ($generator->concept->immovable==false) {
                    $total+=round($generator->total * ($unitPrice), 2, PHP_ROUND_HALF_DOWN);
                } else {
                    $total+=round($generator->total*($this->contract->originalAmount/100), 2, PHP_ROUND_HALF_DOWN);
                }
            }
        }
        return round($total, 2, PHP_ROUND_HALF_DOWN);
    }
    public function getIvaAttribute()
    {
        return round($this->totalEstimateAmount * 0.16, 2, PHP_ROUND_HALF_DOWN);
    }
    public function getIvaOkAttribute()
    {
        return '$ ' . $this->format($this->iva);
    }
    public function getTotalEstimateAmountOkAttribute()
    {
        return '$ ' . $this->format($this->totalEstimateAmount);
    }
    public function getTotalEstimateAmountWithIvaAttribute()
    {
        return $this->totalEstimateAmount + $this->iva;
    }
    public function getTotalEstimateAmountWithIvaOkAttribute()
    {
        return '$ ' . $this->format($this->totalEstimateAmountWithIva);
    }
    public function getTotalEstimatedAttribute()
    {
        return $this->totalEstimateAmountWithIva + $this->totalPreviousAmount;
    }
    public function getTotalEstimatedOkAttribute()
    {
        return '$ ' . $this->format($this->totalEstimated);
    }
    public function getTotalPreviousAmountAttribute()
    {
        $totalPrevious = 0;
        foreach ($this->previousEstimates($this)->get() as $estimate) {
            $totalPrevious+=$estimate->totalEstimateAmountWithIva;
        }
        return round($totalPrevious, 2, PHP_ROUND_HALF_DOWN);
    }
    public function getTotalPreviousAmountOkAttribute()
    {
        return '$ ' . $this->format($this->totalPreviousAmount);
    }

    /**
     * Query Scope.
     */

    public function scopePreviousEstimates($query, Estimate $estimate)
    {
        if ($estimate) {
            return $query->with('contract', 'generators', 'deductions')->where('number', '<', $estimate->number)
            ->where('contract_id', $estimate->contract->id);
        }
    }

    

    public function getTotalForExecuteAmountAttribute()
    {
        return round($this->contract->totalAmount - ($this->totalEstimateAmount + $this->totalPreviousAmount), 2, PHP_ROUND_HALF_DOWN);
    }

    public function getTotalForExecuteAmountOkAttribute()
    {
        return '$ ' . $this->format($this->totalForExecuteAmount);
    }

    public function getTotalDeductionsAmountAttribute()
    {
        $total = 0;
        foreach ($this->deductions()->get() as $sanction) {
            $percentage = ($sanction->percentage * $sanction->pivot->factor) / 100;
            $total += round($this->totalEstimateAmount *  $percentage, 2);
        }
        foreach ($this->contract->deductions()->get() as $deduction) {
            $percentage = ($deduction->percentage * $deduction->pivot->factor) / 100;
            $total += round($this->totalEstimateAmount *  $percentage, 2);
        }
        return $total;
    }
    public function getTotalDeductionsAmountOkAttribute()
    {
        return '$ ' . $this->format($this->totalDeductionsAmount);
    }
    public function getAmountNetOkAttribute()
    {
        return '$ ' . $this->format($this->totalEstimateAmount - $this->totalDeductionsAmount);
    }

    public function scopeGeneratorsPrevious()
    {
        return $generators=Generator::where('estimates.number', '<', $this->number)
            ->where('contracts.id', $this->contract->id)
            ->join('concepts', 'concepts.id', '=', 'concept_estimate.concept_id')
            ->join('estimates', 'estimates.id', '=', 'concept_estimate.estimate_id')
            ->join('contracts', 'contracts.id', '=', 'estimates.contract_id');
    }
    /**
     * Retorna el numero de la estimación en letras.
     *
     * @return string
     */
    private function transformNumber($number)
    {
        /*
        * todo cambiar if por switch
        */
        if ($number==0) {
            $numberLetter = "cero";
        } elseif ($number==1) {
            $numberLetter = "Uno";
        } elseif ($number==2) {
            $numberLetter = "Dos";
        } elseif ($number==3) {
            $numberLetter = "Tres";
        } elseif ($number==4) {
            $numberLetter = "Cuatro";
        } elseif ($number==5) {
            $numberLetter = "Cinco";
        } elseif ($number==6) {
            $numberLetter = "Seis";
        } elseif ($number==7) {
            $numberLetter = "Siete";
        } elseif ($number==8) {
            $numberLetter = "Ocho";
        } elseif ($number==9) {
            $numberLetter = "Nueve";
        } elseif ($number==10) {
            $numberLetter = "Diez";
        } elseif ($number==11) {
            $numberLetter = "Once";
        } elseif ($number==12) {
            $numberLetter = "Doce";
        } elseif ($number==13) {
            $numberLetter = "Trece";
        } elseif ($number==14) {
            $numberLetter = "Catorce";
        } elseif ($number==15) {
            $numberLetter = "Quince";
        } elseif ($number==16) {
            $numberLetter = "Dieciseis";
        } elseif ($number==17) {
            $numberLetter = "Decisiete";
        } elseif ($number==18) {
            $numberLetter = "Dieciocho";
        } elseif ($number==19) {
            $numberLetter = "Diecinueve";
        } elseif ($number==20) {
            $numberLetter = "Veinte";
        } elseif ($number==21) {
            $numberLetter = "Veintiuno";
        } elseif ($number==22) {
            $numberLetter = "Veintidos";
        } elseif ($number==23) {
            $numberLetter = "Veintitres";
        } elseif ($number==24) {
            $numberLetter = "Veinticuatro";
        } elseif ($number==25) {
            $numberLetter = "Veinticinco";
        } elseif ($number==26) {
            $numberLetter = "Veintiseis";
        } elseif ($number==27) {
            $numberLetter = "Veintisiente";
        } elseif ($number==28) {
            $numberLetter = "Veintiocho";
        } elseif ($number==29) {
            $numberLetter = "Veintinueve";
        } elseif ($number==30) {
            $numberLetter = "Treinta";
        } elseif ($number==31) {
            $numberLetter = "Treinta y uno";
        } elseif ($number==32) {
            $numberLetter = "Treinta y dos";
        } elseif ($number==33) {
            $numberLetter = "Treinta y tres";
        } elseif ($number==34) {
            $numberLetter = "Treinta y cuatro";
        } elseif ($number==35) {
            $numberLetter = "Treinta y cinco";
        } elseif ($number==36) {
            $numberLetter = "Treinta y seis";
        } elseif ($number==37) {
            $numberLetter = "Treinta y siete";
        } elseif ($number==38) {
            $numberLetter = "Treinta y ocho";
        } elseif ($number==39) {
            $numberLetter = "Treinta y nueve";
        } elseif ($number==40) {
            $numberLetter = "Cuarenta";
        } elseif ($number==41) {
            $numberLetter = "Cuarenta y uno";
        } elseif ($number==42) {
            $numberLetter = "Cuarenta y dos";
        } elseif ($number==43) {
            $numberLetter = "Cuarenta y tres";
        } elseif ($number==44) {
            $numberLetter = "Cuarenta y cuatro";
        } elseif ($number==45) {
            $numberLetter = "Cuarenta y cinco";
        } elseif ($number==46) {
            $numberLetter = "Cuarenta y seis";
        } elseif ($number==47) {
            $numberLetter = "Cuarenta y siete";
        } elseif ($number==48) {
            $numberLetter = "Cuarenta y ocho";
        } elseif ($number==49) {
            $numberLetter = "Cuarenta y nueve";
        } elseif ($number==50) {
            $numberLetter = "Cincuenta";
        } elseif ($number==51) {
            $numberLetter = "Cincuenta y uno";
        } elseif ($number==52) {
            $numberLetter = "Cincuenta y dos";
        } elseif ($number==53) {
            $numberLetter = "Cincuenta y tres";
        } elseif ($number==54) {
            $numberLetter = "Cincuenta y cuatro";
        } elseif ($number==55) {
            $numberLetter = "Cincuenta y cinco";
        } elseif ($number==56) {
            $numberLetter = "Cincuenta y seis";
        } elseif ($number==57) {
            $numberLetter = "Cincuenta y siete";
        } elseif ($number==58) {
            $numberLetter = "Cincuenta y ocho";
        } elseif ($number==59) {
            $numberLetter = "Cincuenta y nueve";
        } elseif ($number==60) {
            $numberLetter = "Sesenta";
        } elseif ($number==61) {
            $numberLetter = "Sesenta y uno";
        } elseif ($number==62) {
            $numberLetter = "Sesenta y dos";
        } elseif ($number==63) {
            $numberLetter = "Sesenta y tres";
        } elseif ($number==64) {
            $numberLetter = "Sesenta y cuatro";
        } elseif ($number==65) {
            $numberLetter = "Sesenta y cinco";
        } elseif ($number==66) {
            $numberLetter = "Sesenta y seis";
        } elseif ($number==67) {
            $numberLetter = "Sesenta y siete";
        } elseif ($number==68) {
            $numberLetter = "Sesenta y ocho";
        } elseif ($number==69) {
            $numberLetter = "Sesenta y nueve";
        } elseif ($number==70) {
            $numberLetter = "Setenta";
        } elseif ($number==71) {
            $numberLetter = "Setenta y uno";
        } elseif ($number==72) {
            $numberLetter = "Setenta y dos";
        } elseif ($number==73) {
            $numberLetter = "Setenta y tres";
        } elseif ($number==74) {
            $numberLetter = "Setenta y cuatro";
        } elseif ($number==75) {
            $numberLetter = "Setenta y cinco";
        } elseif ($number==76) {
            $numberLetter = "Setenta y seis";
        } elseif ($number==77) {
            $numberLetter = "Setenta y siete";
        } elseif ($number==78) {
            $numberLetter = "Setenta y ocho";
        } elseif ($number==79) {
            $numberLetter = "Setenta y nueve";
        } elseif ($number==80) {
            $numberLetter = "Ochenta";
        } elseif ($number==81) {
            $numberLetter = "Ochenta y uno";
        } elseif ($number==82) {
            $numberLetter = "Ochenta y dos";
        } elseif ($number==83) {
            $numberLetter = "Ochenta y tres";
        } elseif ($number==84) {
            $numberLetter = "Ochenta y cuatro";
        } elseif ($number==85) {
            $numberLetter = "Ochenta y cinco";
        } elseif ($number==86) {
            $numberLetter = "Ochenta y seis";
        } elseif ($number==87) {
            $numberLetter = "Ochenta y siete";
        } elseif ($number==88) {
            $numberLetter = "Ochenta y ocho";
        } elseif ($number==89) {
            $numberLetter = "Ochenta y nueve";
        } elseif ($number==90) {
            $numberLetter = "Noventa";
        } elseif ($number==91) {
            $numberLetter = "Noventa y uno";
        } elseif ($number==92) {
            $numberLetter = "Noventa y dos";
        } elseif ($number==93) {
            $numberLetter = "Noventa y tres";
        } elseif ($number==94) {
            $numberLetter = "Noventa y cuatro";
        } elseif ($number==95) {
            $numberLetter = "Noventa y cinco";
        } elseif ($number==96) {
            $numberLetter = "Noventa y seis";
        } elseif ($number==97) {
            $numberLetter = "Noventa y siete";
        } elseif ($number==98) {
            $numberLetter = "Noventa y ocho";
        } else {
            $numberLetter = "Noventa y nueve";
        }
        return $numberLetter; //Retornar el resultado
    }

    private function format($number)
    {
        $numbers= explode(".", $number);
        if (! isset($numbers[1])) {
            $numbers[1] = null;
        }
        if (strlen($numbers[1]) < 2) {
            return number_format($number, 2, '.', ',');
        } else {
            return number_format($numbers[0], 0, '.', ',').'.'.$numbers[1];
        }
    }

    public function getAmountNetLetterOkAttribute()
    {
        return $this->numtoletras($this->totalEstimateAmount - $this->totalDeductionsAmount);
    }

    public static function numtoletras($xcifra)
    {
        $xarray = array(0 => "Cero",
            1 => "UN", "DOS", "TRES", "CUATRO", "CINCO", "SEIS", "SIETE", "OCHO", "NUEVE",
            "DIEZ", "ONCE", "DOCE", "TRECE", "CATORCE", "QUINCE", "DIECISEIS", "DIECISIETE", "DIECIOCHO", "DIECINUEVE",
            "VEINTI", 30 => "TREINTA", 40 => "CUARENTA", 50 => "CINCUENTA", 60 => "SESENTA", 70 => "SETENTA", 80 => "OCHENTA", 90 => "NOVENTA",
            100 => "CIENTO", 200 => "DOSCIENTOS", 300 => "TRESCIENTOS", 400 => "CUATROCIENTOS", 500 => "QUINIENTOS", 600 => "SEISCIENTOS", 700 => "SETECIENTOS", 800 => "OCHOCIENTOS", 900 => "NOVECIENTOS"
        );
    //
        $xcifra = trim($xcifra);
        $xlength = strlen($xcifra);
        $xpos_punto = strpos($xcifra, ".");
        $xaux_int = $xcifra;
        $xdecimales = "00";
        if (!($xpos_punto === false)) {
            if ($xpos_punto == 0) {
                $xcifra = "0" . $xcifra;
                $xpos_punto = strpos($xcifra, ".");
            }
            $xaux_int = substr($xcifra, 0, $xpos_punto); // obtengo el entero de la cifra a covertir
            $xdecimales = substr($xcifra . "00", $xpos_punto + 1, 2); // obtengo los valores decimales
        }

        $XAUX = str_pad($xaux_int, 18, " ", STR_PAD_LEFT); // ajusto la longitud de la cifra, para que sea divisible por centenas de miles (grupos de 6)
        $xcadena = "";
        for ($xz = 0; $xz < 3; $xz++) {
            $xaux = substr($XAUX, $xz * 6, 6);
            $xi = 0;
            $xlimite = 6; // inicializo el contador de centenas xi y establezco el límite a 6 dígitos en la parte entera
            $xexit = true; // bandera para controlar el ciclo del While
            while ($xexit) {
                if ($xi == $xlimite) { // si ya llegó al límite máximo de enteros
                    break; // termina el ciclo
                }

                $x3digitos = ($xlimite - $xi) * -1; // comienzo con los tres primeros digitos de la cifra, comenzando por la izquierda
                $xaux = substr($xaux, $x3digitos, abs($x3digitos)); // obtengo la centena (los tres dígitos)
                for ($xy = 1; $xy < 4; $xy++) { // ciclo para revisar centenas, decenas y unidades, en ese orden
                    switch ($xy) {
                        case 1: // checa las centenas
                            if (substr($xaux, 0, 3) < 100) { // si el grupo de tres dígitos es menor a una centena ( < 99) no hace nada y pasa a revisar las decenas
                                
                            } else {
                                $key = (int) substr($xaux, 0, 3);
                                if (TRUE === array_key_exists($key, $xarray)){  // busco si la centena es número redondo (100, 200, 300, 400, etc..)
                                    $xseek = $xarray[$key];
                                    $xsub = self::subfijo($xaux); // devuelve el subfijo correspondiente (Millón, Millones, Mil o nada)
                                    if (substr($xaux, 0, 3) == 100)
                                        $xcadena = " " . $xcadena . " CIEN " . $xsub;
                                    else
                                        $xcadena = " " . $xcadena . " " . $xseek . " " . $xsub;
                                    $xy = 3; // la centena fue redonda, entonces termino el ciclo del for y ya no reviso decenas ni unidades
                                }
                                else { // entra aquí si la centena no fue numero redondo (101, 253, 120, 980, etc.)
                                    $key = (int) substr($xaux, 0, 1) * 100;
                                    $xseek = $xarray[$key]; // toma el primer caracter de la centena y lo multiplica por cien y lo busca en el arreglo (para que busque 100,200,300, etc)
                                    $xcadena = " " . $xcadena . " " . $xseek;
                                } // ENDIF ($xseek)
                            } // ENDIF (substr($xaux, 0, 3) < 100)
                            break;
                        case 2: // checa las decenas (con la misma lógica que las centenas)
                            if (substr($xaux, 1, 2) < 10) {
                                
                            } else {
                                $key = (int) substr($xaux, 1, 2);
                                if (TRUE === array_key_exists($key, $xarray)) {
                                    $xseek = $xarray[$key];
                                    $xsub = self::subfijo($xaux);
                                    if (substr($xaux, 1, 2) == 20)
                                        $xcadena = " " . $xcadena . " VEINTE " . $xsub;
                                    else
                                        $xcadena = " " . $xcadena . " " . $xseek . " " . $xsub;
                                    $xy = 3;
                                }
                                else {
                                    $key = (int) substr($xaux, 1, 1) * 10;
                                    $xseek = $xarray[$key];
                                    if (20 == substr($xaux, 1, 1) * 10)
                                        $xcadena = " " . $xcadena . " " . $xseek;
                                    else
                                        $xcadena = " " . $xcadena . " " . $xseek . " Y ";
                                } // ENDIF ($xseek)
                            } // ENDIF (substr($xaux, 1, 2) < 10)
                            break;
                        case 3: // checa las unidades
                            if (substr($xaux, 2, 1) < 1) { // si la unidad es cero, ya no hace nada
                                
                            } else {
                                $key = (int) substr($xaux, 2, 1);
                                $xseek = $xarray[$key]; // obtengo directamente el valor de la unidad (del uno al nueve)
                                $xsub = self::subfijo($xaux);
                                $xcadena = " " . $xcadena . " " . $xseek . " " . $xsub;
                            } // ENDIF (substr($xaux, 2, 1) < 1)
                            break;
                    } // END SWITCH
                } // END FOR
                $xi = $xi + 3;
            } // ENDDO

            if (substr(trim($xcadena), -5, 5) == "ILLON") // si la cadena obtenida termina en MILLON o BILLON, entonces le agrega al final la conjuncion DE
                $xcadena.= " DE";

            if (substr(trim($xcadena), -7, 7) == "ILLONES") // si la cadena obtenida en MILLONES o BILLONES, entoncea le agrega al final la conjuncion DE
                $xcadena.= " DE";

            // ----------- esta línea la puedes cambiar de acuerdo a tus necesidades o a tu país -------
            if (trim($xaux) != "") {
                switch ($xz) {
                    case 0:
                        if (trim(substr($XAUX, $xz * 6, 6)) == "1")
                            $xcadena.= "UN BILLON ";
                        else
                            $xcadena.= " BILLONES ";
                        break;
                    case 1:
                        if (trim(substr($XAUX, $xz * 6, 6)) == "1")
                            $xcadena.= "UN MILLON ";
                        else
                            $xcadena.= " MILLONES ";
                        break;
                    case 2:
                        if ($xcifra < 1) {
                            $xcadena = "CERO PESOS $xdecimales/100 M.N.";
                        }
                        if ($xcifra >= 1 && $xcifra < 2) {
                            $xcadena = "UN PESO $xdecimales/100 M.N. ";
                        }
                        if ($xcifra >= 2) {
                            $xcadena.= " PESOS $xdecimales/100 M.N. "; //
                        }
                        break;
                } // endswitch ($xz)
            } // ENDIF (trim($xaux) != "")
            // ------------------      en este caso, para México se usa esta leyenda     ----------------
            $xcadena = str_replace("VEINTI ", "VEINTI", $xcadena); // quito el espacio para el VEINTI, para que quede: VEINTICUATRO, VEINTIUN, VEINTIDOS, etc
            $xcadena = str_replace("  ", " ", $xcadena); // quito espacios dobles
            $xcadena = str_replace("UN UN", "UN", $xcadena); // quito la duplicidad
            $xcadena = str_replace("  ", " ", $xcadena); // quito espacios dobles
            $xcadena = str_replace("BILLON DE MILLONES", "BILLON DE", $xcadena); // corrigo la leyenda
            $xcadena = str_replace("BILLONES DE MILLONES", "BILLONES DE", $xcadena); // corrigo la leyenda
            $xcadena = str_replace("DE UN", "UN", $xcadena); // corrigo la leyenda
        } // ENDFOR ($xz)
        return trim($xcadena);
    }

    // END private FUNCTION

    private  static function subfijo($xx)
    { // esta función regresa un subfijo para la cifra
        $xx = trim($xx);
        $xstrlen = strlen($xx);
        if ($xstrlen == 1 || $xstrlen == 2 || $xstrlen == 3)
            $xsub = "";
        //
        if ($xstrlen == 4 || $xstrlen == 5 || $xstrlen == 6)
            $xsub = "MIL";
        //
        return $xsub;
    }
    
}
