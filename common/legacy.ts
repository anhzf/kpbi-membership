/* eslint-disable camelcase */
import type { akreditasiValue, jenjangProdi } from './schema';

export interface LegacyProfile {
  akreditasi_prodi: {
    akreditasi: akreditasiValue;
    internasional: string | null;
    tanggal: string;
  };
  akreditasi_pt: string | null;
  alamat_kampus: {
    alamat: string | null;
    kota: string | null;
    provinsi: string | null;
  }
  created_at: string;
  email_prodi: string;
  fakultas: string | null;
  id: number;
  jenjang: jenjangProdi;
  jurusan: string | null;
  kaprodi: {
    email: string;
    nama: string | null;
    no: string | null;
    periode: {
      mulai: string;
      purna: string;
    };
  };
  kaprodiImg_src: string;
  kaprodi_img: 8;
  nama_prodi: string;
  no_telp_prodi: string | null;
  pt: {
    lengkap: string;
    singkat: string;
  };
  ptImg_src: string;
  pt_icon: number;
  status: string;
  updated_at: string;
  user_id: number;
  warn: string;
  web_prodi: string | null;
}
