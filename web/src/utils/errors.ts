export class FetchError extends Error {
  constructor(response: Response) {
    super(
      response.statusText || `${response.status} Error`,
      { cause: response },
    );
  }
}
