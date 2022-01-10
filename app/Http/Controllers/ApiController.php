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

namespace App\Http\Controllers;

use App\Http\Controllers\Utils\ResponseCodes;
use App\Http\Controllers\Utils\ResponseContents;
use App\Http\Controllers\Utils\ResponseKeys;
use App\Traits\ValidationTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\MessageBag;

class ApiController extends Controller
{
    use ValidationTrait;
    /**
     * @param Request $request
     * @param $props
     * @return MessageBag|null
     */
    public function apiValidator(Request $request, $props): ?MessageBag
    {

        $validator = Validator::make($request->all(), $props, $this->MESSAGES, $this->ATTRIBUTES);
        if ($validator->fails()) {
            return $validator->errors();
        }
        return null;
    }

    public function apiException($exception): JsonResponse
    {
        return response()->json([
            ResponseKeys::CODE => ResponseCodes::CODE_ERROR,
            ResponseKeys::MESSAGE => ResponseContents::EXCEPTION_MESSAGE,
            ResponseKeys::EXCEPTION => $exception->getMessage()
        ], 500);
    }

    public function unauthorized(): JsonResponse
    {
        return response()->json([
            ResponseKeys::CODE => ResponseCodes::CODE_UNAUTHORIZED,
            ResponseKeys::MESSAGE => ResponseContents::UNAUTHORIZED_MESSAGE
        ], 400);
    }

}
