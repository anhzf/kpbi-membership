/* eslint-disable @typescript-eslint/no-namespace */
import type fb from 'firebase';
import type { Member, Model, VerificationRequest } from 'app/common/schema';

export const collectionNames = {
  members: 'MEMBERS',
  verificationRequests: 'VERIFICATION_REQUESTS',
};

export namespace DocRef {
  export type base<T> = fb.firestore.DocumentReference<Model<T>>;
  export type MemberModel = base<Member>;
  export type VerificationRequestModel = base<VerificationRequest>;
}

export namespace CollectionRef {
  export type base<T> = fb.firestore.CollectionReference<Model<T>>;
  export type MemberModel = base<Member>;
  export type VerificationRequestModel = base<VerificationRequest>;
}
