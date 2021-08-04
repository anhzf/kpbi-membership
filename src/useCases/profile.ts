import { storage } from 'src/firebaseService';
import { factories } from 'src/firestoreServices';
import type fb from 'firebase';
import type { Member, Model } from 'app/common/schema';
import type { DocRef } from 'app/common/firestore';

const storageRef = storage.child('profile');

export default class ProfileUseCase {
  private static pTPhotoFilename = 'Pt'

  private static kaprodiPhotoFilename = 'Kaprodi'

  // eslint-disable-next-line no-unused-vars, no-empty-function
  constructor(private model: DocRef.MemberModel) {}

  getPTPhoto() {
    return this.getFile(ProfileUseCase.pTPhotoFilename);
  }

  getKaprodiPhoto() {
    return this.getFile(ProfileUseCase.kaprodiPhotoFilename);
  }

  getFile(name: string) {
    const filename = this.buildUploadedFilename(name);
    const fileRef = storageRef.child(filename);

    return fileRef.getDownloadURL()
      .then((res) => res as string)
      .catch((err: fb.storage.FirebaseStorageError) => {
        if (err.code === 'storage/object-not-found') {
          return undefined;
        }

        throw err;
      });
  }

  update(attrs: Partial<Model<Member>>) {
    return this.model.update({
      ...attrs,
      ...factories.attrs.update(),
    });
  }

  updatePTPhoto(file: File) {
    return this.updatePhoto(ProfileUseCase.pTPhotoFilename, file);
  }

  updateKaprodiPhoto(file: File) {
    return this.updatePhoto(ProfileUseCase.kaprodiPhotoFilename, file);
  }

  private async updatePhoto(name: string, file: File) {
    const uploadedFilename = this.buildUploadedFilename(name);
    const snapshot = await storageRef
      .child(uploadedFilename)
      .put(file);

    return snapshot;
  }

  private buildUploadedFilename(name: string) {
    return `${this.model.id}_${name}`;
  }
}
