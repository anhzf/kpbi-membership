import { FetchError } from 'src/utils/errors';

interface PdfGetUrlOptions extends Record<string, unknown> {
  waitEvent?: boolean;
}

const DEFAULT_PDF_GET_URL_OPTIONS = <PdfGetUrlOptions>{
  waitEvent: true,
  waitEventTimeout: 60_000,
};

export const pdfGetUrl = async (documentPath: string, options?: PdfGetUrlOptions) => {
  const { ...opts } = { ...DEFAULT_PDF_GET_URL_OPTIONS, ...options };
  const query = new URLSearchParams({
    ...Object.fromEntries(
      Object.entries(opts)
        .map(([k, v]) => [k, String(v)]),
    ),
    url: `${import.meta.env.VITE_APP_URL}/document/${documentPath}`,
  });

  const response = await fetch(`${import.meta.env.VITE_PDF_SERVICE_ENDPOINT}?${query.toString()}`);

  if (!response.ok) throw new FetchError(response);

  const blob = await response.blob();
  return URL.createObjectURL(blob);
};
