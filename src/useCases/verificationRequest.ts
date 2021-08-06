import fbs, { auth, storage } from 'src/firebaseService';
import { collections, factories } from 'src/firestoreServices';
import type fb from 'firebase';
import type { DocRef } from 'app/common/firestore';
import type { VerificationRequest } from 'app/common/schema';

const storageRef = storage.ref('VERIFICATION-REQUESTS');

type giveReviewPayload = Partial<Pick<VerificationRequest, 'status' | 'message'> & {
  masaBerlaku: Date
}>;
type commonGiveReviewPayload = Omit<giveReviewPayload, 'status'>;

export default class VerificationRequestUseCase {
  // eslint-disable-next-line no-empty-function
  constructor(readonly model: DocRef.VerificationRequestModel) {}

  public declineReview(payload: commonGiveReviewPayload = {}) {
    return this.giveReview({
      ...payload,
      status: 'decline',
    });
  }

  public acceptReview(payload: commonGiveReviewPayload = {}) {
    return this.giveReview({
      ...payload,
      status: 'accept',
    });
  }

  private giveReview({ masaBerlaku, ...payload }: giveReviewPayload) {
    return this.model.update({
      // optional update
      ...(masaBerlaku && { masaBerlaku: fbs.firestore.Timestamp.fromDate(masaBerlaku) }),
      ...payload,
      ...factories.attrs.update(),
    });
  }

  public getDocumentPreviewUrl() {
    const fileRef = storageRef.child(this.model.id);

    return fileRef.getDownloadURL()
      .then((res) => res as string)
      .catch((err: fb.storage.FirebaseStorageError) => {
        if (err.code === 'storage/object-not-found') {
          return undefined;
        }

        throw err;
      });
  }

  public static async create(data: Pick<VerificationRequest, 'masaBerlaku'>, document: File) {
    if (auth.currentUser) {
      const doc = collections.VerificationRequest.doc();
      const uploadedDocument = await VerificationRequestUseCase.uploadDocument(doc.id, document);

      void await doc.set({
        userId: auth.currentUser.uid,
        message: '',
        status: 'pending',
        documentPath: uploadedDocument.ref.fullPath,
        ...data,
        ...factories.attrs.create(),
      });

      return new VerificationRequestUseCase(doc);
    }

    throw new Error('Unauthenticated');
  }

  private static async uploadDocument(id: string, file: File) {
    const snapshot = await storageRef.child(id)
      .put(file);

    return snapshot;
  }
}
