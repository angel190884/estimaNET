<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;

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
     * Relation to Generator class
     *
     * @return Illuminate\Database\Eloquent\Concerns\HasRelationships::hasMany
     */
    public function subGenerators()
    {
        return $this->hasManyThrough(SubGenerator::class, Generator::class);
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
            $type= 'COMBINADA FINAL';
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
        return strtoupper(transformNumber($this->number));
    }

    /**
     * Retorna la fecha de entrega en formato de letras.
     *
     * @return string
     */
    public function getDateOfIssueAttribute()
    {
        return changeDateLetter($this->release);
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
        return changeDateLetter($this->start);
    }

    /**
     * Retorna la fecha de fin de estimacion en formato de letras.
     *
     * @return string
     */
    public function getPeriodFinishLetterAttribute()
    {
        return changeDateLetter($this->finish);
    }
    
    /**
     * Retorna Monto total de la estimacion.
     *
     * @param App\Estimate|null $estimate estimate
     *
     * @return Float
     */
    public function getTotalEstimateAmountAttribute(Estimate $estimate=null)
    {
        if ($estimate!=null) {
            return $this->estimateAmount($estimate) + $this->retention;
        }
        return $this->estimateAmount + $this->retention;
    }

    /**
     * Retorna Monto total de la estimacion formateado con $.
     *
     * @return Float
     */
    public function getTotalEstimateAmountOkAttribute()
    {
        return '$ ' . format($this->totalEstimateAmount);
    }
    
    /**
     * Retorna Monto de la estimacion.
     *
     * @param App\Estimate|null $estimate estimate
     *
     * @return Float
     */
    public function getEstimateAmountAttribute(Estimate $estimate=null)
    {
        if ($estimate!=null) {
            $total=0;
            if ($estimate->contract->type == 1) {
                if ($estimate->contract->split_catalog) {
                    foreach ($estimate->subGenerators->sortBy('location.name') as $subGenerator) {
                        $total+=round($subGenerator->quantity * $subGenerator->generator->concept->unit_price, 2, PHP_ROUND_HALF_DOWN);
                    }
                    return round($total, 2, PHP_ROUND_HALF_DOWN);
                }
                foreach ($estimate->generators as $generator) {
                    $total+=round($generator->quantity * $generator->concept->unit_price, 2, PHP_ROUND_HALF_DOWN);
                }
                return round($total, 2, PHP_ROUND_HALF_DOWN);
            }
            $unitPrice = $this->contract->originalAmount / 100;
            if ($this->start >= $this->contract->date_finish_modified) {
                $unitPrice = ($this->contract->totalAmount + $this->contract->amount_adjustment) / 100;
            }

            foreach ($estimate->generators as $generator) {
                if ($generator->concept->immovable==false) {
                    $total+=round($generator->quantity * ($unitPrice), 2, PHP_ROUND_HALF_DOWN);
                    return round($total, 2, PHP_ROUND_HALF_DOWN);
                }
                return $total+=round($generator->quantity * ($this->contract->originalAmount/100), 2, PHP_ROUND_HALF_DOWN);
            }
            return round($total, 2, PHP_ROUND_HALF_DOWN);
        }
        $total=0;
        if ($this->contract->type == 1) {
            if ($this->contract->split_catalog) {
                foreach ($this->subGenerators->sortBy('location.name') as $subGenerator) {
                    $total += round($subGenerator->quantity * $subGenerator->generator->concept->unit_price, 2, PHP_ROUND_HALF_DOWN);
                }
                return round($total, 2, PHP_ROUND_HALF_DOWN);
            }
            foreach ($this->generators as $generator) {
                $total+=round($generator->quantity * $generator->concept->unit_price, 2, PHP_ROUND_HALF_DOWN);
            }
            return round($total, 2, PHP_ROUND_HALF_DOWN);
        }
        $unitPrice=$this->contract->originalAmount/100;
        if ($this->start >= $this->contract->date_finish_modified) {
            $unitPrice=($this->contract->totalAmount + $this->contract->adjustment_amount) / 100;
        }

        foreach ($this->generators as $generator) {
            switch ($generator->concept->immovable) {
            case false:
                $total += round($generator->total * $unitPrice, 2, PHP_ROUND_HALF_DOWN);
                break;
            default:
                $total += round($generator->total*($this->contract->originalAmount/100), 2, PHP_ROUND_HALF_DOWN);
                break;
            }
        }
        return round($total, 2, PHP_ROUND_HALF_DOWN);
    }
    
    /**
     * Retorna iva del Monto de la estimacion.
     *
     * @return Float
     */
    public function getTotalEstimateAmountIvaAttribute()
    {
        return round($this->totalEstimateAmount * 0.16, 2, PHP_ROUND_HALF_DOWN);
    }

    /**
     * Retorna iva del Monto de la estimacion con formato $.
     *
     * @return Float
     */
    public function getTotalEstimateAmountIvaOkAttribute()
    {
        return '$ ' . format($this->totalEstimateAmountIva);
    }
    
    /**
     * Retorna Monto de la estimacion con iva.
     *
     * @return Float
     */
    public function getTotalEstimateAmountWithIvaAttribute()
    {
        return $this->totalEstimateAmount + $this->totalEstimateAmountIva;
    }

    /**
     * Retorna Monto de la estimacion con iva formateado $.
     *
     * @return Float
     */
    public function getTotalEstimateAmountWithIvaOkAttribute()
    {
        return '$ ' . format($this->totalEstimateAmountWithIva);
    }

    /**
     * Retorna total estimado.
     *
     * @return Float
     */
    public function getTotalEstimatedAttribute()
    {
        return $this->totalEstimateAmountWithIva + $this->totalPreviousAmount;
    }

    /**
     * Retorna total estimado con formato $.
     *
     * @return Float
     */
    public function getTotalEstimatedOkAttribute()
    {
        return '$ ' . format($this->totalEstimated);
    }
    
    /**
     * Retorna Monto Previo.
     *
     * @return Float
     */
    public function getTotalPreviousAmountAttribute()
    {
        $totalPrevious = 0;
        foreach ($this->previousEstimates($this)->get() as $estimate) {
            $totalPrevious+=$estimate->totalEstimateAmountWithIva;
        }
        return round($totalPrevious, 2, PHP_ROUND_HALF_DOWN);
    }

    /**
     * Retorna monto previo con formato $.
     *
     * @return Float
     */
    public function getTotalPreviousAmountOkAttribute()
    {
        return '$ ' . format($this->totalPreviousAmount);
    }

    /**
     * Retorna monto total por ejecutar con repescto al total del contrato.
     *
     * @return Float
     */
    public function getTotalForExecuteAmountAttribute()
    {
        return round($this->contract->totalAmountWithIva - ($this->totalEstimateAmountWithIva + $this->totalPreviousAmount), 2, PHP_ROUND_HALF_DOWN);
    }

    /**
     * Retorna monto total por ejecutar con repescto al total del contrato con formato $.
     *
     * @return Float
     */
    public function getTotalForExecuteAmountOkAttribute()
    {
        return '$ ' . format($this->totalForExecuteAmount);
    }

    /**
     * Retorna monto total de las deducciones y sanciones del contrato y estimacion.
     *
     * @return Float
     */
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

    /**
     * Retorna monto total de las deducciones y sanciones del contrato y estimacion con formato $.
     *
     * @return Float
     */
    public function getTotalDeductionsAmountOkAttribute()
    {
        return '$ ' . format($this->totalDeductionsAmount);
    }

    /**
     * Retorna monto total de la estimacion con formato $.
     *
     * @return Float
     */
    public function getAmountNetOkAttribute()
    {
        return '$ ' . format($this->totalEstimateAmountWithIva - $this->totalDeductionsAmount);
    }

    /**
     * Retorna monto total de la estimacion con letras formato 00/100 M.N..
     *
     * @return String
     */
    public function getAmountNetLetterOkAttribute()
    {
        return numberToLetters($this->totalEstimateAmountWithIva - $this->totalDeductionsAmount);
    }

    /**
     * **************************************************************************
     * ************************QUERY SCOPES**************************************
     * **************************************************************************
     */

    /**
     * Retorna estimaciones previas.
     *
     * @param Query        $query    query
     * @param App\Estimate $estimate estimate
     *
     * @return Query
     */
    public function scopePreviousEstimates($query, Estimate $estimate)
    {
        if ($estimate) {
            return $query->with('contract', 'generators', 'deductions')
                ->where('number', '<', $estimate->number)
                ->where('contract_id', $estimate->contract->id);
        }
        return $query->with('contract', 'generators', 'deductions')
            ->where('number', '<', $this->number)
            ->where('contract_id', $this->contract->id);
    }

    /**
     * Retorna estimaciones previas.
     *
     * @return Generator
     */
    public function scopeGeneratorsPrevious()
    {
        return Generator::where('estimates.number', '<', $this->number)
            ->where('contracts.id', $this->contract->id)
            ->join('concepts', 'concepts.id', '=', 'concept_estimate.concept_id')
            ->join('estimates', 'estimates.id', '=', 'concept_estimate.estimate_id')
            ->join('contracts', 'contracts.id', '=', 'estimates.contract_id');
    }
}
