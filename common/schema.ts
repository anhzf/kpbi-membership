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
  alamat: string;
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

export interface Member {
  jenjang: 'S1' | 'S2' | 'S3';
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
