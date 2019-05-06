<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Contract extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'code',
        'name',
        'short_name',
        'description',
        'amount_total',
        'amount_anticipated',
        'amount_extension',
        'amount_adjustment',
        'date_start',
        'date_finish',
        'date_signature',
        'date_signature_covenant',
        'date_finish_modified',
        'type',
        'active',
        'split_catalog'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [

    ];

    /**
     * Relation users.
     *
     * @return belongsToMany
     */
    public function users()
    {
        return $this->belongsToMany(User::class)->withTimestamps();
    }

    /**
     * Relation concepts.
     *
     * @return hasMany
     */
    public function concepts()
    {
        return $this->hasMany(Concept::class);
    }

    /**
     * Relation companies.
     *
     * @return belongsToMany
     */
    public function companies()
    {
        return $this->belongsToMany(Company::class)->withTimestamps();
    }

    /**
     * Relation estimates.
     *
     * @return hasMany
     */
    public function estimates()
    {
        return $this->hasMany(Estimate::class);
    }

    /**
     * Relation locations.
     *
     * @return hasMany
     */
    public function locations()
    {
        return $this->hasMany(Location::class);
    }

    /**
     * Relation deductions.
     *
     * @return belongsToMany
     */
    public function deductions()
    {
        return $this->belongsToMany(Deduction::class)->withTimestamps()->withPivot('factor');
    }

    /**
     * **************************************************************************
     * ************************DATOS*********************************************
     * **************************************************************************
     */

    /**
     * Retorna el nombre del contrato con Mayusculas.
     *
     * @return String
     */
    public function getCodeOkAttribute()
    {
        return strtoupper($this->code);
    }

    /**
     * Retorna el code del contrato con Mayusculas y Formateado.
     *
     * @return String
     */
    public function getNameContractFormattedAttribute()
    {
        return strtoupper(
            substr($this->code, -15, 2)." ".
            substr($this->code, -13, 2)." ".
            substr($this->code, -11, 2)." ".
            substr($this->code, -9, 2)." ".
            substr($this->code, -7, 4)." ".
            substr($this->code, -3, 1)." ".
            substr($this->code, -2)
        );
    }
    
    /**
     * Retorna el type del contrato con Mayusculas y Formateado a letras.
     *
     * @return String
     */
    public function getTypeOkAttribute()
    {
        switch ($this->type) {
        case 1:
            return 'builder';
            break;
        case 2:
            return 'supervision';
            break;
        default:
            return 'builder';
        }
    }

    /**
     * **************************************************************************
     * ************************FECHAS********************************************
     * **************************************************************************
     */

    /**
     * Retorna la fecha de inicio del contrato en formato d-m-Y.
     *
     * @return Date
     */
    public function getStartOkAttribute()
    {
        return Carbon::parse($this->date_start)->format('d-m-Y');
    }

    /**
     * Retorna la fecha de inicio del contrato en formato de letras.
     *
     * @return Date
     */
    public function getStartWithLettersAttribute()
    {
        return $this->changeDateLetter($this->date_start);
    }

    /**
     * Retorna la fecha de fin del contrato en formato d-m-Y.
     *
     * @return Date
     */
    public function getFinishOkAttribute()
    {
        return Carbon::parse($this->date_finish)->format('d-m-Y');
    }

    /**
     * Retorna la fecha de fin del contrato en formato de letras.
     *
     * @return Date
     */
    public function getFinishWithLettersAttribute()
    {
        return $this->changeDateLetter($this->date_finish);
    }

    /**
     * Retorna la fecha de firma de contrato en formato d-m-Y.
     *
     * @return Date
     */
    public function getSignatureOkAttribute()
    {
        return Carbon::parse($this->date_signature)->format('d-m-Y');
    }

    /**
     * Retorna la fecha de firma de contrato en formato largo con letras.
     *
     * @return Date
     */
    public function getSignatureWithLettersAttribute()
    {
        return $this->changeDateLetter($this->date_signature);
    }

    /**
     * Retorna la fecha de firma de convenio en formato d-m-Y.
     *
     * @return Date
     */
    public function getSignatureCovenantOkAttribute()
    {
        return Carbon::parse($this->date_signature_covenant)->format('d-m-Y');
    }

    /**
     * Retorna la fecha de firma de convenio en formato de letras.
     *
     * @return Date
     */
    public function getSignatureCovenantWithLettersAttribute()
    {
        return $this->changeDateLetter($this->date_signature_covenant);
    }

    /**
     * Retorna la fecha de firma de fon modificado en formato d-m-Y o ---.
     *
     * @return Date|String
     */
    public function getFinishModifiedOkAttribute()
    {
        if ($this->date_finish_modified) {
            return Carbon::parse($this->date_finish_modified)->format('d-m-Y');
        }
        return "---";
    }

    /**
     * Retorna la fecha de firma de fon modificado en formato de letras o ---.
     *
     * @return String
     */
    public function getFinishModifiedWithLettersAttribute()
    {
        if ($this->date_finish_modified) {
            return $this->changeDateLetter($this->date_finish_modified);
        }
        return "---";
    }

    /**
     * **************************************************************************
     * ************************MONTOS********************************************
     * **************************************************************************
     */

    /**
     * Retorna el monto original del contrato a dos decimales.
     *
     * @return Date
     */
    public function getOriginalAmountAttribute()
    {
        return round($this->amount_total, 2, PHP_ROUND_HALF_DOWN);
    }

    /**
     * Retorna el monto original del contrato a dos decimales con formato.
     *
     * @return String
     */
    public function getOriginalAmountOkAttribute()
    {
        return '$ '. $this->format($this->originalAmount);
    }

    /**
     * Retorna el IVA del monto original del contrato a dos decimales.
     *
     * @return Float
     */
    public function getOriginalAmountIvaAttribute()
    {
        return round($this->originalAmount * 0.16, 2, PHP_ROUND_HALF_DOWN);
    }

    /**
     * Retorna el IVA del monto original del contrato a dos decimales con Formato.
     *
     * @return String
     */
    public function getOriginalAmountIvaOkAttribute()
    {
        return '$ '. $this->format($this->originalAmountIva);
    }

    /**
     * Retorna el monto original del contrato a dos decimales con IVA.
     *
     * @return Float
     */
    public function getOriginalAmountWithIvaAttribute()
    {
        return round($this->originalAmount + $this->originalAmountIva, 2, PHP_ROUND_HALF_DOWN);
    }

    /**
     * Retorna el monto original del contrato a dos decimales con IVA y formato.
     *
     * @return String
     */
    public function getOriginalAmountWithIvaOkAttribute()
    {
        return '$ ' . $this->format($this->originalAmountWithIva);
    }
    
    /**
     * Retorna el monto de extension del contrato a dos decimales.
     *
     * @return Float
     */
    public function getExtensionAmountAttribute()
    {
        return round($this->amount_extension, 2, PHP_ROUND_HALF_DOWN);
    }

    /**
     * Retorna el monto de extension del contrato a dos decimales y formato.
     *
     * @return String
     */
    public function getExtensionAmountOkAttribute()
    {
        return '$ ' . $this->format($this->extensionAmount);
    }
    
    /**
     * Retorna el monto del iva de extension del contrato a dos decimales.
     *
     * @return Float
     */
    public function getExtensionAmountIvaAttribute()
    {
        return round($this->extensionAmount * 0.16, 2, PHP_ROUND_HALF_DOWN);
    }

    /**
     * Retorna el monto del iva de extension del contrato a dos decimales y formato.
     *
     * @return String
     */
    public function getExtensionAmountIvaOkAttribute()
    {
        return '$ ' . $this->format($this->extensionAmountIva);
    }

    /**
     * Retorna el monto extension del contrato a dos decimales con IVA.
     *
     * @return Float
     */
    public function getExtensionAmountWithIvaAttribute()
    {
        return round($this->extensionAmount + $this->extensionAmountIva, 2, PHP_ROUND_HALF_DOWN);
    }

    /**
     * Retorna el monto extension del contrato a dos decimales con IVA y formato.
     *
     * @return String
     */
    public function getExtensionAmountWithIvaOkAttribute()
    {
        return '$ ' . $this->format($this->extensionAmountWithIva);
    }

    /**
     * Retorna el monto del Total del contrato a dos decimales.
     *
     * @return Float
     */
    public function getTotalAmountAttribute()
    {
        return $this->originalAmount + $this->extensionAmount;
    }

    /**
     * Retorna el monto del Total del contrato a dos decimales y formato.
     *
     * @return String
     */
    public function getTotalAmountOkAttribute()
    {
        return '$ ' . $this->format($this->totalAmount);
    }

    /**
     * Retorna el monto del iva del total del contrato a dos decimales.
     *
     * @return Float
     */
    public function getTotalAmountIvaAttribute()
    {
        return round($this->totalAmount * 0.16, 2, PHP_ROUND_HALF_DOWN);
    }

    /**
     * Retorna el monto del iva del total del contrato a dos decimales y formato.
     *
     * @return String
     */
    public function getTotalAmountIvaOkAttribute()
    {
        return '$ ' . $this->format($this->TotalAmountIva);
    }

    /**
     * Retorna el monto total del contrato a dos decimales con IVA.
     *
     * @return Float
     */
    public function getTotalAmountWithIvaAttribute()
    {
        return round($this->totalAmount + $this->totalAmountIva, 2, PHP_ROUND_HALF_DOWN);
    }

    /**
     * Retorna el monto total del contrato a dos decimales con IVA y formato.
     *
     * @return String
     */
    public function getTotalAmountWithIvaOkAttribute()
    {
        return '$ ' . $this->format($this->totalAmountWithIva);
    }
    
    /**
     * Retorna el monto del Anticipo del contrato a dos decimales.
     *
     * @return Float
     */
    public function getAdvancePaymentAmountAttribute()
    {
        return $this->amount_anticipated;
    }
    
    /**
     * Retorna el monto del Anticipo del contrato a dos decimales y formato.
     *
     * @return String
     */
    public function getAdvancePaymentAmountOkAttribute()
    {
        return '$ ' . $this->format($this->advancePaymentAmount);
    }

    /**
     * Retorna el monto del iva del anticipo del contrato a dos decimales.
     *
     * @return Float
     */
    public function getAdvancePaymentAmountIvaAttribute()
    {
        return round($this->advancePaymentAmount * 0.16, 2, PHP_ROUND_HALF_DOWN);
    }

    /**
     * Retorna el monto del iva del anticipo del contrato a dos decimales y formato.
     *
     * @return String
     */
    public function getAdvancePaymentAmountIvaOkAttribute()
    {
        return '$ ' . $this->format($this->advancePaymentAmountIva);
    }

    /**
     * Retorna el monto del anticipo del contrato a dos decimales con IVA.
     *
     * @return Float
     */
    public function getAdvancePaymentAmountWithIvaAttribute()
    {
        return round($this->advancePaymentAmount + $this->advancePaymentAmountIva, 2, PHP_ROUND_HALF_DOWN);
    }

    /**
     * Retorna el monto del anticipo del contrato a dos decimales con IVA y formato.
     *
     * @return String
     */
    public function getAdvancePaymentAmountWithIvaOkAttribute()
    {
        return '$ ' . $this->format($this->advancePaymentAmountWithIva);
    }
    
    /**
     * **************************************************************************
     * ************************QUERY SCOPES**************************************
     * **************************************************************************
     */

    /**
     * Retorna los contratos que contienen el codigo = $request->code.
     *
     * @return Query
     */
    public function scopeCode($query, $code)
    {
        if ($code) {
            return $query->where('code', 'LIKE', "%$code%");
        }
    }

    /**
     * Retorna los contratos activos.
     *
     * @param Query $query query
     *
     * @return Query
     */
    public function scopeActive($query)
    {
        return $query->where('active', true);
    }

    /**
     * Retorna los contratos que se dividen por frentes que no vengan en su catalogo original.
     *
     * @param Query $query query
     *
     * @return Query
     */
    public function scopeSplit($query)
    {
        return $query->where('split_catalog', true);
    }

    /**
     * **************************************************************************
     * ************************AUXILIARY FUNCTIONS*******************************
     * **************************************************************************
     */

    /**
     * Retorna un numero al formato establecido para numeros.
     *
     * @param Number $number number to change
     *
     * @return String
     */
    private function format($number)
    {
        $numbers= explode(".", $number);
        if (! isset($numbers[1])) {
            $numbers[1] = null;
        }
        if (strlen($numbers[1]) < 2) {
            return number_format($number, 2, '.', ',');
        }
        return number_format($numbers[0], 0, '.', ',').'.'.$numbers[1];
    }

    /**
     * Retorna una fecha a formato de letras.
     *
     * @param Date $date number to change
     *
     * @return String
     */
    private function changeDateLetter($date)
    {
        if ($date=='0000-00-00') {
            return '------';
        }
        $mes='';
        $arraydate = explode("-", $date);

        switch ($arraydate[1]) {
        case '01':
            $mes='ENERO';
            break;
        case '02':
            $mes='FEBRERO';
            break;
        case '03':
            $mes='MARZO';
            break;
        case '04':
            $mes='ABRIL';
            break;
        case '05':
            $mes='MAYO';
            break;
        case '06':
            $mes='JUNIO';
            break;
        case '07':
            $mes='JULIO';
            break;
        case '08':
            $mes='AGOSTO';
            break;
        case '09':
            $mes='SEPTIEMBRE';
            break;
        case '10':
            $mes='OCTUBRE';
            break;
        case '11':
            $mes='NOVIEMBRE';
            break;
        case '12':
            $mes='DICIEMBRE';
            break;
        default:
            '------';
            break;
        }

        return "$arraydate[2] DE $mes DEL $arraydate[0]";
    }
}
