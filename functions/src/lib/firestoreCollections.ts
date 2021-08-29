import {collectionNames} from '../../../common/firestore';
import {db} from './admin';
import * as fbAdmin from 'firebase-admin';
import type {CollectionRef} from '../../../common/firestore';
import type {ModelTimestamp} from '../../../common/schema';

export const collections = {
  Members: db.collection(collectionNames.members) as CollectionRef.MemberModel<true>,
  LegacyAccountConversions: db.collection(collectionNames.legacyAccountConversions) as CollectionRef.LegacyAccountConversionModel<true>,
};

export const factories = {
  attrs: {
    create(): ModelTimestamp<true> {
      const now = fbAdmin.firestore.Timestamp.now();
      return {
        _created: now,
        _updated: now,
        _deleted: null,
      };
    },
    update(): Pick<ModelTimestamp<true>, '_updated'> {
      return {
        _updated: fbAdmin.firestore.Timestamp.now(),
      };
    },
    delete(): Pick<ModelTimestamp<true>, '_deleted'> {
      return {
        _deleted: fbAdmin.firestore.Timestamp.now(),
      };
    },
    restore(): Pick<ModelTimestamp<true>, '_deleted'> {
      return {
        _deleted: null,
      };
    },
  },
};
