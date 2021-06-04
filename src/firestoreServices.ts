import { collectionNames } from 'app/common/firestore';
import fbs, { db } from 'src/firebaseService';
import type fb from 'firebase';
import type { CollectionRef } from 'app/common/firestore';
import type {
  MemberRegisterRequire, ModelTimestamp,
} from 'app/common/schema';

export const collections = {
  Members: db.collection(collectionNames.members) as CollectionRef.MemberModel,
};

export const factories = {
  attrs: {
    create(): ModelTimestamp {
      const now = fbs.firestore.Timestamp.now();
      return {
        _created: now,
        _updated: now,
        _deleted: null,
      };
    },
    update(): Pick<ModelTimestamp, '_updated'> {
      return {
        _updated: fbs.firestore.Timestamp.now(),
      };
    },
    delete(): Pick<ModelTimestamp, '_deleted'> {
      return {
        _deleted: fbs.firestore.Timestamp.now(),
      };
    },
    restore(): Pick<ModelTimestamp, '_deleted'> {
      return {
        _deleted: null,
      };
    },
  },
};

const registerMember = (user: fb.User, payload: MemberRegisterRequire) => db
  .collection(collectionNames.members)
  .doc(user.uid)
  .set({ ...payload, ...factories.attrs.create() });

const services = {
  registerMember,
};

export default services;
