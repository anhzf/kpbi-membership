/* eslint-disable @typescript-eslint/no-namespace */
import type fb from 'firebase';
import type { Member, Model } from 'app/common/schema';

export const collectionNames = {
  members: 'MEMBERS',
};

export namespace DocRef {
  export type base<T> = fb.firestore.DocumentReference<Model<T>>;
  export type MemberModel = DocRef.base<Member>;
}

export namespace CollectionRef {
  export type base<T> = fb.firestore.CollectionReference<Model<T>>;
  export type MemberModel = CollectionRef.base<Member>;
}
