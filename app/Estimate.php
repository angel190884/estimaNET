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
     * Relations.
     */
    public function contract()
    {
        return $this->belongsTo(Contract::class);
    }

    public function concepts()
    {
        return $this->belongsToMany(Concept::class)->withTimestamps();
    }

    public function generators()
    {
        return $this->hasMany(Generator::class);
    }

    /**
     * Getters.
     */
    public function getStartOkAttribute()
    {
        return Carbon::parse($this->start)->format('d-m-Y');
    }
    public function getFinishOkAttribute()
    {
        return Carbon::parse($this->finish)->format('d-m-Y');
    }
    public function getReleaseOkAttribute()
    {
        return Carbon::parse($this->release)->format('d-m-Y');
    }
    public function getTypeOkAttribute()
    {
        if ($this->type == 1) {
            return strtoupper("NORMAL");
        } elseif ($this->type == 2) {
            return strtoupper("EXTRAORDINARIA");
        } elseif ($this->type == 3) {
            return strtoupper("FINAL");
        } else {
            return strtoupper("FINAL COMBINADA");
        }
    }

    public function getEstimateLetterAttribute()
    {
        if ($this->type=='N'){
            return strtoupper($this->getNumberEstimateLetterAttribute());
        }
        return strtoupper($this->getNumberEstimateLetterAttribute().' '.$this->getTypeEstimateAttribute());
    }
    public function getNumberEstimateLetterAttribute()
    {
        return strtoupper($this->transformNumber($this->number));
    }
    public function getTypeEstimateAttribute()
    {
        if ($this->type=='1'){
            return 'NORMAL';
        }
        if ($this->type=='2'){
            return 'EXTRAORDINARIA';
        }
        if ($this->type=='4'){
            return 'COMBINADA';
        }
        if ($this->type=='3'){
            return 'FINAL';
        }
        if ($this->type=='5'){
            return 'COMBINADA FINAL';
        }
        return 'NO ESPECIFICADO';
    }
    public function getDateOfDeliveryAttribute()
    {
        return DateController::ChangeDateLetter($this->release);
    }
    public function getFormattedPeriodEstimateAttribute()
    {
        $periodStart=$this->getPeriodStartLetterAttribute();
        $periodFinish=$this->getPeriodFinishLetterAttribute();
        return strtoupper("del $periodStart al $periodFinish");
    }
    public function getPeriodStartLetterAttribute()
    {
        return DateController::ChangeDateLetter($this->start);
    }
    public function getPeriodFinishLetterAttribute()
    {
        return DateController::ChangeDateLetter($this->finish);
    }
    public function getTotalEstimateAmountAttribute(Estimate $estimate=null)
    {
        if ($estimate!=null){
            $amount=$this->getEstimateAmountAttribute($estimate);
            return $amount+$this->retention;
        }
        $amount=$this->getEstimateAmountAttribute();
        return $amount+$this->retention;
    }
    public function getEstimateAmountAttribute(Estimate $estimate=null)
    {
        if ($estimate!=null){
            $total=0;
            if ( $estimate->contract->type == 1 )
            {
                if ($estimate->contract->split_catalog){
                    $subGenerators = collect();
                    foreach ($estimate->generators as $generator){
                        $subGenerators->push($generator->subGenerators);
                    }
                    foreach ($subGenerators->collapse()->sortBy('location.name') as $subGenerator){
                        $total+=round($subGenerator->quantity * $subGenerator->generator->concept->unit_price,2,PHP_ROUND_HALF_DOWN);
                    }

                }else{
                    foreach ($estimate->generators as $generator){
                        $total+=round($generator->quantity * $generator->concept->unit_price,2,PHP_ROUND_HALF_DOWN);
                    }
                }
            }elseif ($estimate->contract->type == 2) {
                if($this->start >= $this->contract->date_finish_modified){
                    $unitPrice=( $this->contract->totalAmount + $this->contract->amount_adjustment ) / 100;
                }else{
                    $unitPrice=$this->contract->originalAmount/100;
                }
                foreach ($estimate->generators as $generator){
                    if ($generator->concept->immovable==false){
                        $total+=round($generator->quantity * ($unitPrice),2, PHP_ROUND_HALF_DOWN);
                    }else{
                        $total+=round($generator->quantity * ($this->contract->originalAmount/100),2, PHP_ROUND_HALF_DOWN);
                    }
                }
            }
            return $total;
        }
        $total=0;
        if ( $this->contract->type == 1)
        {
            if ($this->contract->split_catalog){
                $subGenerators = collect();
                foreach ($this->generators as $generator){
                    $subGenerators->push($generator->subGenerators);
                }
                foreach ($subGenerators->collapse()->sortBy('location.name') as $subGenerator){
                    $total += round($subGenerator->quantity * $subGenerator->generator->concept->unit_price,2,PHP_ROUND_HALF_DOWN);
                }

            }else{
                foreach ( $this->generators as $generator ){
                    $total+=round($generator->quantity * $generator->concept->unit_price,2, PHP_ROUND_HALF_DOWN);
                }
            }
        }elseif ( $this->contract->type == 2 ) {
            if($this->start >= $this->contract->date_finish_modified){
                $unitPrice=( $this->contract->totalAmount + $this->contract->adjustment_amount ) / 100;
            }else{
                $unitPrice=$this->contract->originalAmount/100;
            }
            foreach ($this->generators as $generator)
            {
                if ($generator->concept->immovable==false){
                    $total+=round($generator->total * ($unitPrice),2, PHP_ROUND_HALF_DOWN);
                }else{
                    $total+=round($generator->total*($this->contract->originalAmount/100),2, PHP_ROUND_HALF_DOWN);
                }
            }
        }
        return $total;
    }

    /**
     * Query Scope.
     */

    public function scopePreviousEstimates($query, Estimate $estimate)
    {
        if ($estimate) {
            return $query->with('contract','generators')->where('number', '<', $estimate->number);
        }
    }

    public function scopeGeneratorsPrevious()
    {
        return $generators=Generator::where('estimates.number','<',$this->number)
            ->where('contracts.id',$this->contract->id)
            ->join('concepts', 'concepts.id', '=', 'concept_estimate.concept_id')
            ->join('estimates', 'estimates.id', '=', 'concept_estimate.estimate_id')
            ->join('contracts', 'contracts.id', '=', 'estimates.contract_id');
    }
    private function transformNumber($number)
    {
        if ($number==0)  {$numberLetter = "cero";}
        elseif ($number==1)  {$numberLetter = "Uno";}
        elseif ($number==2)  {$numberLetter = "Dos";}
        elseif ($number==3)  {$numberLetter = "Tres";}
        elseif ($number==4)  {$numberLetter = "Cuatro";}
        elseif ($number==5)  {$numberLetter = "Cinco";}
        elseif ($number==6)  {$numberLetter = "Seis";}
        elseif ($number==7)  {$numberLetter = "Siete";}
        elseif ($number==8)  {$numberLetter = "Ocho";}
        elseif ($number==9)  {$numberLetter = "Nueve";}
        elseif ($number==10) {$numberLetter = "Diez";}
        elseif ($number==11) {$numberLetter = "Once";}
        elseif ($number==12) {$numberLetter = "Doce";}
        elseif ($number==13) {$numberLetter = "Trece";}
        elseif ($number==14) {$numberLetter = "Catorce";}
        elseif ($number==15) {$numberLetter = "Quince";}
        elseif ($number==16) {$numberLetter = "Dieciseis";}
        elseif ($number==17) {$numberLetter = "Decisiete";}
        elseif ($number==18) {$numberLetter = "Dieciocho";}
        elseif ($number==19) {$numberLetter = "Diecinueve";}
        elseif ($number==20) {$numberLetter = "Veinte";}
        elseif ($number==21) {$numberLetter = "Veintiuno";}
        elseif ($number==22) {$numberLetter = "Veintidos";}
        elseif ($number==23) {$numberLetter = "Veintitres";}
        elseif ($number==24) {$numberLetter = "Veinticuatro";}
        elseif ($number==25) {$numberLetter = "Veinticinco";}
        elseif ($number==26) {$numberLetter = "Veintiseis";}
        elseif ($number==27) {$numberLetter = "Veintisiente";}
        elseif ($number==28) {$numberLetter = "Veintiocho";}
        elseif ($number==29) {$numberLetter = "Veintinueve";}
        elseif ($number==30) {$numberLetter = "Treinta";}
        elseif ($number==31) {$numberLetter = "Treinta y uno";}
        elseif ($number==32) {$numberLetter = "Treinta y dos";}
        elseif ($number==33) {$numberLetter = "Treinta y tres";}
        elseif ($number==34) {$numberLetter = "Treinta y cuatro";}
        elseif ($number==35) {$numberLetter = "Treinta y cinco";}
        elseif ($number==36) {$numberLetter = "Treinta y seis";}
        elseif ($number==37) {$numberLetter = "Treinta y siete";}
        elseif ($number==38) {$numberLetter = "Treinta y ocho";}
        elseif ($number==39) {$numberLetter = "Treinta y nueve";}
        elseif ($number==40) {$numberLetter = "Cuarenta";}
        elseif ($number==41) {$numberLetter = "Cuarenta y uno";}
        elseif ($number==42) {$numberLetter = "Cuarenta y dos";}
        elseif ($number==43) {$numberLetter = "Cuarenta y tres";}
        elseif ($number==44) {$numberLetter = "Cuarenta y cuatro";}
        elseif ($number==45) {$numberLetter = "Cuarenta y cinco";}
        elseif ($number==46) {$numberLetter = "Cuarenta y seis";}
        elseif ($number==47) {$numberLetter = "Cuarenta y siete";}
        elseif ($number==48) {$numberLetter = "Cuarenta y ocho";}
        elseif ($number==49) {$numberLetter = "Cuarenta y nueve";}
        elseif ($number==50) {$numberLetter = "Cincuenta";}
        elseif ($number==51) {$numberLetter = "Cincuenta y uno";}
        elseif ($number==52) {$numberLetter = "Cincuenta y dos";}
        elseif ($number==53) {$numberLetter = "Cincuenta y tres";}
        elseif ($number==54) {$numberLetter = "Cincuenta y cuatro";}
        elseif ($number==55) {$numberLetter = "Cincuenta y cinco";}
        elseif ($number==56) {$numberLetter = "Cincuenta y seis";}
        elseif ($number==57) {$numberLetter = "Cincuenta y siete";}
        elseif ($number==58) {$numberLetter = "Cincuenta y ocho";}
        elseif ($number==59) {$numberLetter = "Cincuenta y nueve";}
        elseif ($number==60) {$numberLetter = "Sesenta";}
        elseif ($number==61) {$numberLetter = "Sesenta y uno";}
        elseif ($number==62) {$numberLetter = "Sesenta y dos";}
        elseif ($number==63) {$numberLetter = "Sesenta y tres";}
        elseif ($number==64) {$numberLetter = "Sesenta y cuatro";}
        elseif ($number==65) {$numberLetter = "Sesenta y cinco";}
        elseif ($number==66) {$numberLetter = "Sesenta y seis";}
        elseif ($number==67) {$numberLetter = "Sesenta y siete";}
        elseif ($number==68) {$numberLetter = "Sesenta y ocho";}
        elseif ($number==69) {$numberLetter = "Sesenta y nueve";}
        elseif ($number==70) {$numberLetter = "Setenta";}
        elseif ($number==71) {$numberLetter = "Setenta y uno";}
        elseif ($number==72) {$numberLetter = "Setenta y dos";}
        elseif ($number==73) {$numberLetter = "Setenta y tres";}
        elseif ($number==74) {$numberLetter = "Setenta y cuatro";}
        elseif ($number==75) {$numberLetter = "Setenta y cinco";}
        elseif ($number==76) {$numberLetter = "Setenta y seis";}
        elseif ($number==77) {$numberLetter = "Setenta y siete";}
        elseif ($number==78) {$numberLetter = "Setenta y ocho";}
        elseif ($number==79) {$numberLetter = "Setenta y nueve";}
        elseif ($number==80) {$numberLetter = "Ochenta";}
        elseif ($number==81) {$numberLetter = "Ochenta y uno";}
        elseif ($number==82) {$numberLetter = "Ochenta y dos";}
        elseif ($number==83) {$numberLetter = "Ochenta y tres";}
        elseif ($number==84) {$numberLetter = "Ochenta y cuatro";}
        elseif ($number==85) {$numberLetter = "Ochenta y cinco";}
        elseif ($number==86) {$numberLetter = "Ochenta y seis";}
        elseif ($number==87) {$numberLetter = "Ochenta y siete";}
        elseif ($number==88) {$numberLetter = "Ochenta y ocho";}
        elseif ($number==89) {$numberLetter = "Ochenta y nueve";}
        elseif ($number==90) {$numberLetter = "Noventa";}
        elseif ($number==91) {$numberLetter = "Noventa y uno";}
        elseif ($number==92) {$numberLetter = "Noventa y dos";}
        elseif ($number==93) {$numberLetter = "Noventa y tres";}
        elseif ($number==94) {$numberLetter = "Noventa y cuatro";}
        elseif ($number==95) {$numberLetter = "Noventa y cinco";}
        elseif ($number==96) {$numberLetter = "Noventa y seis";}
        elseif ($number==97) {$numberLetter = "Noventa y siete";}
        elseif ($number==98) {$numberLetter = "Noventa y ocho";}
        else            {$numberLetter = "Noventa y nueve";}
        return $numberLetter; //Retornar el resultado
    }

}
