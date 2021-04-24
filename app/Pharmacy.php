<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pharmacy extends Model
{
    public function pharmImages() {
        return $this->hasMany(PharmacyImages::class, 'pharmacy_id', 'id');
    }
}
