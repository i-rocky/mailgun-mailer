<?php

namespace Rocky\MailgunMailer\Http\Controllers\Api;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Rocky\MailgunMailer\Http\Requests\Template\StoreRequest;
use Rocky\MailgunMailer\Http\Requests\Template\UpdateRequest;
use Rocky\MailgunMailer\Http\Resources\MailTemplateResource;
use Rocky\MailgunMailer\Models\MailTemplate;
use Rocky\MailgunMailer\Repositories\MailTemplateRepository;

class TemplateController
{
    /**
     * get list of templates
     *
     * @param  Request  $request
     * @param  MailTemplateRepository  $repository
     *
     * @return AnonymousResourceCollection
     */
    public function index(Request $request, MailTemplateRepository $repository)
    {
        $templates = $repository->search($request);

        return MailTemplateResource::collection($templates);
    }

    /**
     * Store a new record
     *
     * @param  StoreRequest  $request
     * @param  MailTemplateRepository  $repository
     *
     * @return JsonResponse
     */
    public function store(StoreRequest $request, MailTemplateRepository $repository)
    {
        $template = $repository->store($request);

        return response()->json(['message' => 'New mail template has been saved', 'template_id' => $template->id]);
    }

    /**
     * Show a mail template resource
     *
     * @param  MailTemplate  $template
     *
     * @return MailTemplateResource
     */
    public function view(MailTemplate $template)
    {
        return new MailTemplateResource($template);
    }

    /**
     * @param  MailTemplate  $template
     * @param  UpdateRequest  $request
     * @param  MailTemplateRepository  $repository
     *
     * @return JsonResponse
     */
    public function update(MailTemplate $template, UpdateRequest $request, MailTemplateRepository $repository)
    {
        $repository->update($template, $request);

        return response()->json(['message' => 'Mail template has been updated']);
    }

    /**
     * @param  MailTemplate  $template
     *
     * @return JsonResponse
     */
    public function delete(MailTemplate $template)
    {
        try {
            $template->delete();

            return response()->json(['message' => 'Mail template has been deleted']);
        } catch (Exception $e) {
            return response()->json(['message' => 'Could not delete mail template'], 500);
        }
    }
}
