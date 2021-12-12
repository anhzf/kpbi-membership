import { AKREDITASI_STATUS, JENJANG_PRODI, PT_STATUS } from 'src/constants';

export interface BaseModel {
  id: string;
  createdAt: Date;
  updatedAt: Date;
  deletedAt: Date | null;
}

export type AkreditasiStatus = typeof AKREDITASI_STATUS[number];

export interface AkreditasiProdi {
  value: AkreditasiStatus;
  tanggal: Date;
  internasional: string;
}

export interface Kaprodi {
  nama: string;
  img: string;
  periode: {
    purna: Date;
    mulai: Date;
  };
  email: string;
  noHp: string;
}

export interface PerguruanTinggi {
  singkatan: string;
  lengkap: string;
  img: string;
  alamat: {
    kota: string;
    provinsi: string;
    alamat: string;
  };
  akreditasi: AkreditasiStatus;
}

export type JenjangProdi = typeof JENJANG_PRODI[number];

export type PTStatus = typeof PT_STATUS[number];

export interface Member extends BaseModel {
  jenjang: JenjangProdi;
  namaProdi: string;
  jurusan: string;
  fakultas: string;
  namaPT: string;
  link: string;
}

export interface MemberProfile extends Member {
  emailProdi: string;
  noHpProdi: string;
  status: PTStatus;
  akreditasi: AkreditasiProdi;
  ptId: string;
  kaprodiId: string;
}

export interface MemberDetailed extends MemberProfile {
  perguruanTinggi: PerguruanTinggi;
  kaprodi: Kaprodi;
}
