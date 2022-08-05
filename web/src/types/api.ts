export interface APIDataResponse<T> {
  data: T;
  message: string;
  errors: any[];
}
