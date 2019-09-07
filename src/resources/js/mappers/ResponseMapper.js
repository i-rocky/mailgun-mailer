import Response from '../models/Response';

export default {
  mapSuccessResponse(response) {
    const mappedResponse = new Response(
        response.status,
        response.data.message || null,
        response.data.data || response.data,
    );
    if (response.data.meta) {
      mappedResponse.meta = response.data.meta;
    }
    if (response.data.links) {
      mappedResponse.links = response.data.links;
    }
    return mappedResponse;
  },
  mapErrorResponse(error) {
    if (error.response) {
      const {response} = error;
      return new Response(
          response.status,
          response.data.message ? response.data.message : (response.data.data && response.data.data.message ? response.data.data.message : null),
          response.data.errors
              ? response.data.errors
              : response.data.data && response.data.data.errors
              ? response.data.data.errors
              : response.data,
      );
    }
    return new Response(null, error.message, null);
  },
};
