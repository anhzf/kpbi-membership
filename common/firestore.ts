/* eslint-disable @typescript-eslint/no-namespace */
import type fb from 'firebase';
import type * as fbAdmin from 'firebase-admin';
import type { Member, Model, VerificationRequest } from './schema';

export const collectionNames = {
  members: 'MEMBERS',
  verificationRequests: 'VERIFICATION_REQUESTS',
};

export namespace DocRef {
  export type base<T, isNodeCtx = false> = isNodeCtx extends true
    ? fbAdmin.firestore.DocumentReference<Model<T, isNodeCtx>>
    : fb.firestore.DocumentReference<Model<T, isNodeCtx>>;
  export type MemberModel<isNodeCtx = false> = base<Member, isNodeCtx>;
  export type VerificationRequestModel<isNodeCtx = false> = base<VerificationRequest, isNodeCtx>;
}

export namespace CollectionRef {
  export type base<T, isNodeCtx = false> = isNodeCtx extends true
    ? fbAdmin.firestore.CollectionReference<Model<T, isNodeCtx>>
    : fb.firestore.CollectionReference<Model<T, isNodeCtx>>;
  export type MemberModel<isNodeCtx = false> = base<Member, isNodeCtx>;
  export type VerificationRequestModel<isNodeCtx = false> = base<VerificationRequest, isNodeCtx>;
}
