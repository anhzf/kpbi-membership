/* eslint-disable @typescript-eslint/no-explicit-any */
/* eslint-disable @typescript-eslint/no-unsafe-member-access */
import type fb from 'firebase';

export interface ModelTimestamp {
  _updated: fb.firestore.Timestamp;
  _created: fb.firestore.Timestamp;
  _deleted: fb.firestore.Timestamp | null;
}

export type Model<T> = ModelTimestamp & T;

export type ModelInObject<T> = T & {
  _uid: string;
}

export interface PerguruanTinggi {
  singkatan: string;
  lengkap: string;
  alamat: {
    kota: string;
    provinsi: string;
    alamat: string;
  };
}

export type akreditasiValue = 'A' | 'B' | 'C' | 'Unggul' | 'Baik Sekali' | 'Baik' | 'Belum Terakreditasi';

export interface Akreditasi {
  prodi: {
    value: akreditasiValue;
    tanggal: fb.firestore.Timestamp;
    internasional: string;
  };
  perguruanTinggi: akreditasiValue;
}

export interface Kaprodi {
  nama: string;
  periode: {
    mulai: fb.firestore.Timestamp;
    purna: fb.firestore.Timestamp;
  };
  email: string;
  noHp: string;
}

export type jenjangPT = 'S1' | 'S2' | 'S3';

export interface Member {
  jenjang: jenjangPT;
  namaProdi: string;
  jurusan: string;
  fakultas: string;
  perguruanTinggi: PerguruanTinggi;
  status: 'NEGERI' | 'SWASTA';
  akreditasi: Akreditasi;
  kaprodi: Kaprodi;
  webProdi: string;
  emailProdi: string;
  noHpProdi: string;
}

export interface MemberRegisterRequire {
  jenjang: string;
  namaProdi: string;
  perguruanTinggi: {
    lengkap: string;
    singkatan: string;
  };
  emailProdi: string;
  kaprodi: {
    email: string;
  };
}

export const isValidMemberRegisterRequire = (data: any): data is MemberRegisterRequire => (
  typeof data.jenjang === 'string'
  && typeof data.namaProdi === 'string'
  && typeof data.emailProdi === 'string'
  && typeof data.perguruanTinggi?.lengkap === 'string'
  && typeof data.perguruanTinggi?.singkatan === 'string'
  && typeof data.kaprodi?.email === 'string'
);

export type RequestVerificationStatus = 'accept' | 'decline' | 'pending';

export interface RequestVerification<T = unknown> {
  user: fb.firestore.DocumentReference<T>
  documentPath: string;
  masaBerlaku: fb.firestore.Timestamp;
  status: RequestVerificationStatus;
  message?: string;
}
