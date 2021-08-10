<?php
/*
 *     Copyright 2021 Mersin İl Milli Eğitim Müdürlüğü Ölçme Değerlendirme Merkezi
 *
 *     Licensed under the Apache License, Version 2.0 (the "License");
 *     you may not use this file except in compliance with the License.
 *     You may obtain a copy of the License at
 *
 *       http://www.apache.org/licenses/LICENSE-2.0
 *
 *     Unless required by applicable law or agreed to in writing, software
 *     distributed under the License is distributed on an "AS IS" BASIS,
 *     WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 *     See the License for the specific language governing permissions and
 *     limitations under the License.
 *
 */

namespace App\Models;


use App\Traits\SelfReferencing;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Institution extends Model
{
    use SelfReferencing;

    protected $fillable=[
        "id",
        "parent_id",
        "district_id",
        "type",
        "name",
        "phone",
        "address",
        "e_mail"
    ];

    public function teachers(): HasMany
    {
        return $this->hasMany(Teacher::class, "institution_id");
    }

    public function plans(): HasMany
    {
        return $this->hasMany(DevPlan::class, "institution_id");
    }
}