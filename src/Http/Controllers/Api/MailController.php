<?php

namespace Rocky\MailgunMailer\Http\Controllers\Api;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Rocky\MailgunMailer\Http\Requests\SendMailRequest;
use Rocky\MailgunMailer\Http\Resources\MailgunMailResource;
use Rocky\MailgunMailer\Models\MailgunMail;
use Rocky\MailgunMailer\Repositories\MailgunMailRepository;

class MailController
{
    /**
     * @param  Request  $request
     * @param  MailgunMailRepository  $repository
     *
     * @return AnonymousResourceCollection
     */
    public function index(Request $request, MailgunMailRepository $repository)
    {
        $mails = $repository->search($request);

        return MailgunMailResource::collection($mails);
    }

    /**
     * @param  SendMailRequest  $request
     * @param  MailgunMailRepository  $repository
     *
     * @return JsonResponse
     */
    public function send(SendMailRequest $request, MailgunMailRepository $repository)
    {
        $mail = $repository->store($request);


        return response()->json(['message' => 'The mail has been queued', 'mail_id' => $mail->id]);
    }

    /**
     * View an existing mail
     *
     * @param  MailgunMail  $mail
     *
     * @return MailgunMailResource
     */
    public function view(MailgunMail $mail)
    {
        return new MailgunMailResource($mail);
    }

    /**
     * @param  MailgunMail  $mail
     *
     * @return JsonResponse
     */
    public function delete(MailgunMail $mail)
    {
        try {
            $mail->delete();

            return response()->json(['message' => 'The mail has been deleted']);
        } catch (Exception $e) {
            return response()->json(['message' => 'Could not delete mail'], 500);
        }

    }
}
