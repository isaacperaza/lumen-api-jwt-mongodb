<?php

namespace App\Http\Controllers;

use App\Phone;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;
use Laravel\Lumen\Http\ResponseFactory;

/**
 * Controller that handle a Phones crud operations
 */
class PhonesController extends Controller
{
    /**
     * @return JsonResponse
     */
    public function index()
    {
        $phones = Phone::all();
        return response()->json($phones);
    }

    /**
     * @param string $phoneId
     * @return JsonResponse
     */
    public function show($phoneId)
    {
        return response(Phone::findOrFail($phoneId));
    }

    /**
     * @param Request $request
     * @return Response|ResponseFactory
     * @throws ValidationException
     */
    public function store(Request $request)
    {
        $payloadValidated = $this->validatePayload($request);
        return response(Phone::create($payloadValidated));
    }

    /**
     * @param string $phoneId
     * @param Request $request
     * @return JsonResponse|Response|ResponseFactory
     * @throws ValidationException
     */
    public function update($phoneId, Request $request)
    {
        $payloadValidated = $this->validatePayload($request);
        $phone = Phone::findOrFail($phoneId);
        $phone->update($payloadValidated);
        return response(Phone::findOrFail($phoneId));
    }

    public function destroy($phoneId)
    {
        Phone::destroy($phoneId);
        return response(['success' =>  true]);
    }

    /**
     * @param Request $request
     * @return mixed[]
     * @throws ValidationException
     */
    private function validatePayload(Request $request)
    {
        // TODO: Was not requested for test, but this should has validation to avoid duplicate records.
        return $this->validate($request, [
            'firstName' => ['string', 'required'],
            'lastName' => ['string', 'required'],
            'phones' => ['array', 'min:1', 'required'],
            'emails' => ['array', 'min:1', 'required'],
        ]);
    }
}
