import type { Invoice, InvoiceDocumentPayload } from 'src/types/models';

export interface InvoiceGet {
  (id: string): Promise<Invoice>;
}

export interface InvoiceList {
  (): Promise<Invoice[]>;
}

export interface InvoiceGetDocumentPayload {
  (id: string): Promise<InvoiceDocumentPayload>;
}
