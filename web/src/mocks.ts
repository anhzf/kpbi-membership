import { uid } from 'quasar';
import { MemberDetails } from 'src/types/models';

export const members: MemberDetails[] = [
  {
    id: uid(),
    jenjang: 'S1',
    namaProdi: 'Teknik Informatika',
    fakultas: 'Fakultas Teknik',
    namaPT: 'PT. Telkom Indonesia',
    link: 'https://www.telkom.co.id/',
    jurusan: '',
    emailProdi: 'halo@example.org',
    noHpProdi: '08123456789',
    akreditasi: {
      value: 'A',
      tanggal: new Date('2019-01-01'),
      internasional: '-',
    },
    ptId: uid(),
    kaprodiId: uid(),
    perguruanTinggi: {
      singkatan: 'Telkom',
      lengkap: 'PT. Telkom Indonesia',
      status: 'SWASTA',
      alamat: {
        kota: 'Jakarta',
        provinsi: 'DKI Jakarta',
        alamat: 'Jl. Kebon Sirih',
      },
      img: 'https://i1.wp.com/uns.ac.id/id/wp-content/uploads/logo-uns-biru.png?resize=150%2C150&ssl=1',
      akreditasi: 'A',
    },
    kaprodi: {
      nama: 'Halo',
      email: 'halo@telkom.co.id',
      img: 'https://thispersondoesnotexist.com/image',
      noHp: '08123456789',
      periode: {
        mulai: new Date('2019-01-01'),
        purna: new Date('2022-01-01'),
      },
    },
    createdAt: new Date(),
    updatedAt: new Date(),
    deletedAt: null,
  },
];
