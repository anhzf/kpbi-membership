import type { Accreditation } from 'src/types/models';

export interface AccreditationStorePayload
  extends Pick<Accreditation, 'label' | 'value' | 'valid_from' | 'valid_until'> {
  entity: string;
  entity_id: string;
}

export interface AccreditationStore {
  (payload: AccreditationStorePayload): Promise<string>;
}

export interface AccreditationUpdatePayload
  extends Partial<Pick<Accreditation, 'label' | 'value' | 'valid_from' | 'valid_until'>> {
  id: string;
}

export interface AccreditationUpdate {
  (payload: AccreditationUpdatePayload): Promise<void>;
}

export interface AccreditationDestroy {
  (id: string): Promise<void>;
}
