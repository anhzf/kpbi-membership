import { storage } from 'src/firebaseService';
import { factories, jsonDateToTimestamp } from 'src/firestoreServices';
import type fb from 'firebase';
import type { Member, Model } from 'app/common/schema';
import type { DocRef } from 'app/common/firestore';
import type { LegacyProfile } from 'app/common/legacy';

const storageRef = storage.ref('PROFILES');

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

  static legacyProfileConverter(data: LegacyProfile) {
    return {
      akreditasi: {
        perguruanTinggi: data.akreditasi_pt ?? 'Belum Terakreditasi',
        prodi: {
          value: data.akreditasi_prodi.akreditasi ?? 'Belum Terakreditasi',
          tanggal: jsonDateToTimestamp(data.akreditasi_prodi.tanggal),
          internasional: data.akreditasi_prodi.internasional ?? '',
        },
      },
      emailProdi: data.email_prodi,
      fakultas: data.fakultas ?? '',
      jenjang: data.jenjang,
      jurusan: data.jurusan ?? '',
      kaprodi: {
        email: data.kaprodi.email,
        nama: data.kaprodi.nama ?? '',
        noHp: data.kaprodi.no ?? '',
        periode: {
          mulai: jsonDateToTimestamp(data.kaprodi.periode.mulai),
          purna: jsonDateToTimestamp(data.kaprodi.periode.purna),
        },
      },
      namaProdi: data.nama_prodi,
      noHpProdi: data.no_telp_prodi ?? '',
      perguruanTinggi: {
        alamat: {
          alamat: data.alamat_kampus.alamat ?? '',
          kota: data.alamat_kampus.kota ?? '',
          provinsi: data.alamat_kampus.provinsi ?? '',
        },
        lengkap: data.pt.lengkap,
        singkatan: data.pt.singkat,
      },
      status: data.status,
      webProdi: data.web_prodi ?? '',
    };
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
