import { api } from 'src/boot/axios';
import type { Document } from 'src/types/models';

const ENDPOINT = '/documents';

export interface DocumentGet {
  (id: string): Promise<Document>;
}

export interface DocumentUpdate {
  (id: string, payload: Record<string, unknown>): Promise<Document>;
}

export interface DocumentGetByEntityId {
  (entityType: 'membership' | 'invoice', entityId: string): Promise<Document>;
}

export const documentGet: DocumentGet = async (id) => {
  const { data: { data } } = await api.get<{ data: Document; }>(`${ENDPOINT}/${id}`);
  return data;
};

export const documentUpdate: DocumentUpdate = async (id, payload) => {
  const { data: { data } } = await api.put<{ data: Document; }>(`${ENDPOINT}/${id}`, { payload });
  return data;
};

/**
 * Get document by entity ID (for backward compatibility during transition)
 * This fetches the entity first, then gets its associated document
 */
export const documentGetByEntityId: DocumentGetByEntityId = async (entityType, entityId) => {
  let documentId: string;

  if (entityType === 'membership') {
    // Get membership to find its document_id
    const { data: membership } = await api.get(`/member/${entityId}`);
    documentId = membership.document_id;
  } else if (entityType === 'invoice') {
    // Get invoice to find its document_id
    const { data: invoice } = await api.get(`/invoice/${entityId}`);
    documentId = invoice.document_id;
  } else {
    throw new Error(`Unsupported entity type: ${entityType}`);
  }

  if (!documentId) {
    throw new Error(`No document found for ${entityType} ${entityId}`);
  }

  return documentGet(documentId);
};

// Legacy compatibility functions - these will be removed in phase 5
export const getInvoiceDocument = (invoiceId: string) => documentGetByEntityId('invoice', invoiceId);
export const getMembershipDocument = (memberId: string) => documentGetByEntityId('membership', memberId);