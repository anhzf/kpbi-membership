import type { Invoice } from 'src/types/models';

export interface InvoiceGet {
  (id: string): Promise<Invoice>;
}
