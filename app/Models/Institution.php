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
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Institution extends Model
{
    use HasFactory;

    protected $table = "ogs_institutions";

    protected $fillable=[
        "id",
        "parent_id",
        "district_id",
        "type",
        "name",
        "phone",
        "address",
        "email"
    ];

    public function teachers(): HasMany
    {
        return $this->hasMany(Teacher::class, "institution_id");
    }

    public function plans(): BelongsToMany
    {
        return $this->belongsToMany(DevPlan::class, 'ogs_institution_plans',  'institution_id', 'plan_id');
    }

    public function district(): BelongsTo
    {
        return $this->belongsTo(District::class, 'district_id');
    }

    public function activities(): BelongsTo {
        return $this->belongsTo(Activity::class, 'institution_id');
    }

    public function notifications(): MorphMany
    {
        return $this->morphMany(Notification::class, 'notifiable');
    }
}