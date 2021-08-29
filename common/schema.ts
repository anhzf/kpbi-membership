/* eslint-disable @typescript-eslint/no-explicit-any */
/* eslint-disable @typescript-eslint/no-unsafe-member-access */
import type fb from 'firebase';
import type * as fbAdmin from 'firebase-admin';

export type FireTimestamp<isNodeCtx = false> = isNodeCtx extends true ? fbAdmin.firestore.Timestamp : fb.firestore.Timestamp

export interface ModelTimestamp<isNodeCtx = false> {
  _updated: FireTimestamp<isNodeCtx>;
  _created: FireTimestamp<isNodeCtx>;
  _deleted: FireTimestamp<isNodeCtx> | null;
}

export type Model<T, isNodeCtx = false> = ModelTimestamp<isNodeCtx> & T;

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

export interface Akreditasi<isNodeCtx = false> {
  prodi: {
    value: akreditasiValue;
    tanggal: FireTimestamp<isNodeCtx>;
    internasional: string;
  };
  perguruanTinggi: akreditasiValue;
}

export interface Kaprodi<isNodeCtx = false> {
  nama: string;
  periode: {
    mulai: FireTimestamp<isNodeCtx>;
    purna: FireTimestamp<isNodeCtx>;
  };
  email: string;
  noHp: string;
}

export type jenjangProdi = 'S1' | 'S2' | 'S3';

export type PTStatus = 'NEGERI' | 'SWASTA';

export interface Member<isNodeCtx = false> {
  jenjang: jenjangProdi;
  namaProdi: string;
  jurusan: string;
  fakultas: string;
  perguruanTinggi: PerguruanTinggi;
  status: PTStatus;
  akreditasi: Akreditasi<isNodeCtx>;
  kaprodi: Kaprodi<isNodeCtx>;
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

export type VerificationRequestStatus = 'accept' | 'decline' | 'pending';

export interface VerificationRequest<isNodeCtx = false> {
  userId: string;
  documentPath: string;
  masaBerlaku: FireTimestamp<isNodeCtx>;
  status: VerificationRequestStatus;
  message?: string;
}

export interface LegacyAccountConversion {
  oldUserId: number;
  newUserId: string;
}
