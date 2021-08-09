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

namespace App\Http\Controllers\Utils;

class ResponseMessages
{
    public static function create($param)
    {
        return $param . " kayıt işlemi başarılı oldu.";
    }

    public static function createError($param)
    {
        return $param . " kayıt işlemi sırasında bir hata oluştu! Sistem yöneticinize başvurabilirsiniz";
    }


    public static function update($param)
    {
        return $param . " güncelleme işlemi başarılı oldu.";
    }

    public static function updateError($param)
    {
        return $param . " güncelleme işlemi sırasında bir hata oluştu! Sistem yöneticinize başvurabilirsiniz";
    }

    public static function delete($param)
    {
        return $param . " verisini silme işlemi başarılı oldu.";
    }

    public static function deleteError($param)
    {
        return $param . " verisini silme işlemi sırasında bir hata oluştu! Sistem yöneticinize başvurabilirsiniz";
    }

}