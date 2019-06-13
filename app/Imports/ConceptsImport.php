<?php

namespace App\Imports;

use App\Concept;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ConceptsImport implements ToModel, WithHeadingRow
{
    public $contractId;

    public $concepts;

    public function __construct($contractId)
    {
        $this->contractId = $contractId;
        $this->concepts = Concept::where('contract_id', $contractId)->get();
    }

    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        if ($this->concepts->contains('contract_id', $this->contractId) && $this->concepts->contains('code', $row['code'])) {
            return;
        }
        return new Concept(
            [
                'contract_id' => $this->contractId,
                'code'      => mb_strtoupper($row['code']),
                'name'      => mb_strtoupper($row['name']),
                'address'   => mb_strtoupper($row['address']),
                'location'  => mb_strtoupper($row['location']),
                'measurement_unit' => mb_strtoupper($row['measurement_unit']),
                'quantity'  => $row['quantity'],
                'unit_price'    => $row['unit_price']
            ]
        );
    }
}
