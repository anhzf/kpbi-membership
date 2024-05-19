import type { Accreditation } from 'src/types/models';

export interface AccreditationStorePayload
  extends Pick<Accreditation, 'label' | 'value' | 'valid_from' | 'valid_until'> {
  entity: string;
  entity_id: string;
}

export interface AccreditationStore {
  (payload: AccreditationStorePayload): Promise<string>;
}
